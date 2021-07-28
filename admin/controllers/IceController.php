<?php

class IceController extends BaseController {

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

    //渔民预约冰页面
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = $this->getAppointCountList();

        parent::_list($model, $criteria, 'index', $data);
    }
    //审核页面
    public function actionIndex_examine($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $action=strtolower(Yii::app()->controller->getAction()->id);//获取当前action名
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = $this->getAppointCountList();
        $data["action"]=$action;
        parent::_list($model, $criteria, 'index_examine', $data);
    }
    //物流人员业务页面
    public function actionIndex_logistic($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = $this->getAppointCountList();
        parent::_list($model, $criteria, 'index_logistic', $data);
    }
    //派送订单页面
    public function actionIndex_appointing($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'index_appointing', $data);
    }

    public function getIceKeyWords($keywords){
        return  get_like('1','id,order_name,order_tel,order_time,ice_amount,order_remark,order_time',$keywords);
    }
    //选择派送人员
    public function actionSetShrIdAndName($oId,$shrId){
        $shr=User::model()->find('userId='.$shrId);
        $order=Ice::model()->findAll("id in (".$oId.")");
        if($order){
            foreach ($order as $v){
                $v->deliver_id=$shrId;
                $v->deliver_name=$shr->TCNAME;
                $v->deliver_tel=$shr->PHONE;
                $v->order_state=5;
                $v->save();
            }
        }
        echo CJSON::encode('succeed');
    }
    //获取用户keyword
    public function getUserKeyWords($keywords){
        return  get_like('1','TCNAME',$keywords);
    }
    //打开弹出框
    public function actionOpenDialogShr($keywords=''){
        $model = User::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getUserKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'select', $data);
    }
    //按键确认
    public function actionqrsh($id,$keywords=''){
        $tmp=Ice::model()->find('id='.$id);
        $tmp->order_state=4;
        $tmp->save();
        $this->actionIndex_logistic($keywords);
    }
    //展示地图
    public function actionShowMap($keywords='',$oId){
        $tmp=Ice::model()->find('id='.$oId);
        $model = Ice::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getUserKeyWords($keywords);
        $data = array();
        $data["longitude"]=$tmp->longitude;
        $data["latitude"]=$tmp->latitude;
        parent::_list($model, $criteria, 'map', $data);
    }
    //定位明细弹窗
    public function actionShowDetail($keywords='',$oId){
        $tmp=Ice::model()->find('id='.$oId);
        $model = Ice::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getUserKeyWords($keywords);
        $data = array();
        $data["longitude"]=$tmp->longitude;
        $data["latitude"]=$tmp->latitude;
        parent::_list($model, $criteria, 'map', $data);
    }

    //已保存
    public function actionIndex_appoint($keywords = '') {
        $w="order_state=1";
        $this->actionIndex_appoint_by_condition($keywords,$w);
    }

    //待审核(渔民)
    public function actionIndex_appoint_wait($keywords = '') {
        $w="order_state=2";
        $this->actionIndex_appoint_by_condition($keywords,$w);
    }

    //已审核(渔民)
    public function actionIndex_appoint_finish($keywords = '') {
        $w="order_state=3";
        $this->actionIndex_appoint_by_condition($keywords,$w);
    }
    //配送中（渔民）
    public function actionIndex_distribution($keywords = '') {
        $w="order_state=7";
        $this->actionIndex_appoint_by_condition($keywords,$w);
    }
    //已完成(渔民)
    public function actionIndex_finish($keywords = '') {
        $w="order_state=8";
        $this->actionIndex_appoint_by_condition($keywords,$w);
    }
    //待审核(审核人员)
    public function actionIndex_examine_wait($keywords = '') {
        $w="order_state=2";
        $this->actionIndex_examine_by_condition($keywords,$w);
    }
    //已审核(审核人员)
    public function actionIndex_examine_finish($keywords = '') {
        $w="order_state=3";
        $this->actionIndex_examine_by_condition($keywords,$w);
    }
    //待确认(派送员)
    public function actionIndex_confirm_deliver($keywords = '') {
        $w="order_state=5";
        $this->actionIndex_deliver_by_condition($keywords,$w);
    }
    //待派送(派送员)
    public function actionIndex_wait_deliver($keywords = '') {
        $w="order_state=6";
        $this->actionIndex_deliver_by_condition($keywords,$w);
    }

    //派送中(派送员)
    public function actionIndex_delivering($keywords = '') {
        $w="order_state=7";
        $this->actionIndex_deliver_by_condition($keywords,$w);
    }
    //已完成(派送员)
    public function actionIndex_finish_deliver($keywords = '') {
        $w="order_state=8";
        $this->actionIndex_deliver_by_condition($keywords,$w);
    }

    //根据订单状态调用对应的函数（渔民预约冰）
    public function actionIndex_appoint_by_condition($keywords = '',$w='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        if($w){
            $criteria -> addCondition($w);
        }
        $data = $this->getAppointCountList();
        parent::_list($model, $criteria,'index', $data);
    }
    //根据订单状态调用对应的函数（审核）
    public function actionIndex_examine_by_condition($keywords = '',$w='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        if($w){
            $criteria -> addCondition($w);
        }
        $data = $this->getAppointCountList();
        parent::_list($model, $criteria,'index_examine', $data);
    }
    //根据订单状态调用对应的函数（配送）
    public function actionIndex_deliver_by_condition($keywords = '',$w='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        if($w){
            $criteria -> addCondition($w);
        }
        $data = $this->getAppointCountList();
        parent::_list($model, $criteria,'index_logistic', $data);
    }
    //获取当前订单的数量
    public function getAppointCountList(){
        $date=array();
        $modelName = $this->model;
        $model = $modelName::model();
        $date['todayCount']= $model->count("order_state=1");
        $date['waitCount']= $model->count("order_state=2");
        $date['examine_finishCount']= $model->count("order_state=3");
        $date['wait_deliver_Count']= $model->count("order_state=5");
        $date['delivering_Count']= $model->count("order_state=6");
        $date['distributionCount']= $model->count("order_state=7");
        $date['finishCount']= $model->count("order_state=8");
        return $date;
    }



    //按键位置触发的函数
    public function chge_state_btn($v,$titleName,$action_chosed=''){
        $action=strtolower(Yii::app()->controller->getAction()->id);//获取当前action名
        $judgeAction=strtolower($action_chosed);
        $html='<a class="btn btn-blue" href="';
        $url=$this->createUrl('ChangeState',array('id' => $v->id,'Now_state'=>$titleName));//对应记录的id
        $html.=$url.'">'.$titleName.'</a>';
        if($action==$judgeAction){//当前action名与导航栏action名相同，就输出按钮
            return $html;
        }
    }

    //变化订单状态
    public function actionChangeState($id,$Now_state,$keywords=''){
        $modelname=$this->model;
        $tmp=$modelname::model()->find('id='.$id);//找出对应id的那条记录
        $a=array(
            '确认订单'=>2,
            '审核'=>3,
            '退回'=>1,
            '确认'=>6,
            '配送'=>7,
            '确认收货'=>8
        );
        $tmp->order_state=isset($a[$Now_state])?$a[$Now_state]:0; //不在数组里赋0
        $tmp->save();
        echo '<script>window.history.back();</script>';
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

    public function actionIndex_dealOrder_by_condition($keywords = '',$w='') {
        $model=$this->setCookieAndGetModel();
        $criteria=$this->getIndexCriteria($keywords,$w);
        $data = $this->getDealOrderCountList();
        $data['istoday']=DecodeAsk('is_today');
        parent::_list($model, $criteria, 'index_dealOrder', $data);
    }

    //今日预约
    public function actionIndex_dealOrder_today($keywords = '') {
        $w=get_like(1,'order_time',Date('Y-m-d'));
        $this->actionIndex_dealOrder_by_condition($keywords,$w,1);
    }


    //待确认订单
    public function actionIndex_dealOrder_wait($keywords = '') {
        $w="order_state=3";
        $this->actionIndex_dealOrder_by_condition($keywords,$w);
    }


    //已确认订单
    public function actionIndex_dealOrder_finish($keywords = '') {
        $w="order_state=4";
        $this->actionIndex_dealOrder_by_condition($keywords,$w);
    }

    public function getDealOrderCountList(){
        $date=array();
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition= get_like('1','order_time',Date('Y-m-d'));
        $date['todayDoCount']= $model->count($criteria);
        $date['waitDoCount']= $model->count("order_state=3");
        $date['finishDoCount']= $model->count("order_state=4");
        return $date;
    }

    public function actionConfirmOrder($id){
        $tmp=$this->loadModel($id,$this->model);
        $tmp->order_state=5;
        $tmp->save();
        echo '<script>window.history.back()</script>';
    }



}