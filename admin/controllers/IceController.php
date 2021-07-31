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


    function saveData($model, $post) {
        $model->attributes = $post;
        put_msg($model->attributes);
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }


    //明细操作相关结束

    //添加订单
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $model->check_save=0;
        $model->save();//先保存一个订单，生成id
        $this->actionUpdate($model->id,1);//调用Update修改
    }
    //编辑订单
    public function actionUpdate($id='0',$isAdd='0') {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $modelName2='IceDetail';
        if($isAdd==1){
            $model['order_state']=1;
            $model2=new $modelName2();
            $model2['order_id']=$id;
        }
        else{
            $detailList=IceDetail::model()->find('order_id='.$id);
            $id2=$detailList->id;
            $model2 = $this->loadModel($id2,$modelName2);
        }
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['model2']=$model2;
            $this->render('update', $data);
        } else {
            $this->saveData2($model,$model2, $_POST[$modelName],$_POST[$modelName2]);
        }
    }
    //保存函数
    function saveData2($model1,$model2, $post1,$post2) {
        $model1->attributes = $post1;
        $model2->attributes = $post2;
        show_status($model1->save()&&$model2->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }
    //订单明细弹窗
    public function actionShowDetail($keywords='',$oId){
        $tmp=Ice::model()->find('id='.$oId);
        $model = Ice::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getUserKeyWords($keywords);
        $data = array();
        $data["id"]=$tmp->id;
        $data["name"]=$tmp->order_name;
        $data["tel"]=$tmp->order_tel;
        $data["date"]=$tmp->order_time;
        $data["longitude"]=$tmp->longitude;
        $data["latitude"]=$tmp->latitude;
        parent::_list($model, $criteria, 'map', $data);
    }
    //审核通过
    public function actionExaminepass($keywords='',$id){
        $modelname=$this->model;
        $tmp=$modelname::model()->find('id='.$id);//找出对应id的那条记录
        $tmp->order_state=8;
        $tmp->save();
        echo '<script>window.history.back();</script>';
    }
    //明细相关操作结束



    //点击功能切换页面函数（头）

    //渔民预约冰页面
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index', $data);
    }
    //渔民确认收货页面
    public function actionIndex_myconfirm_receipt($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        if("order_state=7"){
            $criteria -> addCondition("order_state=7");
        }
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_myconfirm_receipt', $data);
    }
    //物流人员确认收货页面
    public function actionIndex_deliveryconfirm_receipt($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        if("order_state=7"){
            $criteria -> addCondition("order_state=7");
        }
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_deliveryconfirm_receipt', $data);
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
    //查询订单页面（全部人员查询全部状态）
    public function actionIndex_query($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_query', $data);
    }
    //我的订单（渔船查询页面）
    public function actionIndex_myquery($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_myquery', $data);
    }
    //查询订单（渔业公司查询页面）
    public function actionIndex_fisheryquery($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_fisheryquery', $data);
    }
    //查询订单（物流查询页面）
    public function actionIndex_logisticsquery($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_logisticsquery', $data);
    }
    //查询订单（送货员查询页面）
    public function actionIndex_deliveryquery($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_deliveryquery', $data);
    }


    //点击功能切换页面函数（尾）


    public function getIceKeyWords($keywords){
        return  get_like('1','id,order_name,order_tel,order_time,order_remark,order_time',$keywords);
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



    //导航栏判断函数（头）

    //已保存
    public function actionIndex_appoint($keywords = '') {
        $w="order_state=1";
        $views='index';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //已提交(渔民)
    public function actionIndex_appoint_wait($keywords = '') {
        $w="order_state=2";
        $views='index';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //已审核(渔民)
    public function actionIndex_appoint_finish($keywords = '') {
        $w="order_state=3";
        $views='index';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //配送中（渔民）
    public function actionIndex_distribution($keywords = '') {
        $w="order_state=7";
        $views='index';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //已完成(渔民)
    public function actionIndex_finish($keywords = '') {
        $w="order_state=8";
        $views='index';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //待审核(审核人员)
    public function actionIndex_examine_wait($keywords = '') {
        $w="order_state=2";
        $views='index_examine';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //已审核(审核人员)
    public function actionIndex_examine_finish($keywords = '') {
        $w="order_state=3";
        $views='index_examine';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //待确认(派送员)
    public function actionIndex_confirm_deliver($keywords = '') {
        $w="order_state=5";
        $views='index_logistic';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //待派送(派送员)
    public function actionIndex_wait_deliver($keywords = '') {
        $w="order_state=6";
        $views='index_logistic';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //派送中(派送员)
    public function actionIndex_delivering($keywords = '') {
        $w="order_state=7";
        $views='index_logistic';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //已完成(派送员)
    public function actionIndex_finish_deliver($keywords = '') {
        $w="order_state=8";
        $views='index_logistic';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }

    //总查询
    //状态1，已保存待提交
    public function actionQuery_saved($keywords = '') {
        $views='index_query';
        $w="order_state=1";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //2，已提交待渔业公司审核
    public function actionQuery_submited($keywords = '') {
        $views='index_query';
        $w="order_state=2";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //3，渔业公司已审核待物流审核
    public function actionQuery_fishery_examined($keywords = '') {
        $views='index_query';
        $w="order_state=3";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //4，物流已审核待指派人员
    public function actionQuery_logistics_examined($keywords = '') {
        $views='index_query';
        $w="order_state=4";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //5，已指派人员待配送员确认
    public function actionQuery_assigned($keywords = '') {
        $views='index_query';
        $w="order_state=5";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //6，配送员已确认待配送
    public function actionQuery_confirmed($keywords = '') {
        $views='index_query';
        $w="order_state=6";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //7，配送员正在配送待签收
    public function actionQuery_delivering($keywords = '') {
        $views='index_query';
        $w="order_state=7";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //8，已签收
    public function actionQuery_received($keywords = '') {
        $views='index_query';
        $w="order_state=8";
        $this->actionIndex_by_condition($keywords,$views,$w);
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


    //渔船查询页面
    //状态1，已保存待提交
    public function actionMyquery_saved($keywords = '') {
        $views='index_myquery';
        $w="order_state=1";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //2，已提交待渔业公司审核
    public function actionMyquery_submited($keywords = '') {
        $views='index_myquery';
        $w="order_state=2";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //7，配送员正在配送待签收
    public function actionMyquery_delivering($keywords = '') {
        $views='index_myquery';
        $w="order_state=7";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //8，已签收
    public function actionMyquery_received($keywords = '') {
        $views='index_myquery';
        $w="order_state=8";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }

    //渔业公司查询页面
    //2，已提交待渔业公司审核
    public function actionFisheryquery_submited($keywords = '') {
        $views='index_fisheryquery';
        $w="order_state=2";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //3，渔业公司已审核待物流审核
    public function actionFisheryquery_fishery_examined($keywords = '') {
        $views='index_fisheryquery';
        $w="order_state=3";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //8，已签收
    public function actionFisheryquery_received($keywords = '') {
        $views='index_fisheryquery';
        $w="order_state=8";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }

    //物流公司查询页面
    //3，渔业公司已审核待物流审核
    public function actionlogisticsquery_fishery_examined($keywords = '') {
        $views='index_logisticsquery';
        $w="order_state=3";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //4，物流已审核待指派人员
    public function actionlogisticsquery_logistics_examined($keywords = '') {
        $views='index_logisticsquery';
        $w="order_state=4";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //5，已指派人员待配送员确认
    public function actionlogisticsquery_assigned($keywords = '') {
        $views='index_logisticsquery';
        $w="order_state=5";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //6，配送员已确认待配送
    public function actionlogisticsquery_confirmed($keywords = '') {
        $views='index_logisticsquery';
        $w="order_state=6";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //8，已签收
    public function actionlogisticsquery_received($keywords = '') {
        $views='index_logisticsquery';
        $w="order_state=8";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }

    //送货员查询页面
    //5，已指派人员待配送员确认
    public function actiondeliveryquery_assigned($keywords = '') {
        $views='index_deliveryquery';
        $w="order_state=5";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //6，配送员已确认待配送
    public function actiondeliveryquery_confirmed($keywords = '') {
        $views='index_deliveryquery';
        $w="order_state=6";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //7，配送员正在配送待签收
    public function actiondeliveryquery_delivering($keywords = '') {
        $views='index_deliveryquery';
        $w="order_state=7";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //8，已签收
    public function actiondeliveryquery_received($keywords = '') {
        $views='index_deliveryquery';
        $w="order_state=8";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }


    //根据订单状态调用对应的函数
    public function actionIndex_by_condition($keywords = '',$views='index',$w='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        if($w){
            $criteria -> addCondition($w);
        }
        $data = $this->getAppointCountList();
        parent::_list($model, $criteria, $views, $data);
    }
    //获取当前订单的数量
    public function getAppointCountList(){
        $date=array();
        $modelName = $this->model;
        $model = $modelName::model();
        $date['savedCount']= $model->count("order_state=1");//状态1，已保存待提交
        $date['waitCount']= $model->count("order_state=2");//2，已提交待渔业公司审核
        $date['examine_finishCount']= $model->count("order_state=3");//3，渔业公司已审核待物流审核
        $date['examine_logisticsCount']= $model->count("order_state=4");//4，物流已审核待指派人员
        $date['wait_deliver_Count']= $model->count("order_state=5");//5，已指派人员待配送员确认
        $date['delivering_Count']= $model->count("order_state=6");//6，配送员已确认待配送
        $date['distributionCount']= $model->count("order_state=7");//7，配送员正在配送待签收
        $date['finishCount']= $model->count("order_state=8");//8，已签收
        return $date;
    }

    //导航栏判断函数（尾）



    //按键相关函数（头）
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
    //按键变化订单状态
    public function actionChangeState($id,$Now_state,$keywords=''){
        $modelname=$this->model;
        $tmp=$modelname::model()->find('id='.$id);//找出对应id的那条记录
        $a=array(
            '审核通过'=>4,
            '提交'=>2,
            '审核'=>3,
            '退回'=>1,
            '确认'=>6,
            '配送'=>7,
            '确认收货'=>8
        );
        $tmp->order_state=isset($a[$Now_state])?$a[$Now_state]:0;
        $tmp->save();
        echo '<script>window.history.back();</script>';
    }
    //按键相关函数（尾）






















    //待优化

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
    //物流公司审核订单导航栏函数
    public function actionIndex_dealOrder_by_condition($keywords = '',$w='') {
        $model=$this->setCookieAndGetModel();
        $criteria=$this->getIndexCriteria($keywords,$w);
        $data = $this->getDealOrderCountList();
        $data['istoday']=DecodeAsk('is_today');
        parent::_list($model, $criteria, 'index_dealOrder', $data);
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
        $tmp->order_state=4;
        $tmp->save();
        echo '<script>window.history.back()</script>';
    }



}