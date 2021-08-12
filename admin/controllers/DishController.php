<?php


class DishController extends BaseController {

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
        public function actionStation($dish,$rest)
        {
            $_SESSION['dish'] = $dish;
            $_SESSION['rest'] = $rest;
            $this->redirect(array('/evaluation/index'));
        }

    function saveData($model, $post) {
        $model->attributes = $post;
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }
    public function actionSaveLike() {
        $tmp = Restaurant::model()->find(array(
            'select'=>array('id,r_name'),
            'condition' => 'r_name=:r_name',
            'params' => array('r_name'=>$_SESSION['rest']),
        ));
        $id = $tmp->id;
        $tmp=Restaurant::model()->find('id = '.$id);
        $tmp->r_like = $_POST['isLike'];
        $tmp->save();
    }
    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','d_name',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'d_name',$keywords);

        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
    public function actionRest($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','d_name',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'d_name',$keywords);
        $data = array();
        parent::_list($model, $criteria, 'rest', $data);
    }
    public function actionUser($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','d_name',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'d_name',$keywords);
        $criteria->order = 'd_rate desc';
        $data = array();
        parent::_list($model, $criteria, 'user', $data);
    }

}