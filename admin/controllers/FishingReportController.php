
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
        if ($_POST['submitType'] == 'baonext')
        {
            if(!empty($next_id)){
                $s2=strstr(Yii::app()->request->getUrl(),'id=',true).'id='.$next_id;
                show_status($model->save(), '保存成功',$s2, '保存失败');
            }
        }
        $url=Yii::app()->request->getUrl().'&isClose=1';//刷新并传递参数通知弹窗关闭
        show_status($model->save(), '保存成功',$url, '保存失败');
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
        if ($_POST['submitType'] == 'baonext')
        {
            if(!empty($next_id)){
                $s2=strstr(Yii::app()->request->getUrl(),'id=',true).'id='.$next_id;
                show_status($model->save(), '保存成功',$s2, '保存失败');
            }
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
        if ($_POST['submitType'] == 'baonext')
        {
            if(!empty($next_id)){
                $s2=strstr(Yii::app()->request->getUrl(),'id=',true).'id='.$next_id;
                show_status($model->save(), '保存成功',$s2, '保存失败');
            }
        }
        $url=Yii::app()->request->getUrl().'&isClose=1';//刷新并传递参数通知弹窗关闭
        show_status($model->save(), '保存成功',$url, '保存失败');
    }
    public function getAppointCountList(){
        $data=array();
        $modelName = $this->model;
        $model = $modelName::model();
        $data['waitCount']= $model->count("state=4");
        $data['historyCount']= $model->count("state=1");
        $data['appointCount']= $model->count("state=1 or state=5 or state=6");
        $data['finishCount']= $model->count("state=5 or state=6");
        return $data;
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
        $data = $this->getAppointCountList();
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'reporttime>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'reporttime<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'state',$statename);
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionIndex_appoint_by_condition2($keywords = '',$w='',$istoday='',$start_date_report='', $end_date_report='',$statename='',$mycheck='') {
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
        $data = $this->getAppointCountList();
        $criteria->condition=get_where($criteria->condition,($start_date_report!=""),'check_time>=',$start_date_report,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_report!=""),'check_time<=',$end_date_report,'"');
        $criteria->condition=get_like($criteria->condition,'state',$statename);
        parent::_list($model, $criteria, 'index_check', $data);
    }

    public function actionIndex_appoint_by_condition3($keywords = '',$w='',$start_date='', $end_date='',$statename='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $model->deleteAll("state=0");
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getfishKeyWords($keywords);
        if(!empty($w)){
            $criteria->addCondition($w);
        }
        $data = $this->getAppointCountList();
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'reporttime>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'reporttime<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'state',$statename);
        //$criteria->order = 'name desc';//排序输出
        parent::_list($model, $criteria, 'index_all', $data);
    }

    public function actionIndex_Register($keywords = '') {
        $w="state=4";
        $this->actionIndex_appoint_by_condition($keywords,$w);
    }//待提交

    public function actionIndex_history($keywords = '') {
        $w="state=1 or state=5 or state=6";
        $start_date=DecodeAsk('start_date','');
        $end_date=DecodeAsk('end_date','');
        $statename=DecodeAsk('statename','');
        $this->actionIndex_appoint_by_condition($keywords,$w,'',$start_date,$end_date,$statename);
    }//已提交

    public function actionIndex_check($keywords = '') {
        $w="state=1";
        $this->actionIndex_appoint_by_condition2($keywords,$w);
    }//待审核

    public function actionIndex_check_today($keywords = '') {
        $w="state=5 or state=6";
        $statename=DecodeAsk('statename','');
        $this->actionIndex_appoint_by_condition2($keywords,$w,1,'','',$statename,1);
    }//今日审核

    public function actionIndex_check_all($keywords = '') {
        $w="state=5 or state=6";
        $start_date_report=DecodeAsk('start_date_report','');
        $end_date_report=DecodeAsk('end_date_report','');
        $statename=DecodeAsk('statename','');
        $this->actionIndex_appoint_by_condition2($keywords,$w,'',$start_date_report, $end_date_report,$statename);
    }//已审核

    public function actionIndex_all($keywords = '') {
        $w="state=5 or state=6";
        $start_date=DecodeAsk('start_date','');
        $end_date=DecodeAsk('end_date','');
        $statename=DecodeAsk('statename','');
        $this->actionIndex_appoint_by_condition3($keywords,$w,$start_date,$end_date,$statename);
    }//所有上报

    public function getfishKeyWords($keywords){
        return  get_like('1','name,fishingtime,reporttime,state,report_id',$keywords);
    }

    function DecodeAsk($var,$default='0'){
        return isset($_REQUEST[$var])?$_REQUEST[$var]:$default;
    }

}