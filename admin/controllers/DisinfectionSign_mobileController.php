<?php

class DisinfectionSign_mobileController extends BaseController {

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
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    //签收
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'DisinfectionOrder';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $state1=10;//待签收
        $state2=11;//已签收
        $criteria->condition=get_where($criteria->condition,($state1!=""),'state>=',$state1,'"');
        $criteria->condition=get_where($criteria->condition,($state2!=""),'state<=',$state2,'"');
        $data = $this->getAppointCountList();
        parent::_list($model, $criteria, 'index', $data);
    }
    public function getAppointCountList(){
        $modelName = 'DisinfectionOrder';

        $todayCount = count($modelName::model()->findAll('state=1'));
        $waitCount = count($modelName::model()->findAll('state=2'));
        $finishCount = count($modelName::model()->findAll('state=3'));
        $waitSignCount = count($modelName::model()->findAll('state=10'));
        $signedCount = count($modelName::model()->findAll('state=11'));
        $IExamine = count($modelName::model()->findAll('state=12'));
        $FExamine = count($modelName::model()->findAll('state=4'));
        $deliver_wait = count($modelName::model()->findAll('state=13'));
        //配送用户判断
        if($this->deliverJudge()){
            $delivering1 = count($modelName::model()->findAll('state=16'));
            $delivered=count($modelName::model()->findAll('state=15'));
            $delliverAll=$delivering1+$delivered;
        }
        else{
            $delivering1 = count($modelName::model()->findAll('state=17'));
            $delivered=count($modelName::model()->findAll('state=10'));
            $delliverAll=$delivering1+$delivered;
        }

        $deliver_finish = count($modelName::model()->findAll('state=10'));
        $AllSignCount = $waitSignCount+$signedCount;
        return array(
            'todayCount'=>$todayCount,
            'waitCount'=>$waitCount,
            'finishCount'=>$finishCount,
            'waitSignCount'=>$waitSignCount,
            'signedCount'=>$signedCount,
            'IExamineCount'=>$IExamine,
            'FExamineCount'=>$FExamine,
            'deliverwaitCount' => $deliver_wait,
            'deliverfinishCount' => $deliver_finish,
            'AllSignCount'=>$AllSignCount,
            'delivering1'=>$delivering1,
            'delivered'=>$delivered,
            'delliverAll'=>$delliverAll,
        );
    }

    public function getDisinfectionKeyWords($keywords = ''){
        return get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
    }

    public function actionIndex_by_condition($next_index,$keywords = '',$w='',$nowType='None',$deliveredType='',$istoday=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = DisinfectionOrder::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getDisinfectionKeyWords($keywords);
        if($w){
            $criteria -> addCondition($w);
        }
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $data = $this->getAppointCountList();
        $data['istoday']=$istoday;
        $data['nowType']=$nowType;
        $data['deliveredType']=$deliveredType;

        parent::_list($model, $criteria, $next_index, $data);
    }
    //酒楼待签收
    public function actionIndex_wait_sign($keywords = '') {
        $w="state=10";
        $this->actionIndex_by_condition('index',$keywords,$w);
    }
    //酒楼已签收
    public function actionIndex_signed($keywords = '') {
        $w="state=11";
        $this->actionIndex_by_condition('index',$keywords,$w);
    }

    ////配送
    public function deliverJudge(){
        $unitCode=$this->getUserUnit();
        $order = Restaurant::model()->findAll("id>0");//找订单
        $flag=false;
        foreach ($order as $o){
            if($unitCode==$o->r_code) $flag=true;
        }
        return $flag;
    }
    public function actiondeliver_index($keywords = ''){
        //用户判断，选择对应配送
        $w='';
        if($this->deliverJudge()){
            $w="state=16";
            $this->actiondeliver_index1($w);
        }
        else{
            $w="state=17";
            $this->actiondeliver_index2($w);
        }
    }
    //酒楼到中心
    public function actiondeliver_index1($w='',$keywords = ''){
        $nowType='deliver_index1';
        $deliveredType='delivered1';
        $w="state=16";
        $this->actionIndex_by_condition('deliver_index',$keywords,$w,$nowType,$deliveredType);
    }
    public function actiondelivered1($keywords = ''){
        $nowType='deliver_index1';
        $w="state=15";
        $deliveredType='delivered1';
        $this->actionIndex_by_condition('deliver_index',$keywords,$w,$nowType,$deliveredType);
    }
     //中心送往酒楼
    public function actiondeliver_index2($w='',$keywords = ''){
        $nowType='deliver_index2';
        $w="state=17";
        $this->actionIndex_by_condition('deliver_index',$keywords,$w,$nowType);
    }
    public function actiondelivered2($keywords = ''){
        $nowType='deliver_index2';
        $w="state=15";
        $deliveredType='delivered2';
        $this->actionIndex_by_condition('deliver_index',$keywords,$w,$nowType,$deliveredType);
    }
    //配送、明细页面
    public function actiondeliver_detail($id,$keywords = ''){
        $modelName = 'DisinfectionOrder';
        $order_model =$this->loadModel($id,$modelName);
        $model = DisinfectionOrderDetail::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getOrderDetailKeyWords($id);
        $data = array();
        $data['order_model']=$order_model;
        parent::_list($model, $criteria, 'deliver_detail', $data);//渲染detail
    }

    public function getOrderDetailKeyWords($keywords){
        return  get_like('1','order_id',$keywords);
    }

    //签收、明细页面
    public function actiondetail($id,$keywords = ''){
        $modelName = 'DisinfectionOrder';
        $order_model =$this->loadModel($id,$modelName);
        $model = DisinfectionOrderDetail::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getOrderDetailKeyWords($id);
        $data = array();
        $data['order_model']=$order_model;
        parent::_list($model, $criteria, 'detail', $data);//渲染detail
    }

    public function actionsign($id){
        $modelName = 'DisinfectionOrder';
        $order_model =$this->loadModel($id,$modelName);
        if($order_model['state']==10){
            $order_model['state']=11;
            $order_model->save();
        }
        echo CJSON::encode(array('yes'=>'yes'));
        //$this->actionindex();
    }
    //配送中按钮
    public function actiondelivering($id){
        $modelName = 'DisinfectionOrder';
        $order_model =$this->loadModel($id,$modelName);
        if($order_model['state']==16){
            $order_model['state']=15;
            $order_model->save();
        }
        elseif ($order_model['state']==17){
            $order_model['state']=10;
            $order_model->save();
        }
        echo CJSON::encode(array('yes'=>'yes'));
        //$this->actionindex();
    }
    //获取用户所属单位
    function getUserUnit(){
        $userId=get_session('userId');
        $tmp=User::model()->find('userId='.$userId);
        if($tmp){
            return $tmp->unitId;
        }
    }
}