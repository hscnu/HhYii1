<?php

class EvaluationController extends BaseController
{
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
            $data['model']['eval_time'] = date('Y-m-d', time());
//            $data['model']['eval_star'] = $_SESSION['star'];
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }
    public function actionPass($id,$keywords = '') {
        $tmp=Evaluation::model()->find('id = '.$id);
        $tmp->eval_ispass='1';
        $tmp->save();
        $this->actionIndex($keywords);
    }
    public function actionReturn($id,$keywords = '') {
        $tmp=Evaluation::model()->find('id = '.$id);
        $tmp->eval_ispass='0';
        $tmp->save();
        $this->actionIndex($keywords);
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
        $post['eval_time'] = date('Y-m-d', time());
        $post['eval_star'] = $_SESSION['star'];
        $model->attributes = $post;
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }
    public function actionSaveStar() {
        $_SESSION['star']=$_POST['star'];
        echo CJSON::encode('msg');
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
        $start_date=DecodeAsk('eval_time');
        $criteria -> condition = get_like('1','eval_rest',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'eval_rest',$keywords);
        $criteria -> condition= get_like( $criteria -> condition,'eval_time',$start_date);

        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
    public function actionUser($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','eval_star',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'eval_star',$keywords);

        $data = array();
        parent::_list($model, $criteria, 'user', $data);
    }

}