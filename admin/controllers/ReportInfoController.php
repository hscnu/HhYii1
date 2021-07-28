<?php

class ReportInfoController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $data = $model->find('id='.$id);
        ReportProduct::model()->deleteAll('report_order='.$data['report_order']);
        parent::_clear($id);

    }


    public function actionCreate() {

        $modelName = $this->model;
        $model = new $modelName('create');
        $model->check_save=0;//跳过必填（required）检验

        $model->report_order = Date('YmdHis').get_session('userId');
        $model->state = '填写中';
        $model->reporter_id = get_session('userId');
        $model->save();
        $this->actionUpdate($model->id);//跳转到修改动作
//        $this->redirect(array('Update','id' => $model->id));

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
        $url=Yii::app()->request->getUrl().'&isClose=1';//刷新并传递参数通知弹窗关闭
        $status = show_status($model->save(), '保存成功',$url, '保存失败');

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
            $data = ReportProduct::model()->findAll('report_order='.$model->report_order);
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

    public function actionIndex($keywords = '',$start_date_operate='',$end_date_operate='',$start_date_report='', $end_date_report='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();

        $data = $model->findAll("state='填写中'");
        foreach ($data as $v) {
            ReportProduct::model()->deleteAll('report_order='.$v['report_order']);
        }
        $model->deleteAll("state='填写中'");

        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getReportInfoKeyWords($keywords);
//        $criteria -> condition = get_like('1','operate_time',$start_date_operate);
//        $criteria -> condition = get_like( $criteria -> condition,'operate_time',$start_date_operate);
//        $criteria -> condition = get_like('1','report_date',$start_date_report);
//        $criteria -> condition = get_like( $criteria -> condition,'report_date',$start_date_report);
//        $start_date_report=DecodeAsk('start_date_report');
//        $criteria -> condition= get_like( $criteria -> condition,'report_date',$start_date_report);
//        $start_date_operate=DecodeAsk('start_date_operate');
//        $criteria -> condition= get_like( $criteria -> condition,'operate_time',$start_date_operate);

        //识别权限 当为审核员时执行条件
        $userId=get_session('userId');
        $tmp=User::model()->find('userId='.$userId);
        if($tmp){
            $roleName=$tmp->F_ROLENAME;
            if ($roleName==='用户' or $roleName==="审核员"){
                $criteria ->addCondition('reporter_id='.$userId);
            }
        }

        //查询
        $criteria->condition=get_where($criteria->condition,($start_date_operate!=""),'operate_time>=',$start_date_operate,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_operate!=""),'operate_time<=',$end_date_operate,'"');

        $criteria->condition=get_where($criteria->condition,($start_date_report!=""),'report_date>=',$start_date_report,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_report!=""),'report_date<=',$end_date_report,'"');



        $data = array();
        parent::_list($model, $criteria, 'index', $data);
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

        $data['istoday']=$istoday;
        parent::_list($model, $criteria, 'index', $data);
    }

    //待审核
    public function actionIndex_appoint_wait($keywords = '',  $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='待审核'";

        $this->actionIndex_appoint_by_condition($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }

    //已审核
    public function actionIndex_appoint_finish($keywords = '', $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='已通过' or state='未通过'";

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
        parent::_list($model, $criteria, 'index', $data);

    }
//以上报日期搜素
    public function actionIndex_appoint_report_by_condition($keywords='',$start_date_report='',$end_date_report='') {
        $model=$this->setCookieAndGetModel();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getReportInfoKeyWords($keywords);
//        if($w){
//            $criteria -> addCondition($w);
//        }
        // $start_date_report=DecodeAsk('start_date_report');
        $criteria->condition=get_where($criteria->condition,($start_date_report!=""),'report_date>=',$start_date_report,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_report!=""),'report_date<=',$end_date_report,'"');
        $data['istoday']=DecodeAsk('is_today');
        parent::_list($model, $criteria, 'index', $data);
    }



    public function getReportInfoKeyWords($keywords){
        return  get_like('1','id,theme,report_order,report_date,reporter_name ,state,operate_time,checktor',$keywords);
    }

    function DecodeAsk($var,$default='0'){
        return isset($_REQUEST[$var])?$_REQUEST[$var]:$default;
    }
}