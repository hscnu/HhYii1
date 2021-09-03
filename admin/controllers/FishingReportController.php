<?php

class FishingReportController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $model->check_save=0;//跳过必填（required）检验
        $model->report_id = Date('YmdHis').get_session('userId');
        $model->save();
        $this->redirect(array('Update','id'=>$model->id));//跳转到修改动作
    }

    public function actionUpdate($id='0') {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $detailList=ReportDetail::model()->findAll('order_id='.$id);
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
        $modelName='ReportDetail';
        $detail_id=DecodeAsk('detail_id');
        if($detail_id){
            $model=$this->loadModel($detail_id,$modelName);
        }
        else{
            $model = new ReportDetail();
            $model->order_id=DecodeAsk('order_id');
        }

        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['isClose'] = DecodeAsk('isClose');
            $this->render('update_detail', $data);
        }else {
            $this->Save_detail($model, $_POST['ReportDetail']);
        }
    }

    public function Save_detail($model, $post) {
        $model->attributes = $post;
        $model->save();
        if ($_POST['submitType'] == 'baonext')
        {
            $url=Yii::app()->request->getUrl().'&isClose=0';
        }
        else $url=Yii::app()->request->getUrl().'&isClose=1';//刷新并传递参数通知弹窗关闭
        show_status(1, '保存成功',$url, '保存失败');
    }


    public function actionSaveFormDate($id){
        $model=$this->loadModel($id,$this->model);
        $model->check_save=0;
        $model->attributes = $_REQUEST[$this->model];
        $model->save();
    }

    function saveData($model, $post) {
        $model->attributes = $post;
        $model->count=ReportDetail::model()->count('order_id='.$model->id);
        $model->state=4;
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }



    public function actionUpdateVerify($id='0') {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $detailList=ReportDetail::model()->findAll('order_id='.$model->id);
        $array=fishingreport::model()->findAll();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['detailList'] = $detailList;
            $data['isClose'] = DecodeAsk('isClose');
            $this->render('submit', $data);
        } else {
            $this->saveDataVerify($model, $_POST[$modelName],$array);
        }
    }//渔民提交

    public function actionUpdateVerify2($id='0') {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $detailList=ReportDetail::model()->findAll('order_id='.$model->id);
        $array=fishingreport::model()->findAll();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['detailList'] = $detailList;
            $data['isClose'] = DecodeAsk('isClose');
            $this->render('update_check', $data);
        } else {
            $this->saveDataVerify2($model, $_POST[$modelName],$array);
        }
    }//公司审核

    public function actionUpdateVerify3($id='0') {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $detailList=ReportDetail::model()->findAll('order_id='.$model->id);
        $array=fishingreport::model()->findAll();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['detailList'] = $detailList;
            $data['isClose'] = DecodeAsk('isClose');
            $this->render('read', $data);
        } else {
            $this->saveDataVerify3($model, $_POST[$modelName],$array);
        }
    }//查看

    function saveDataVerify($model, $post,$array) {
        $model->attributes=$post;
        $next_id='';
        $model->state = 1;
        foreach ($array as $k=>$v){
            if($v->id===$model->id&&$k<count($array)-1)
            {
                $next_id=$array[$k+1]->id;
                break;}
        }

        $url=Yii::app()->request->getUrl().'&isClose=1';//刷新并传递参数通知弹窗关闭
        show_status($model->save(), '提交成功',$url, '提交失败');
    }

    function saveDataVerify2($model, $post,$array) {
        $model->attributes=$post;
        $next_id='';
        $model->check_time =Date('Y-m-d');
        $model->checktor_id =get_session('userId');
        foreach ($array as $k=>$v){
            if($v->id===$model->id&&$k<count($array)-1)
            {
                $next_id=$array[$k+1]->id;
                break;}
        }
        $url=Yii::app()->request->getUrl().'&isClose=1';//刷新并传递参数通知弹窗关闭
        show_status($model->save(), '保存成功',$url, '保存失败');
    }

    function saveDataVerify3($model, $post,$array) {
        $model->attributes=$post;
        $next_id='';
        foreach ($array as $k=>$v){
            if($v->id===$model->id&&$k<count($array)-1)
            {
                $next_id=$array[$k+1]->id;
                break;}
        }
        $url= Yii::app()->request->getUrl().'&isClose=1';//刷新并传递参数通知弹窗关闭
        show_status($model->save(), '保存成功',$url, '保存失败');
    }

    public function actionindex_mobile($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'FishingReport';
        $model = $modelName::model();
        $model->deleteAll("state=0");
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getfishKeyWords($keywords);
        $criteria ->addCondition("state=4");
        $criteria ->addCondition('userId='.get_session('userId'));//只能看自己的数据
        parent::_list($model, $criteria, 'index_mobile');
    }

    public function actionindex_mobile_history($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'FishingReport';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getfishKeyWords($keywords);
        $criteria ->addCondition("state=1");
        $criteria ->addCondition('userId='.get_session('userId'));//只能看自己的数据
        parent::_list($model, $criteria, 'index_mobile_history');
    }

    public function actionIndex_appoint_by_condition($keywords = '',$w='',$istoday='',$start_date='', $end_date='',$statename='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $model->deleteAll("state=0");
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getfishKeyWords($keywords);
        if(!empty($w)){
            $criteria->addCondition($w);
        }
        $criteria ->addCondition('userId='.get_session('userId'));//只能看自己的数据
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'reporttime>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'reporttime<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'state',$statename);
        parent::_list($model, $criteria, 'index');
    }

    public function actionIndex_appoint_by_condition2($keywords = '',$w='',$istoday='',$statename='',$mycheck='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $model->deleteAll("state=0");
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getfishKeyWords($keywords);
        if(!empty($w)){
            $criteria->addCondition($w);
        }
        if(!empty($mycheck)){
            $criteria ->addCondition('checktor_id='.get_session('userId'));//只能看自己审核的数据
        }
        if(!empty($istoday)){
            $check_time=DecodeAsk('check_time',Date('Y-m-d'));
            $criteria->condition=get_where($criteria->condition,($check_time!=""),'check_time=',$check_time,'"');
        }
        $criteria->condition=get_like($criteria->condition,'state',$statename);
        parent::_list($model, $criteria, 'index_check');
    }

    public function actionIndex_appoint_by_condition3($keywords = '',$w='',$start_date='', $end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $model->deleteAll("state=0");
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getfishKeyWords($keywords);
        if(!empty($w)){
            $criteria->addCondition($w);
        }
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'reporttime>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'reporttime<=',$end_date,'"');
        //$criteria->order = 'name desc';//排序输出
        parent::_list($model, $criteria, 'index_all');
    }

    public function actionIndex_appoint_by_condition4($keywords = '',$w='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $model->deleteAll("state=0");
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getfishKeyWords($keywords);
        if(!empty($w)){
            $criteria->addCondition($w);
        }
        $criteria ->addCondition('userId='.get_session('userId'));//只能看自己的数据
        parent::_list($model, $criteria, 'index_history');
    }

    public function actionIndex_appoint_by_condition5($keywords = '',$w='',$start_date='', $end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $model->deleteAll("state=0");
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getfishKeyWords($keywords);
        if(!empty($w)){
            $criteria->addCondition($w);
        }
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'reporttime>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'reporttime<=',$end_date,'"');
        //$criteria->order = 'name desc';//排序输出
        parent::_list($model, $criteria, 'index_all2');
    }
    public function actionIndex_Register($keywords = '') {
        $this->actionIndex_appoint_by_condition($keywords,"state=4 or state=7");
    }//待提交

    public function actionIndex_history($keywords = '') {
        $this->actionIndex_appoint_by_condition4($keywords,"state=1");
    }//已提交

    public function actionIndex_check($keywords = '') {
        $this->actionIndex_appoint_by_condition2($keywords,"state=1");
    }//待审核

    public function actionIndex_check_today($keywords = '') {
        $w="state=5 or state=6 or state=7";
        $statename=DecodeAsk('statename','');
        $this->actionIndex_appoint_by_condition2($keywords,$w,1,$statename,1);
    }//今日审核


    public function actionIndex_all($keywords = '') {
        $start_date=DecodeAsk('start_date',Date('Y-m-d'));
        $end_date=DecodeAsk('end_date',Date('Y-m-d'));
        $this->actionIndex_appoint_by_condition3($keywords,"state=5",$start_date,$end_date);
    }//已审核通过

    public function actionIndex_all2($keywords = '') {
        $start_date=DecodeAsk('start_date',Date('Y-m-d'));
        $end_date=DecodeAsk('end_date',Date('Y-m-d'));
        $this->actionIndex_appoint_by_condition5($keywords,"state=6",$start_date,$end_date);
    }//审核未通过

    public function getfishKeyWords($keywords){
        return  get_like('1','name,fishingtime,reporttime,state,report_id',$keywords);
    }

    function DecodeAsk($var,$default='0'){
        return isset($_REQUEST[$var])?$_REQUEST[$var]:$default;
    }

    function actiongetUnit($species){
        $tmp=FishingGoods::model()->find("f_name='".$species."'");
        echo CJSON::encode($tmp->f_code);
    }

    public function actionOpenDialogImg($keywords=''){
        $model = ReportDetail::model();
        $criteria = new CDbCriteria;
        $criteria->condition='order_id='.DecodeAsk('orderId');

        $data = array();
        parent::_list($model, $criteria, 'select', $data);//渲染select
    }
    public function actionchangeOrderImg($oId,$img){
        put_msg($oId);
        put_msg($img);
        $order=FishingReport::model()->findAll("id in (".$oId.")");//找订单
        put_msg($order);
        if($order){
            foreach ($order as $v){
                $v->image=$img;//填入pic信息
                put_msg('ok 1');
                $s1=$v->save();
                put_msg($s1);
            }
        }
        echo CJSON::encode('succeed');
    }
}