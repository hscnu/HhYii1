<?php

class DisinfectionOrderController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionDelete($id) {
        parent::_clear($id);
    }


    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $model->check_save=0;
        $model->save();
        $this->actionUpdate($model->id);
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $detailList=DisinfectionOrderDetail::model()->findAll('order_id='.$id);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['detailList'] = $detailList;
            $this->render('update', $data);
        } else {

            $this->saveData($model, $_POST[$modelName]);
        }
    }


    function saveData($model, $post) {
        $model->attributes = $post;
//识别用户单位
        $userId=get_session('userId');
        $tmp=User::model()->find('userId='.$userId);
        if($tmp){
            $resId=$tmp->unitId;
            $model['restaurant_id']=$resId;
            $model['restaurant_name']=Restaurant::model()->getNameFromId($model['restaurant_id']);
        }
        if($model['state']==0){
            $model['state']=1;
        }
//测试
        $model['disinfection_id']=DisinfectionCenter::model()->getIdFromName($model['disinfection_name']);

        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        ///测试
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        ///测试end
//        $userId=get_session('userId');
//        $tmp=User::model()->find('userId='.$userId);
//        if($tmp){
//            $resId=$tmp->unitId;
//            $criteria ->addCondition('restaurant_id='.$resId);
//        }

        $model->deleteAll('state'.' in (' . 0 . ')');

        $data = $this->getAppointCountList();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionOpenDialog(){

        $modelName='DisinfectionOrderDetail';
        $detail_id=DecodeAsk('detail_id');
        if($detail_id){
            $model=$this->loadModel($detail_id,$modelName);
        }
        else{
            $model = new DisinfectionOrderDetail();
            $model->order_id=DecodeAsk('order_id');
        }

        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['isClose'] = DecodeAsk('isClose');
            $this->render('update_detail', $data);
        }else {
            $this->Save_detail($model, $_POST['DisinfectionOrderDetail']);
        }
    }

    public function Save_detail($model, $post) {
        $model->attributes = $post;
        $url=Yii::app()->request->getUrl().'&isClose=1';
        show_status($model->save(), '保存成功',$url, '保存失败');
    }



    public function actionSaveFormDate($id){
        $model=$this->loadModel($id,$this->model);
        $model->check_save=0;
        $model->attributes = $_REQUEST[$this->model];
        $model->save();
    }
    /////导航栏

    public function actionIndex_by_condition($keywords = '',$w='',$istoday=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;

        $criteria -> condition = $this->getDisinfectionKeyWords($keywords);

        if($w){
            $criteria -> addCondition($w);
        }
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $data = $this->getAppointCountList();
        $data['istoday']=$istoday;
        parent::_list($model, $criteria, 'index', $data);
    }


    //申请中
    public function actionIndex_appoint($keywords = '') {
        $w="state=1";
        $this->actionIndex_by_condition($keywords,$w,1);
    }

    //已提交
    public function actionIndex_appoint_wait($keywords = '') {
        $w="state=2";
        $this->actionIndex_by_condition($keywords,$w);
    }

    //待审核
    public function actionIndex_appoint_finish($keywords = '') {
        $w="state=3";
        $this->actionIndex_by_condition($keywords,$w);
    }

    public function getAppointCountList(){

        $todayCount = count(DisinfectionOrder::model()->findAll('state=1'));
        $waitCount = count(DisinfectionOrder::model()->findAll('state=2'));
        $finishCount = count(DisinfectionOrder::model()->findAll('state=3'));
        return array(
            'todayCount'=>$todayCount,
            'waitCount'=>$waitCount,
            'finishCount'=>$finishCount,
        );
    }
    public function getDisinfectionKeyWords($keywords = ''){
        put_msg($keywords);
        return get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
    }

    //////导航栏end
    /// 查看明细
    public function actionGetOrderDetails($oId,$shrId){
        //$shr=User::model()->find('userId='.$shrId);//根据送货人ID找到该用户信息
        $order=DisinfectionOrderDetail::model()->findAll("id in (".$oId.")");//找订单
        put_msg(11);
        if($order){
            /*foreach ($order as $v){
                $v->deliver_id=$shrId;//填入送货人信息
                $v->deliver_name=$shr->TCNAME;
                $v->deliver_tel=$shr->PHONE;
                $v->order_state='已派送';//修改状态
               // $v->save();
            }*/

        }
        echo CJSON::encode('succeed');
    }

    public function getOrderKeyWords($keywords){
        return  get_like('1','order_id',$keywords);
    }


    public function actionOpenDialogOrder($keywords='',$Id=0){
        //put_msg($Id);
        $model = DisinfectionOrderDetail::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getOrderKeyWords($Id);
        $data = array();
        parent::_list($model, $criteria, 'detail', $data);//渲染detail
    }
    /// 查看明细end
}