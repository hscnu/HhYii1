<?php

class FishingBoatController extends BaseController {

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

    public function actionExamine($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('examine', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }

    public function actionDetail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('detail', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }

    function saveData($model, $post) {
        $modelName = $this->model;
        $model->attributes = $_POST[$modelName];
        $url=get_cookie('_currentUrl_');
        if ($_POST['submitType'] == 'baocun'){
            $yes = '保存成功';
            $no = '保存失败';
        }elseif($_POST['submitType'] == 'tijiaoshenhe'){
            $model->state = '待审核';
            $yes = '保存成功';
            $no = '保存失败';
        }elseif($_POST['submitType'] == 'shenhetongguo'){
            $model->state = '审核通过';
            $yes = '审核完成，已通过';
            $no = '审核未完成';
        }elseif($_POST['submitType'] == 'shenheweitongguo') {
            $model->state = '审核未通过';
            $yes = '审核完成，未通过';
            $no = '审核未完成';
        }
        show_status($model->save(), $yes, get_cookie('_currentUrl_'),$no);
    }

    //列表搜索
    public function actionIndex_Add_Ship($keywords = '',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'uDate>=operation_time',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'uDate<=residence_time',$end_date,'"');
        $data = array();
        parent::_list($model, $criteria, 'index_add_ship', $data);
    }

    public function actionIndex_Add_Examine($keywords = '',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like("state='待审核'",'apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'uDate>=operation_time',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'uDate<=residence_time',$end_date,'"');
        $data = array();
        parent::_list($model, $criteria, 'index_add_examine', $data);
    }

    public function actionIndex_Ship_Examine($keywords = '',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like("state='待审核'",'apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'uDate>=operation_time',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'uDate<=residence_time',$end_date,'"');
        $data = array();
        parent::_list($model, $criteria, 'index_ship_examine', $data);
    }

    public function actionIndex_Ship_List($keywords = '',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like("state='审核通过'",'apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'uDate>=operation_time',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'uDate<=residence_time',$end_date,'"');
        $data = array();
        parent::_list($model, $criteria, 'index_ship_list', $data);
    }

    public function actionIndex_Examine_Fail_List($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like("state='审核未通过'",'apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);

        $data = array();
        parent::_list($model, $criteria, 'index_examine_fail_list', $data);
    }
}



