<?php

class ReportInfoController extends BaseController {

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
        $criteria -> condition = get_like('1','report_order,report_date,report_name,report_state,report_checktor',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'report_order,report_date,report_name,report_state,report_checktor',$keywords);
        $data = array();
        parent::_list($model, $criteria, 'index', $data);

    }

    // public function actionIndex_appoint_by_condition($keywords = '',$w='',$istoday=0) {
    //     set_cookie('_currentUrl_', Yii::app()->request->url);
    //     $modelName = $this->model;
    //     $model = $modelName::model();
    //     $criteria = new CDbCriteria;
    //     // $criteria -> condition = $this->getIceKeyWords($keywords);
    //     if($w){
    //         $criteria -> addCondition($w);
    //     }
    //     $start_date=DecodeAsk('start_date');
    //     $criteria -> condition= get_like( $criteria -> condition,'report_date',$start_date);
    //     $data = $this->getAppointCountList();
    //     $data['istoday']=$istoday;
    //     parent::_list($model, $criteria, 'index_appoint', $data);
    // }


    // //今日审核
    // public function actionIndex_appoint($keywords = '') {
    //     $w=get_like(1,'report_date',Date('Y-m-d'));
    //     $this->actionIndex_appoint_by_condition($keywords,$w,1);
    // }

    // //未审核
    // public function actionIndex_appoint_wait($keywords = '') {
    //     $w="state='未审核'";
    //     $this->actionIndex_appoint_by_condition($keywords,$w);
    // }

    // //上报记录列表
    // public function actionIndex_appoint_finish($keywords = '') {
    //     $w="state='已审核' or state='未审核'";
    //     $this->actionIndex_appoint_by_condition($keywords,$w);
    // }

    // function DecodeAsk($var,$default='0'){
    //     return isset($_REQUEST[$var])?$_REQUEST[$var]:$default;
    // }
}