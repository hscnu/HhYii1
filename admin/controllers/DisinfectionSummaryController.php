<?php

class DisinfectionSummaryController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionDelete($id) {
        put_msg(15);
        parent::_clear($id);
    }


    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }


    function saveData($model, $post) {
        $model->attributes = $post;
        //   put_msg($post);
        //  put_msg($model->attributes);

        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,disinfection_center_id,start_date,restaurant_name,end_date,disinfection_center_name,total_price,complete_date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,disinfection_center_id,start_date,restaurant_name,end_date,disinfection_center_name,total_price,complete_date',$keywords);
        $criteria->addCondition($this->userCodition());
        $data = array();
        $data['UserUnitName'] = $this->getUserUnitName();
        parent::_list($model, $criteria, 'index', $data);
    }
    //删除无用明细
    public function actionDeleteUselessDetail()
    {
        $db = Yii::app()->db;
        $sql = "DELETE  FROM `disinfection_order_detail` WHERE order_id not in (SELECT id FROM `disinfection_order` WHERE state >0)";
        $command = $db->createCommand($sql);
        show_status($command->execute(), '成功删除', get_cookie('_currentUrl_'), '没有多余的记录');
    }
    //生成汇总
    public function actionCreateSummary($start_date='',$end_date='',$disinfect_center=''){
        $unit = $this->getUserUnit();
        $criteria = new CDbCriteria;
        $criteria->condition="disinfection_name='".$disinfect_center."'";
        $criteria->condition=get_where($criteria->condition,($unit!=""),'restaurant_id=',$unit,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'appoint_time>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'appoint_time<=',$end_date,'"');
        $disinfectionOrders = DisinfectionOrder::model()->findAll($criteria);
        if($disinfectionOrders){
            $modelName = $this->model;
            $model = new $modelName('create');
            $model['restaurant_id'] = $unit;
            $model['restaurant_name'] = Restaurant::model()->getNameFromId($model['restaurant_id']);
            $model['disinfection_center_name'] = $disinfect_center;
            $model['disinfection_center_id'] = DisinfectionCenter::model()->getIdFromName($disinfect_center);
            $model['start_date'] = $start_date;
            $model['end_date'] = $end_date;
            $model->save();
            $total_price=0;
            foreach ($disinfectionOrders as $order){
                //put_msg($d->disinfection_name);
                $total_price += $this->createSummaryDetail($model->id,$order);

                //汇总其他字段
            }
            $model['total_price']=$total_price;
            $model->save();
            echo CJSON::encode(array('data'=>false));
        }
        else{
            echo CJSON::encode(array('data'=>true));
        }
    }
    //生成汇总明细
    public function createSummaryDetail($summary_id,$order){
        $modelName='DisinfectionSummaryDetail';
        $model=new $modelName('create');
        $model['date']=$order->appoint_time;
        $orderDetails=DisinfectionOrderDetail::model()->findAll("order_id='".$order->id."'");
        $total_price=0;
        foreach ($orderDetails as $orderDetail){
            $model['summary_id']=$summary_id;
            $model['tableware_name']=$orderDetail->tableware_name;
            $model['number']=$orderDetail->number;
            $model['cost']=$orderDetail->cost;
            $model['total_price']=$orderDetail->total_cost;
            $total_price+=$orderDetail->total_cost;
        }
        $model->save();
        return $total_price;
    }
    //获取用户所属单位
    function getUserUnit(){
        $userId=get_session('userId');
        $tmp=User::model()->find('userId='.$userId);
        if($tmp){
            return $tmp->unitId;
        }
    }
    //汇总明细窗口
    public function getOrderKeyWords($keywords){
        return  get_like('1','summary_id',$keywords);
    }
    public function actionOpenSummaryDetail($order_id){

        $model = DisinfectionSummaryDetail::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getOrderKeyWords($order_id);
        $data=array();
        parent::_list($model, $criteria, 'detail', $data);//渲染detail
    }
    //汇总明细窗口end
    //角色筛选
    public function getUserUnitName(){
        $unitId=$this->getUserUnit();
        $flag=$unitId[0];
        $name='未知';
        if($flag=='R'){
            $temp=Restaurant::model()->find("r_code='".$unitId."'");
            if($temp){
                $name=$temp->r_name;
            }
        }
        elseif ($flag=='D'){
            $temp=DisinfectionCenter::model()->find("code='".$unitId."'");
            if($temp){
                $name=$temp->name;
            }
        }
        return $name;
    }
    public function userCodition(){
        $unitId=$this->getUserUnit();
        $unitName=$this->getUserUnitName();
        $flag=$unitId[0];
        if($flag=='R'){
            return "restaurant_name='".$unitName."'";
        }
        elseif ($flag=='D'){
            return "disinfection_center_name='".$unitName."'";
        }
        else return '';
    }
}