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

            $resId=$this->getUserUnit();
            $data['restaurant_name']=Restaurant::model()->getNameFromId($resId);

            $this->render('update', $data);
        } else {

            $this->saveData($model, $_POST[$modelName]);
        }
    }

    //获取用户所属单位
    function getUserUnit(){
        $userId=get_session('userId');
        $tmp=User::model()->find('userId='.$userId);
        if($tmp){
            return $tmp->unitId;
        }
    }


    function saveData($model, $post) {
        $model->attributes = $post;
//识别用户单位
        $resId=$this->getUserUnit();
        $model['restaurant_id']=$resId;
        $model['restaurant_name']=Restaurant::model()->getNameFromId($model['restaurant_id']);

        if($model['state']==0){
            $model['state']=1;
        }

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

    public function actionIndex_by_condition($next_index,$keywords = '',$w='',$examineType='None',$istoday=0) {
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
        $data['examineType']=$examineType;
        parent::_list($model, $criteria, $next_index, $data);
    }


    //申请中
    public function actionIndex_appoint($keywords = '') {
        $w="state=1";
        $this->actionIndex_by_condition('index_appointed',$keywords,$w,1);
    }

    //已提交
    public function actionIndex_appoint_wait($keywords = '') {
        $w="state=2";
        $this->actionIndex_by_condition('index_appointed',$keywords,$w);
    }

    //待审核
    public function actionIndex_appoint_finish($keywords = '') {
        $w="state=3";
        $examineType='I_examine';
        $this->actionIndex_by_condition('index_examine',$keywords,$w,$examineType);
    }
    //内部审核通过
    public function actionIndex_I_examine($keywords = '') {
        $w="state=12";
        $this->actionIndex_by_condition('index_examine',$keywords,$w);
    }
    //消毒中心审核通过
    public function actionIndex_F_examine($keywords = '') {
        $w="state=4";
        $examineType='F_examine';
        $this->actionIndex_by_condition('index_examine',$keywords,$w,$examineType);
    }
    //待签收
    public function actionIndex_wait_sign($keywords = '') {
        $w="state=10";
        $this->actionIndex_by_condition('index_sign',$keywords,$w);
    }
    //已签收
    public function actionIndex_signed($keywords = '') {
        $w="state=11";
        $this->actionIndex_by_condition('index_sign',$keywords,$w);
    }
    //待配送
    public function actionIndex_deliver_wait($keywords = '')
    {
        $w = "state=13";
        $this->actionIndex_by_condition('index_get_delivered', $keywords, $w);
    }

    //已配送
    public function actionIndex_deliver_finish($keywords = '')
    {
        $w = "state=10";
        $this->actionIndex_by_condition('index_get_delivered', $keywords, $w);
    }
    public function getAppointCountList(){
        $modelName = $this->model;

        $todayCount = count($modelName::model()->findAll('state=1'));
        $waitCount = count($modelName::model()->findAll('state=2'));
        $finishCount = count($modelName::model()->findAll('state=3'));
        $waitSignCount = count($modelName::model()->findAll('state=10'));
        $signedCount = count($modelName::model()->findAll('state=11'));
        $IExamine = count($modelName::model()->findAll('state=12'));
        $FExamine = count($modelName::model()->findAll('state=4'));
        $deliver_wait = count($modelName::model()->findAll('state=13'));
        $deliver_finish = count($modelName::model()->findAll('state=10'));
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


    public function actionOpenDialogOrder($keywords='',$Id=0,$nowView='None',$examineType='None'){

        $modelName = $this->model;
        $order_model =$this->loadModel($Id,$modelName);

        $model = DisinfectionOrderDetail::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getOrderKeyWords($Id);
        $data = array();
        $data['order_model']=$order_model;
        $data['nowView']=$nowView;
        $data['examineType']=$examineType;
        parent::_list($model, $criteria, 'detail', $data);//渲染detail
    }
    /// 查看明细end
    /// 配送订单
    public function actionSetShrIdAndName($oId, $shrId)
    {
        $shr = DistributorCen::model()->find('user_id=' . $shrId);//根据送货人ID找到该用户信息
        $order = DisinfectionOrder::model()->findAll("id in (" . $oId . ")");//找订单
        if ($order) {
            foreach ($order as $v) {
                $v->deliver_id = $shrId;//填入送货人信息
                $v->deliver_name = $shr->user_name;
                $v->deliver_tel = $shr->user_tel;
                $v->state = 10;//修改状态
                $v->save();
            }
        }
        echo CJSON::encode('succeed');
    }

    public function getUserKeyWords($keywords)
    {
        return get_like('1', 'user_name', $keywords);
    }

    public function actionOpenDialogShr($keywords = '')
    {
        $model = DistributorCen::model();
        $criteria = new CDbCriteria;
        $criteria->condition = $this->getUserKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'select', $data);//渲染select
    }
    //配送订单end
    /// 状态改变按钮
    public function actionChangeState($id,$Now_state,$keywords=''){

        $modelname=$this->model;
        $tmp=$modelname::model()->find('id='.$id);
        $a=array(
            '外部审核通过'=>13,
            '签收'=>11,
            '内部审核通过'=>4,
            '提交'=>2,
            '送往审核'=>3,
        );
        $tmp->state= $a[$Now_state] ?? $Now_state;
        $tmp->save();

        echo '<script>window.history.back();</script>';
    }

    public function chge_state_btn($v,$titleName,$action_chosed=''){
        $action=strtolower(Yii::app()->controller->getAction()->id);
        $judgeAction=strtolower($action_chosed);
        $htlm='<a class="btn btn-blue" href="';
        $url=$this->createUrl('ChangeState',array('id' => $v->id,'Now_state'=>$titleName));
        $htlm.=$url.'">'.$titleName.'</a>';
        if($action==$judgeAction){
            return $htlm;
        }
    }
    public function edit_btn($v){
        $action=strtolower(Yii::app()->controller->getAction()->id);
        $html='<a class="btn" href="';
        $url=$this->createUrl('update',array('id' => $v->id));
        $html.=$url.'"'.'title="编辑"><i class="fa fa-edit"></i></a>';

        if('index_appoint'==$action){
            return $html;
        }

    }
    /// 状态改变end
    /// 订单签收
    public function actionIndex_sign($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);


        $model->deleteAll('state'.' in (' . 0 . ')');


        $data = $this->getAppointCountList();

        parent::_list($model, $criteria, 'index_sign', $data);
    }
    /// 订单签收end
    /// 订单审核
    public function actionIndex_examine($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);


        $model->deleteAll('state'.' in (' . 0 . ')');


        $data = $this->getAppointCountList();
        $data['examineType']='None';

        parent::_list($model, $criteria, 'index_examine', $data);
    }

    /// 订单审核end
    ///配送订单
    public function actionIndex_get_delivered($keywords='')
    {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $model->deleteAll('state'.' in (' . 0 . ')');
        $data = $this->getAppointCountList();
        parent::_list($model, $criteria, 'index_get_delivered', $data);
    }
    ///配送订单end
    ///申请订单
    public function actionIndex_appointed($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $model->deleteAll('state'.' in (' . 0 . ')');
        $data = $this->getAppointCountList();
        parent::_list($model, $criteria, 'index_appointed', $data);
    }
    ///申请订单end
}