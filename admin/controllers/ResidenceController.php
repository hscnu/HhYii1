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

    public function actionqrsh($id,$keywords=''){
        $tmp = Residence::model()->find('id='.$id);
        $tmp->state = '已审核';
        $tmp->save();
        $this->actionIndex_Residence_Examine($keywords);
    }


    function saveData($model, $post) {
        put_msg('65');
        put_msg($post);
        put_msg($_POST);
        $model->attributes = $post;
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    //列表搜索
    public function actionIndex_Add_Residence($keywords = '',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);
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
        $criteria -> condition = get_like('1','apply_unit_or_apply_person,account_number',$keywords);
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
        $criteria -> condition = get_like('1','apply_unit_or_apply_person,account_number',$keywords);
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
        $criteria -> condition = get_like('1','apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'uDate>=operation_time',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'uDate<=residence_time',$end_date,'"');
        if($province !== ''){
            $criteria->condition.=' AND club_area_province like "%' . $province . '%"';
        }

        if ($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if ($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
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
        $criteria -> condition = get_like('1','apply_unit_or_apply_person,account_number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'apply_unit_or_apply_person,account_number',$keywords);

        $data = array();
        parent::_list($model, $criteria, 'index_examine_fail_list', $data);
    }

}






