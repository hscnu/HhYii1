<?php

class ResidenceController extends BaseController {

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
    public function actionExamine_Detail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('examine_detail', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }

    public function actionqrdsh($id,$keywords=''){
        $tmp = Residence::model()->find('id='.$id);
        $tmp->state = '?????????';
        $tmp->save();
        $this->actionIndex_Residence_Examine($keywords);
    }


    function saveData($model, $post) {
        $modelName = $this->model;
        $model->attributes = $_POST[$modelName];
        $url=get_cookie('_currentUrl_');
        if ($_POST['submitType'] == 'baocun'){
            $yes = '????????????';
            $no = '????????????';
            $model->user_id = get_session('userId');
        }elseif($_POST['submitType'] == 'tijiaoshenhe'){
            $model->state = '?????????';
            $yes = '???????????????';
            $no = '??????????????????';
        }elseif($_POST['submitType'] == 'shenhetongguo'){
            $model->state = '????????????';
            $yes = '????????????????????????';
            $no = '???????????????';
        }elseif($_POST['submitType'] == 'shenheweitongguo') {
            $model->state = '???????????????';
            $yes = '????????????????????????';
            $no = '???????????????';
        }
        $s1=$model->save();
        show_status($s1, $yes, get_cookie('_currentUrl_'),$no);
    }

    //????????????
    public function actionIndex_Add_Residence($keywords = '',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> addCondition('user_id = '.get_session('userId')  );
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'uDate>=operation_time',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'uDate<=residence_time',$end_date,'"');
        $data = array();
        parent::_list($model, $criteria, 'index_add_residence', $data);
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

    public function actionIndex_Residence_Examine($keywords = '',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like("state='?????????'",'state',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'uDate>=operation_time',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'uDate<=residence_time',$end_date,'"');
        $data = array();
        parent::_list($model, $criteria, 'index_residence_examine', $data);
    }

    public function actionIndex_Residence_List($keywords = '',$start_date='',$end_date='',$province='',$city='',$area='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_type=8 and if_del=510 and unit_state=648';
        $criteria -> condition = get_like("state='????????????'",'apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'uDate>=operation_time',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'uDate<=residence_time',$end_date,'"');
        if($province !== ''){
            $criteria->condition.=' AND club_area_province like "%' . $province . '%"';
        }

        if ($city == '?????????' || $city == '?????????' || $city == '???????????????????????????') {
            $city = '';
        }
        if ($area == '?????????' || $area == '?????????' || $area == '???????????????????????????') {
            $area = '';
        }

        if ($city != '') {
            $criteria->condition.=' AND (club_area_city like "%' . $city . '%" or club_area_district like "%' . $city . '%" or club_area_township like "%' . $city . '%")';
        }

        if ($area != '') {
            $criteria->condition.=' AND ( club_area_city like "%' . $area . '%" or club_area_district like "%' . $area . '%" or club_area_township like "%' . $area . '%")';
        }
        $data = array();
        parent::_list($model, $criteria, 'index_residence_list', $data);
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
        if(empty($tmp)){
            $tmp=new Residence();
        }
        $criteria = new CDbCriteria;

        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $tmp;
            $criteria ->addCondition('user_id = '.get_session('userId') );
            parent::_list($tmp, $criteria, 'index_document', $data);
        } else {
            $this->saveData($tmp, $_POST['Residence']);
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






