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
        $st=$model->save();
        if($st) {
            IceDetail::model()->save_detail($model->id,$_POST);
        }

        show_status($st, '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }


    //明细操作相关开始

    //添加订单
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $model->check_save=0;//跳过必填（required）检验
        $model->save();
        //$this->actionUpdate($model->id);//会产生BUG的旧方法
        $this->redirect(array('Update','id'=>$model->id,'isAdd'=>1));//跳转到修改动作，新方法解决
    }
    //编辑订单
    public function actionUpdate($id='0',$isAdd=0) {
        $modelName = $this->model;
        $modelName3='IceDetail';
        $model = $this->loadModel($id, $modelName);//加载对应添加id的订单
        //如果是添加新订单
        if($isAdd==1) {
            $model['user_id']=get_Session('userId');
            $model['create_time']=date('Y-m-d H:i:s');
            $model['order_state'] = 1;
            $detailList=IceDetail::model()->findAll('order_id='.$id);
        }
        else {
            $detailList = IceDetail::model()->findAll('order_id=' . $id);
        }
        //没点保存进入update.php页面，点了跳转到saveDate;
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['detailList'] = $detailList;
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);

        }
    }

    public function actionOpenDialog(){
        $modelName='IceDetail';
        $detail_id=DecodeAsk('detail_id');
        if($detail_id){
            $model=$this->loadModel($detail_id,$modelName);
        }
        else{
            $model = new IceDetail();
            $model->order_id=DecodeAsk('order_id');
        }

        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['isClose'] = DecodeAsk('isClose');
            $this->render('update_detail', $data);
        }else {
            $this->Save_detail($model, $_POST['IceDetail']);
        }
    }

    public function Save_detail($model, $post) {
        $model->attributes = $post;
        $url=Yii::app()->request->getUrl().'&isClose=1';//刷新并传递参数通知弹窗关闭
        show_status($model->save(), '保存成功',$url, '保存失败');
    }

    public function actionSaveFormDate($id){//打开弹窗前先保存一次
        $model=$this->loadModel($id,$this->model);
        $model->check_save=0;
        $model->attributes = $_REQUEST[$this->model];
        $model->save();
    }


    //保存函数
    function saveData2($model1,$model2, $post1,$post2) {
        $model1->attributes = $post1;
        $model2->attributes = $post2;
        show_status($model1->save()&&$model2->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }
    //订单明细弹窗
    public function actionShowDetail($keywords='',$oId,$condition){
        $Ice_order=Ice::model()->find('id='.$oId);
        $Ice_detail=IceDetail::model()->findAll('order_id='.$oId);
        $model = Ice::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getUserKeyWords($keywords);
        $data = array();
        $data['order_model']=$Ice_order;
        $data["ice_detail"]=$Ice_detail;
        $data["take_type"]=$Ice_order->take_type;
        $data["condition"]=$condition;
        parent::_list($model, $criteria, 'detail', $data);
    }
    //添加冰类型
    public function actionCreateice() {
        $modelName = 'IceType';
        $model = new $modelName('createice');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('updateice', $data);
        } else {
            $this->icesaveData($model, $_POST[$modelName]);
        }
    }
    //编辑冰类型
    public function actionUpdateice($id) {
        $modelName = 'IceType';
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('updateice', $data);
        } else {
            $this->icesaveData($model, $_POST[$modelName]);
        }
    }
    //保存冰明细
    function icesaveData($model1, $post1) {
        $model1->attributes = $post1;
        show_status($model1->save(),'保存成功', get_cookie('_currentUrl_'), '保存失败');
    }
    //明细相关操作结束



    //点击功能切换页面函数（头）

    //渔民预约冰页面《手机页面》
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = $this->getAppointCountList();
        $criteria->addCondition('user_id='.get_session('userId'));
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index', $data);
    }
    //渔民确认收货页面《手机页面》
    public function actionIndex_myconfirm_receipt($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $criteria->addCondition('user_id='.get_session('userId'));
        if("order_state=6 or order_state=4"){
            $criteria -> addCondition("order_state=6 or order_state=4");
        }
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_myconfirm_receipt', $data);
    }
    //渔民完成订单页面《手机页面》
    public function actionIndex_finished_receipt($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $criteria->addCondition('user_id='.get_session('userId'));
        if("order_state=7"){
            $criteria -> addCondition("order_state=7");
        }
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_finished_receipt', $data);
    }

    //审核页面
    public function actionIndex_examine($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $action=strtolower(Yii::app()->controller->getAction()->id);//获取当前action名
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $criteria->addCondition('user_id='.get_session('userId'));
        $data = $this->getAppointCountList();
        $data["action"]=$action;
        parent::_list($model, $criteria, 'index_examine', $data);
    }


    //冰出库之自取区，确认收货
    public function actionIndex_accept_ice_by_oneself($keywords = '') {
        $w="order_state=4 and take_type='自取'";
        $views='index_accept_ice';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //冰出库之配送区，确认出库
    public function actionIndex_accept_ice_by_logistic($keywords = '') {
        $w="order_state=4 and take_type='配送'";
        $views='index_accept_ice';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }


    //领冰页面
    public function actionIndex_accept_ice($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $criteria->addCondition('user_id='.get_session('userId'));
        $criteria -> addCondition("order_state=4" );
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_accept_ice', $data);
    }

    //物流人员待配送页面《手机页面》
    public function actionIndex_waiting_deliver($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $criteria->addCondition('deliver_id='.get_session('userId'));
        if("order_state=4"){
            $criteria -> addCondition("order_state=4");
        }
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_waiting_deliver', $data);
    }
    //物流人员配送中页面《手机页面》
    public function actionIndex_delivering($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $criteria->addCondition('deliver_id='.get_session('userId'));
            $criteria -> addCondition("order_state=6 and take_type='配送'");
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_delivering', $data);
    }
    //物流人员已完成页面《手机页面》
    public function actionIndex_logistic_finished($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $criteria->addCondition('deliver_id='.get_session('userId'));
        if("order_state=7"){
            $criteria -> addCondition("order_state=7");
        }
        $data = $this->getAppointCountList();
        $model->deleteAll('order_state=0');//每次进来删除订单状态为0的订单
        parent::_list($model, $criteria, 'index_logistic_finished', $data);
    }


    public function actionIndex_query($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'Ice';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        parent::_list($model, $criteria, 'index_query');
    }

    //添加商品页面
    public function actionIndex_ice_type($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'IceType';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        parent::_list($model, $criteria, 'index_ice_type');
    }

    //点击功能切换页面函数（尾）


    //查询关键字
    public function getIceKeyWords($keywords){
        return  get_like('1','order_id,title,fishing_boat,order_time,take_type,order_remark',$keywords);
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
        $w="order_state=6";
        $views='index';
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //已完成(渔民)
    public function actionIndex_finish($keywords = '') {
        $w="order_state=7";
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
    //待派送员领冰(冰管理)
    public function actionIndex_confirm_deliver($keywords = '') {
        $w="order_state=4";
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
    //4，物流已审核待配送员确认
    public function actionQuery_logistics_examined($keywords = '') {
        $views='index_query';
        $w="order_state=4";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //5，配送员已确认待配送
    public function actionQuery_confirmed($keywords = '') {
        $views='index_query';
        $w="order_state=5";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //6，配送员正在配送待签收
    public function actionQuery_delivering($keywords = '') {
        $views='index_query';
        $w="order_state=6";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }
    //7，已签收
    public function actionQuery_received($keywords = '') {
        $views='index_query';
        $w="order_state=7";
        $this->actionIndex_by_condition($keywords,$views,$w);
    }







    //根据订单状态调用对应的函数
    public function actionIndex_by_condition($keywords = '',$views='index',$w='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        if($views=='index_logistic'){
            $criteria->addCondition('deliver_id='.get_session('userId'));
        }
        else{
            $criteria->addCondition('user_id='.get_session('userId'));
        }
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
        $date['savedCount']= $model->count("order_state=1 and user_id=".get_session('userId'));//状态1，已保存待提交
        $date['waitCount']= $model->count("order_state=2 and user_id=".get_session('userId'));//2，已提交待渔业公司审核
        $date['examine_finishCount']= $model->count("order_state=3 and user_id=".get_session('userId'));//3，渔业公司已审核待物流审核
        $date['examine_logisticsCount']= $model->count("order_state=4 and user_id=".get_session('userId'));//4，物流已审核待冰出库
        $date['accept_ice_by_oneself_Count']= $model->count("order_state=4 and take_type='自取' and user_id=".get_session('userId') );
        $date['accept_ice_by_logistics_Count']= $model->count("order_state=4 and take_type='配送' and user_id=".get_session('userId') );
        $date['wait_deliver_Count']= $model->count("order_state=5 and deliver_id=".get_session('userId'));//5，
        $date['delivering_Count']= $model->count("order_state=6 and deliver_id=".get_session('userId'));//6，配送员正在配送待签收
        $date['wait_accept_Count']= $model->count("order_state=6 and user_id=".get_session('userId'));//6，配送员正在配送待签收
        $date['deliver_finishCount']= $model->count("order_state=7 and deliver_id=".get_session('userId'));//7，已签收
        $date['finishCount']= $model->count("order_state=7 and user_id=".get_session('userId'));//7，已签收
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
            '渔业审核通过'=>3,
            '提交订单'=>2,
            '渔业退回订单'=>1,
            '物流配送审核通过'=>4,
            '物流自取审核通过'=>4,
            '物流退回订单'=>1,
            '确认出库'=>6,
            '确认收货'=>7
        );
        $tmp->order_state=isset($a[$Now_state])?$a[$Now_state]:0;
        if($Now_state=='物流配送审核通过'||$Now_state=='物流自取审核通过'){
            $tmp->checker_name=get_session('TCNAME');
        }
        if($Now_state=='确认收货'){
            $tmp->receiver_name=get_session('TCNAME');
        }
        $tmp->save();
        echo '<script>window.history.back();</script>';
    }
    //按键相关函数（尾）





















    //物流审核页面

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


    //今日预约
    public function actionIndex_dealOrder_today($keywords = '') {
        $w=get_like(1,'order_time',Date('Y-m-d'))." and order_state=3";
        $this->actionIndex_dealOrder_by_condition($keywords,$w,1);
    }
    //待物流审核订单
    public function actionIndex_dealOrder_wait($keywords = '') {
        $w="order_state=3";
        $this->actionIndex_dealOrder_by_condition($keywords,$w);
    }
    //物流已审核订单
    public function actionIndex_dealOrder_finish($keywords = '') {
        $w="order_state=4";
        $this->actionIndex_dealOrder_by_condition($keywords,$w);
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
        $criteria -> condition= get_like('1','order_time',Date('Y-m-d'))." and order_state=3";
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


    //手机页面
    public function actionShowDetail_mobile($keywords='',$oId,$condition){
        $Ice_order=Ice::model()->find('id='.$oId);
        $Ice_detail=IceDetail::model()->findAll('order_id='.$oId);
        $model = Ice::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getUserKeyWords($keywords);
        $data = array();
        $data['order_model']=$Ice_order;
        $data["ice_detail"]=$Ice_detail;
        $data["take_type"]=$Ice_order->take_type;
        $data["condition"]=$condition;
        parent::_list($model, $criteria, 'mobile_detail', $data);
    }
}