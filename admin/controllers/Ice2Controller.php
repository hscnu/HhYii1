<?php

class Ice2Controller extends BaseController {

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


    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }


    public function getIndexCriteria($keywords,$w){
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        if($w){
            $criteria -> addCondition($w);
        }
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'order_time',$start_date);
        return $criteria;
    }


    public function setCookieAndGetModel(){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        return $modelName::model();
    }


    public function actionIndex_appoint_by_condition($keywords = '',$w='') {
        $model=$this->setCookieAndGetModel();
        $criteria=$this->getIndexCriteria($keywords,$w);
        $data = $this->getAppointCountList();
        $data['istoday']=DecodeAsk('is_today');
        parent::_list($model, $criteria, 'index_appoint', $data);
    }


    public function actionIndex_dealOrder_by_condition($keywords = '',$w='') {
        $model=$this->setCookieAndGetModel();
        $criteria=$this->getIndexCriteria($keywords,$w);
        $data = $this->getDealOrderCountList();
        $data['istoday']=DecodeAsk('is_today');
        parent::_list($model, $criteria, 'index_dealOrder', $data);
    }


    //待选择送冰员
    public function actionIndex_appoint_wait($keywords = '') {
        $w="order_state='已确认订单'";
        $this->actionIndex_appoint_by_condition($keywords,$w);
    }


    //已选择送冰员
    public function actionIndex_appoint_finish($keywords = '') {
        $w="order_state='已选送冰员'";
        $this->actionIndex_appoint_by_condition($keywords,$w);
    }



    //今日预约
    public function actionIndex_dealOrder_today($keywords = '') {
        $w=get_like(1,'order_time',Date('Y-m-d'));
        $this->actionIndex_dealOrder_by_condition($keywords,$w,1);
    }


    //待确认订单
    public function actionIndex_dealOrder_wait($keywords = '') {
        $w="order_state='已新增订单'";
        $this->actionIndex_dealOrder_by_condition($keywords,$w);
    }


    //已确认订单
    public function actionIndex_dealOrder_finish($keywords = '') {
        $w="order_state='已确认订单'";
        $this->actionIndex_dealOrder_by_condition($keywords,$w);
    }


    public function getAppointCountList(){
        $date=array();
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
//        $criteria -> condition= get_like('1','order_time',Date('Y-m-d'));
//        $date['todayApCount']= $model->count($criteria);
        $date['waitApCount']= $model->count("order_state='已确认订单'");
        $date['finishApCount']= $model->count("order_state='已选送冰员'");
        return $date;
    }


    public function getDealOrderCountList(){
        $date=array();
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition= get_like('1','order_time',Date('Y-m-d'));
        $date['todayDoCount']= $model->count($criteria);
        $date['waitDoCount']= $model->count("order_state='已新增订单'");
        $date['finishDoCount']= $model->count("order_state='已确认订单'");
        return $date;
    }


    public function actionIndex_logistic($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }


    public function getIceKeyWords($keywords){
        return  get_like('1','id,order_name,order_tel,order_time,ice_amount,order_remark,order_time',$keywords);
    }


    public function actionSetShrIdAndName($oId,$shrId){
        $shr=User::model()->find('userId='.$shrId);
        $order=Ice2::model()->findAll("id in (".$oId.")");
        if($order){
            foreach ($order as $v){
                $v->deliver_id=$shrId;
                $v->deliver_name=$shr->TCNAME;
                $v->deliver_tel=$shr->PHONE;
                $v->order_state='已选送冰员';
                $v->save();
            }
        }
        echo CJSON::encode('succeed');
    }


    public function getUserKeyWords($keywords){
        return  get_like('1','TCNAME',$keywords);
    }


    public function actionOpenDialogShr($keywords=''){
        $model = User::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getUserKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'select', $data);
    }


    public function actionConfirmOrder($id){
    $tmp=$this->loadModel($id,$this->model);
    $tmp->order_state='已确认订单';
    $tmp->save();
    echo '<script>window.history.back()</script>';
    }



}