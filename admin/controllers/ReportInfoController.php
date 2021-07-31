<?php

class ReportInfoController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }


    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $data = $model->find('id='.$id);
        ReportInfo::model()->deleteAll('report_order='.$data['report_order']);
        parent::_clear($id);
    }


    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $model->check_save=0;//跳过必填（required）检验
        $model->report_order = Date('YmdHis').get_session('userId');
        $model->state = '填写中';
        $model->reporter_id = get_session('userId');
        $s=$model->save();
        $this->actionUpdate($model->id);//跳转到修改动作
    }

    public function actionUpdate($id='0') {

        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $detailList=ReportProduct::model()->findAll('report_order='.$model->report_order);
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
        $modelName='ReportProduct';
        $detail_id=DecodeAsk('detail_id');
        if($detail_id){
            $model=$this->loadModel($detail_id,$modelName);
        }
        else{
            $model = new ReportProduct();
            $model->report_order=DecodeAsk('report_order');
        }
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['isClose'] = DecodeAsk('isClose');
            $this->render('update_detail', $data);
        }else {
            $this->Save_detail($model, $_POST['ReportProduct']);
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

    public function actionSaveFormDate($id){//打开弹窗前先保存一次
        $model=$this->loadModel($id,$this->model);
        $model->check_save=0;
        $model->attributes = $_REQUEST[$this->model];
        $model->save();
    }


    function saveData($model, $post) {

        $model->attributes = $post;
        if ($model->save()) {
            $model->state = '待审核';
            $model->operate_time = Date('Y-m-d H:i:s');
            $theme = $model->reporter_name.'在'.$model->report_date.'上报了';
            $data = ReportInfo::model()->findAll('report_order='.$model->report_order);
            foreach ($data as $v){
                $theme.= $v['product_name'];
                if(next($data))
                    $theme.='，';
            }
            $theme.='的产量。';
            $model->theme = $theme;
        }
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }


    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $model->deleteAll("state='填写中'");
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','report_order,report_date,reporter_name,state,checktor',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'report_order,report_date,reporter_name,state,checktor',$keywords);
        $user_type = get_session('F_ROLENAME');
        if ($user_type === '用户') {
            $criteria->addCondition('reporter_id=' . get_session('userId'));
        }
        $data = array();
        $data['waitCount']=$model->count("state='待审核'");
        $data['passCount']=$model->count("state='通过'");
        $data['noPassCount']=$model->count("state='不通过'");
        parent::_list($model, $criteria, 'index', $data);
    }

    //审核列表
    public function actionIndexVerify($keywords = '',$department_keywords='',$state_name_keywords='')
    {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_like('1' ,'theme,report_order,reporter_name',$keywords);
        $data = array();
        $data['waitCount']=$model->count("state='待审核'");
        $data['auditedCount']=$model->count("state='通过' or state='不通过'");
        parent::_list($model, $criteria, 'index_verify', $data);
    }

    //审核界面
    public function actionUpdateVerify($id='0') {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $detailList=ReportProduct::model()->findAll('report_order='.$model->report_order);
        $array=ReportInfo::model()->findAll();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['detailList'] = $detailList;
            $data['isClose'] = DecodeAsk('isClose');
            $this->render('update_verify', $data);
        } else {
            $this->saveDataVerify($model, $_POST[$modelName],$array);
        }
    }

    function saveDataVerify($model, $post,$array) {
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
        $data['waitCount']= $model->count("state='待审核'");
        $data['auditedCount']= $model->count("state='通过' or state='不通过'");
        $data['passCount']= $model->count("state='通过'");
        $data['noPassCount']= $model->count("state='不通过'");
        return $data;
    }

    public function actionIndex_appoint_by_condition($keywords = '',  $start_date_operate='', $end_date_operate='', $start_date_report='', $end_date_report='',$w='',$istoday=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getReportInfoKeyWords($keywords);
        if($w){
            $criteria -> addCondition($w);
        }
        $userId=get_session('userId');
        $tmp=User::model()->find('userId='.$userId);
        if($tmp){
            $roleName=$tmp->F_ROLENAME;
            if ($roleName==='用户' or $roleName==="审核员"){
                $criteria ->addCondition('reporter_id='.$userId);
            }
        }
        $criteria->condition=get_where($criteria->condition,($start_date_report!=""),'report_date>=',$start_date_report,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_report!=""),'report_date<=',$end_date_report,'"');
        $criteria->condition=get_where($criteria->condition,($start_date_operate!=""),'operate_time>=',$start_date_operate,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_operate!=""),'operate_time<=',$end_date_operate,'"');
        $data = $this->getAppointCountList();
        if($roleName==="审核员")parent::_list($model, $criteria, 'index_verify', $data);
        else
            parent::_list($model, $criteria, 'index', $data);
    }

    //待审核
    public function actionIndex_appoint_wait($keywords = '',  $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='待审核'";
        $this->actionIndex_appoint_by_condition($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }

    //已审核
    public function actionIndex_appoint_finish($keywords = '', $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='通过' or state='不通过'";
        $this->actionIndex_appoint_by_condition($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }
    //已通过
    public function actionIndex_appoint_pass($keywords = '', $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='通过'";
        $this->actionIndex_appoint_by_condition($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }
    //不通过
    public function actionIndex_appoint_no_pass($keywords = '', $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='不通过'";
        $this->actionIndex_appoint_by_condition($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }

    public function setCookieAndGetModel(){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        return $modelName::model();
    }

    //以操作时间搜索
    public function actionIndex_appoint_operate_by_condition($keywords='',$start_date_operate='',$end_date_operate='') {
        $model=$this->setCookieAndGetModel();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getReportInfoKeyWords($keywords);
        $criteria->condition=get_where($criteria->condition,($start_date_operate!=""),'operate_time>=',$start_date_operate,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_operate!=""),'operate_time<=',$end_date_operate,'"');
        $data['istoday']=DecodeAsk('is_today');
        parent::_list($model, $criteria, 'index_verify', $data);

    }

    //以上报日期搜素
    public function actionIndex_appoint_report_by_condition($keywords='',$start_date_report='',$end_date_report='') {
        $model=$this->setCookieAndGetModel();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getReportInfoKeyWords($keywords);
        $criteria->condition=get_where($criteria->condition,($start_date_report!=""),'report_date>=',$start_date_report,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_report!=""),'report_date<=',$end_date_report,'"');
        $data['istoday']=DecodeAsk('is_today');
        parent::_list($model, $criteria, 'index_verify', $data);
    }

    public function getReportInfoKeyWords($keywords){
        return  get_like('1','id,theme,report_order,report_date,reporter_name ,state,operate_time,checktor',$keywords);
    }

    function DecodeAsk($var,$default='0'){
        return isset($_REQUEST[$var])?$_REQUEST[$var]:$default;
    }
}