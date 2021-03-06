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
            $yes = '????????????';
            $no = '????????????';
        }elseif($_POST['submitType'] == 'tijiaoshenhe'){
            $model->state = '?????????';
            $yes = '????????????';
            $no = '????????????';
        }elseif($_POST['submitType'] == 'shenhetongguo'){
            $model->state = '????????????';
            $yes = '????????????????????????';
            $no = '???????????????';
        }elseif($_POST['submitType'] == 'shenheweitongguo') {
            $model->state = '???????????????';
            $yes = '????????????????????????';
            $no = '???????????????';
        }
        show_status($model->save(), $yes, get_cookie('_currentUrl_'),$no);
    }

    //????????????
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
        $criteria -> condition = get_like("state='?????????'",'apply_unit_or_apply_person,account_number',$keywords);
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
        $criteria -> condition = get_like("state='?????????'",'apply_unit_or_apply_person,account_number',$keywords);
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
        $criteria -> condition = get_like("state='????????????'",'apply_unit_or_apply_person,account_number',$keywords);
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
        $criteria -> condition = get_like("state='???????????????'",'apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);

        $data = array();
        parent::_list($model, $criteria, 'index_examine_fail_list', $data);
    }

    public function actionIndex_Home($keywords = '',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like("1",'apply_unit_or_apply_person,account_number',$keywords);
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'uDate>=operation_time',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'uDate<=residence_time',$end_date,'"');
        $criteria ->addCondition('user_id = '.get_session('userId') );
        $data = array();
        parent::_list($model, $criteria, 'index_home', $data);
    }

    public function actionaddInfoRz(){
        $tmp=FishingBoat::model()->find('user_id='.get_session('userId'));
        if(empty($tmp)){
            $tmp=new FishingBoat();
        }


        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $tmp;
            $this->render('mobile_update', $data);
        } else {
            $this->saveData($tmp, $_POST['FishingBoat']);
        }
    }


    public function actionmobile_Create() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('mobile_update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }

    public function actionupdateMyInfo() {
        $modelName = $this->model;
        $model = $modelName::model()->getModelByUserId();
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('mobile_my_info', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }

    public function actionmobile_revise_my_info() {
        $modelName = $this->model;
        $model = $modelName::model()->getModelByUserId();
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('mobile_revise_my_info', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }

    }
}