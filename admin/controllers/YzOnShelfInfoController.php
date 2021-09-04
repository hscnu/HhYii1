<?php

class YzOnShelfInfoController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }


    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $data = $model->find('id='.$id);
        YzOnShelfProduct::model()->deleteAll('report_order='.$data['report_order']);
        parent::_clear($id);
    }


    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $model->check_save=0;//跳过必填（required）检验
        $model->report_order = Date('YmdHis').get_session('userId');
        $model->state = '填写中';
        $model->reporter_id = get_session('userId');
        $model->reporter_name = get_session('TCNAME');
        $model->save();
        $this->actionUpdate($model->id);//跳转到修改动作
    }

    public function actionUpdate($id='0') {

        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        if (!Yii::app()->request->isPostRequest) {
            put_msg($id);
            $modelName2 = 'YzOnShelfProduct';
            $model2=new $modelName2();
            $data = array();
            $data['model'] = $model;
            $data['model2'] = $model2;

            $this->render('update', $data);
        } else {
            put_msg($id);
            $this->saveData2($model, $_POST[$modelName]);
        }
    }

    function saveData2($model, $post1) {
        $model->attributes = $post1;
        $modelName2 = 'YzOnShelfProduct';

        $production = $_POST['dataArray'];
        $report_order = $model->report_order;

        $check = YzOnShelfProduct::model()->find('report_order='.$report_order);

        if(empty($check)){

            $tmp=UserFarmProduct::model()->findAll('user_id='.get_session('userId').' order by product_id');

            foreach ($tmp as $k =>$v){
                $model2=new $modelName2();
                $model2->report_order = $report_order;
                $model2->production = $production[$k];
                $model2->product_id = $v->product_id;
                $model2->product_name = $v->product_name;
                $model2->production_unit = $v->production_unit;
                $model2->origin_place = $v->origin_place;
                $model2->save();
            }
        }
        else{
            $tmp = YzOnShelfProduct::model()->findAll('report_order='.$report_order.' order by product_id');
            foreach ($tmp as $k =>$v){
                $v->production = $production[$k];
                $v->save();
            }
        }

        $model->operate_time = Date('Y-m-d H:i:s');
        if (DecodeAsk('submitType') == 'tijiao'){
            $model->state = '待审核';
            $message1 = '提交成功';
            $message2 = '提交失败';
        }
        else {
            $model->state = '待上报';
            $message1 = '保存成功';
            $message2 = '保存失败';
        }
        if ($model->save()) {
            $model->deleteAll("report_order=".$report_order." and state='填写中'");
            show_status($model->save(), $message1, get_cookie('_currentUrl_'), $message2);
        }
        else show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

//    public function actionOpenDialog(){
//        $modelName='YzOnShelfProduct';
//        $detail_id=DecodeAsk('detail_id');
//        if($detail_id){
//            $model=$this->loadModel($detail_id,$modelName);
//        }
//        else{
//            $model = new YzOnShelfProduct();
//            $model->report_order=DecodeAsk('report_order');
//        }
//        if (!Yii::app()->request->isPostRequest) {
//            $data = array();
//            $data['model'] = $model;
//            $data['isClose'] = DecodeAsk('isClose');
//            $this->render('update_detail', $data);
//        }else {
//            $this->Save_detail($model, $_POST['YzOnShelfProduct']);
//        }
//    }
//
//    public function Save_detail($model, $post) {
//        $model->attributes = $post;
//        $model->save();
//        if ($_POST['submitType'] == 'baonext')
//        {
//            $url=Yii::app()->request->getUrl().'&isClose=0';
//        }
//        else $url=Yii::app()->request->getUrl().'&isClose=1';//刷新并传递参数通知弹窗关闭
//        show_status(1, '保存成功',$url, '保存失败');
//    }
//
//    public function actionSaveFormDate($id){//打开弹窗前先保存一次
//        $model=$this->loadModel($id,$this->model);
//        $model->check_save=0;
//        $model->attributes = $_REQUEST[$this->model];
//        $model->save();
//    }


//    function saveData($model, $post) {
//
//        $model->attributes = $post;
//        if ($model->save()) {
//            $model->operate_time = Date('Y-m-d H:i:s');
//            if (DecodeAsk('submitType') == 'tijiao'){
//                $model->state = '待审核';
//                $message1 = '提交成功';
//                $message2 = '提交失败';
//            }
//            else {
//                $model->state = '待上报';
//                $message1 = '保存成功';
//                $message2 = '保存失败';
//            }
//            show_status($model->save(), $message1, get_cookie('_currentUrl_'), $message2);
//        }
//        else show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
//    }


    //列表搜索
    public function actionIndex($keywords = '',$start_date_operate='',$end_date_operate='',$start_date_report='', $end_date_report='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();

        $data = $model->findAll("state='填写中'");
        foreach ($data as $v) {
            YzOnShelfProduct::model()->deleteAll('report_order='.$v['report_order']);
        }
        $model->deleteAll("state='填写中'");

        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getYZReportInfoKeyWords($keywords);
        $criteria ->addCondition("state='待上报'");

        $user_type = get_session('F_ROLENAME');
        if ($user_type === '用户') {
            $criteria->addCondition('reporter_id=' . get_session('userId'));
        }

        $data = array();

        parent::_list($model, $criteria, 'index', $data);
    }



    public function actionIndexVerify($keywords = '',$w='')
    {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();

        $data = $model->findAll("state='填写中'");
        foreach ($data as $v) {
            YzOnShelfProduct::model()->deleteAll('report_order='.$v['report_order']);
        }
        $model->deleteAll("state='填写中'");

        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getYZReportInfoKeyWords($keywords);

        if($w=='待审核'){
            $criteria->addCondition("state='待审核'");
        }
        else
        {
            $criteria ->addCondition("state='通过' or state='不通过'");
            $criteria ->addCondition("audit_date='".Date('Y-m-d')."'");
            $criteria ->addCondition('auditor_id='.get_session('userId'));
        }

        $data = array();
        $data['waitCount']=$model->count("state='待审核'");
        $data['todayFinishCount']=$model->count("auditor_id=".get_session('userId')." and audit_date='".Date('Y-m-d')."'");

        parent::_list($model, $criteria, 'index_verify', $data);
    }
    //待审核
    public function actionIndexVerify_wait($keywords = '',$w='') {
        $w='待审核';
        $this->actionIndexVerify($keywords,$w);
    }
    //今日已审核
    public function actionIndexVerify_today($keywords = '',$w='') {
        $w = '今日已审核';
        $this->actionIndexVerify($keywords,$w);
    }


    //审核界面
    public function actionUpdateVerify($id='0',$isAdd=0) {
        $modelName = $this->model;

//        put_msg($id);
        if (!Yii::app()->request->isPostRequest) {
            if ($isAdd == 1) {
                $data = YzOnShelfInfo::model()->find("state='待审核' order by id");
                if (!empty($data)) {
                    $model = $this->loadModel($data->id, $modelName);
                    if(DecodeAsk('isClose')==0){
                        $model->auditor_id = get_session('userId');
                        $model->auditor = get_session('TCNAME');
                        $model->state = '审核中';
                        $model->save();
                    }

                    $detailList = YzOnShelfProduct::model()->findAll('report_order=' . $model->report_order);
                    $data = array();
                    $data['model'] = $model;
                    $data['detailList'] = $detailList;
                    $data['isClose'] = DecodeAsk('isClose');
                    $this->render('update_verify', $data);
                }
            } else {
                $data = array();
                $model = $this->loadModel($id, $modelName);
                if(DecodeAsk('isClose')==0){
                    $model->auditor_id = get_session('userId');
                    $model->auditor = get_session('TCNAME');
                    $model->state = '审核中';
                    $model->save();
                }

                $detailList = YzOnShelfProduct::model()->findAll('report_order=' . $model->report_order);
                $data['model'] = $model;
                $data['detailList'] = $detailList;
                $data['isClose'] = DecodeAsk('isClose');
                $this->render('update_verify', $data);
            }
        }
        else {
            $this->saveDataVerify($_POST[$modelName]);
        }


    }

    function saveDataVerify($post) {
//        put_msg($post);

        $model = YzOnShelfInfo::model()->find('report_order='.$post['report_order']);
        $model->attributes=$post;
        $model->audit_date = Date('Y-m-d');

        if ($_POST['submitType'] == 'baonext')
        {
            $next_id='';
            $array=YzOnShelfInfo::model()->findAll("state='待审核'  order by id");
            foreach ($array as $k=>$v){
                if($k<count($array))
                {
                    $next_id=$array[$k]->id;
                    break;}
            }
            if(!empty($next_id)){
                $s2=strstr(Yii::app()->request->getUrl(),'id=',true).'id='.$next_id;
                show_status($model->save(), '保存成功',$s2, '保存失败');
            }
        }
        $url=strstr(Yii::app()->request->getUrl(),'id=',true).'id='.$model->id;
        $url.='&isClose=1';//刷新并传递参数通知弹窗关闭
        show_status($model->save(), '保存成功',$url, '保存失败');
    }



    public function getAppointCountList(){
        $data=array();
        $modelName = $this->model;
        $model = $modelName::model();
        $data['waitreportCount']= $model->count("state='待上报' and reporter_id = ".get_session('userId'));
        $data['waitCount']= $model->count("state='待审核' and reporter_id = ".get_session('userId'));
//        $data['auditedCount']= $model->count("state='通过' or state='不通过'");
        $data['passCount']= $model->count("state='通过' and reporter_id = ".get_session('userId'));
        $data['noPassCount']= $model->count("state='不通过' and reporter_id = ".get_session('userId'));
        return $data;
    }

    //审核列表
    public function actionIndexVerify_appoint($keywords = '',$start_date_operate='',$end_date_operate='',$start_date_report='', $end_date_report='',$w='')
    {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();

        $data = $model->findAll("state='填写中'");
        foreach ($data as $v) {
            YzOnShelfProduct::model()->deleteAll('report_order='.$v['report_order']);
        }
        $model->deleteAll("state='填写中'");

        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getYZReportInfoKeyWords($keywords);

        if($w)
        {
            $criteria -> addCondition($w);
        }
        else $criteria ->addCondition("state='待审核'");

        $criteria->condition=get_where($criteria->condition,($start_date_operate!=""),'operate_time>=',$start_date_operate,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_operate!=""),'operate_time<=',$end_date_operate,'"');

        $criteria->condition=get_where($criteria->condition,($start_date_report!=""),'report_date>=',$start_date_report,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_report!=""),'report_date<=',$end_date_report,'"');

        $data = array();

        parent::_list($model, $criteria, 'index_verify_appoint', $data);
    }

    //待审核
    public function actionIndexVerify_appoint_wait($keywords = '',  $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='待审核'";
        $this->actionIndexVerify_appoint($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }
    //已审核
    public function actionIndexVerify_appoint_finish($keywords = '',  $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='通过' or state='不通过'";
        $this->actionIndexVerify_appoint($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }

    //已通过
    public function actionIndexVerify_appoint_by_pass($keywords = '', $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='通过'";
        $this->actionIndexVerify_appoint($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }
    //不通过
    public function actionIndexVerify_appoint_by_no_pass($keywords = '', $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='不通过'";
        $this->actionIndexVerify_appoint($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }

    //以操作时间搜索
    public function actionIndexVerify_appoint_operate_condition($keywords='',$start_date_operate='',$end_date_operate='') {
        $model=$this->setCookieAndGetModel();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getYZReportInfoKeyWords($keywords);
        $criteria->condition=get_where($criteria->condition,($start_date_operate!=""),'operate_time>=',$start_date_operate,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_operate!=""),'operate_time<=',$end_date_operate,'"');
        $data = array();
        parent::_list($model, $criteria, 'index_verify_appoint', $data);
    }

    //以上报日期搜素
    public function actionIndexVerify_appoint_report_condition($keywords='',$start_date_report='',$end_date_report='') {
        $model=$this->setCookieAndGetModel();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getYZReportInfoKeyWords($keywords);
        $criteria->condition=get_where($criteria->condition,($start_date_report!=""),'report_date>=',$start_date_report,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_report!=""),'report_date<=',$end_date_report,'"');
        $data = array();
        parent::_list($model, $criteria, 'index_verify_appoint', $data);
    }

    //养殖记录
    public function actionIndex_Appoint($keywords = '',$start_date_operate='',$end_date_operate='',$start_date_report='', $end_date_report='', $w='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();

//        $data = $model->findAll("state='填写中'");
//        foreach ($data as $v) {
//            YzOnShelfProduct::model()->deleteAll('report_order='.$v['report_order']);
//        }
//        $model->deleteAll("state='填写中'");

        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getYZReportInfoKeyWords($keywords);

        if($w)
        {
            $criteria -> addCondition($w);
        }
        else $criteria ->addCondition("state='待审核'");

        $criteria->condition=get_where($criteria->condition,($start_date_report!=""),'report_date>=',$start_date_report,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_report!=""),'report_date<=',$end_date_report,'"');
        $criteria->condition=get_where($criteria->condition,($start_date_operate!=""),'operate_time>=',$start_date_operate,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_operate!=""),'operate_time<=',$end_date_operate,'"');
        $user_type = get_session('F_ROLENAME');
        if ($user_type === '用户') {
            $criteria->addCondition('reporter_id=' . get_session('userId'));
        }

        $data = $this->getAppointCountList();
        parent::_list($model, $criteria, 'index_appoint', $data);
    }



    //以操作时间搜索
    public function actionIndex_appoint_operate_condition($keywords='',$start_date_operate='',$end_date_operate='') {
        $model=$this->setCookieAndGetModel();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getYZReportInfoKeyWords($keywords);
        $criteria->condition=get_where($criteria->condition,($start_date_operate!=""),'operate_time>=',$start_date_operate,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_operate!=""),'operate_time<=',$end_date_operate,'"');
        $data = array();
        parent::_list($model, $criteria, 'index_appoint', $data);
    }

    //以上报日期搜素
    public function actionIndex_appoint_report_condition($keywords='',$start_date_report='',$end_date_report='') {
        $model=$this->setCookieAndGetModel();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getYZReportInfoKeyWords($keywords);
        $criteria->condition=get_where($criteria->condition,($start_date_report!=""),'report_date>=',$start_date_report,'"');
        $criteria->condition=get_where($criteria->condition,($end_date_report!=""),'report_date<=',$end_date_report,'"');
        $data = array();
        parent::_list($model, $criteria, 'index_appoint', $data);
    }

    //全部列表
    public function actionIndex_appoint_total($keywords = '',  $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w=$this->getYZReportInfoKeyWords($keywords);

        $this->actionIndex_Appoint($keywords,$start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }
    //待上报
    public function actionIndex_appoint_wait_report($keywords = '',  $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='待上报'";
        $this->actionIndex_Appoint($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }

    //待审核
    public function actionIndex_appoint_wait_verify($keywords = '',  $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='待审核'";
        $this->actionIndex_Appoint($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }

    //已通过
    public function actionIndex_appoint_by_pass($keywords = '', $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='通过'";
        $this->actionIndex_Appoint($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }
    //不通过
    public function actionIndex_appoint_by_no_pass($keywords = '', $start_date_operate='', $end_date_operate='',$start_date_report='', $end_date_report='') {
        $w="state='不通过'";
        $this->actionIndex_Appoint($keywords, $start_date_operate, $end_date_operate,$start_date_report, $end_date_report,$w);
    }

    public function setCookieAndGetModel(){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        return $modelName::model();
    }


    public function getYZReportInfoKeyWords($keywords){
        return  get_like('1','theme,report_order,report_date,reporter_name ,state,operate_time,auditor',$keywords);
    }


    function DecodeAsk($var,$default='0'){
        return isset($_REQUEST[$var])?$_REQUEST[$var]:$default;
    }
}