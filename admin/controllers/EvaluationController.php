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
        function saveData($model, $post) {
            $post['eval_time'] = date('Y-m-d', time());
            $post['eval_star'] = $_SESSION['star'];
            $model->attributes = $post;
            $s1 = $model->save();
            $evals = $_SESSION['evals'];
            $dishes = $_SESSION['dishes'];
            for($i=0;$i<(count($dishes));$i++){
                $table = new EvaluationTable();
                $table->dish = $dishes[$i];
                $table->nice = $evals[$i];
                $table->eval_id = $model->id;
                $table->save();
            }
            $d = Dish::model()->findAll(array(
                'select'=>array('d_name,d_rate,id'),
                'order' => 'd_name ASC',
                'distinct' => true,
            ));
            foreach ($d as $key => $obj){
                if(in_array($obj->d_name,$evals)){
                    $counter = EvaluationTable::model()->findAll(array(
                        'select' => array('dish,id,nice'),
                        'order' => 'dish asc',
                        'condition' => 'nice=:nice,dish=:dish',
                        'params' => array('nice' => 1, 'dish' => $obj->d_name),
                    ))->count();
                    $sum = EvaluationTable::model()->findAll(array(
                        'select' => array('dish,id,nice'),
                        'order' => 'dish asc',
                        'condition' => 'nice=:nice,dish=:dish',
                        'params' => array('nice' => 1, 'dish' => $obj->d_name),
                    ))->count();
                    $rate = ceil($counter / $sum);
                    $d[$key]->d_rate = $rate;
                    $d[$key]->save();
                }
            }
            show_status($s1, '评价成功', get_cookie('_currentUrl_'), '评价失败');
            $this->redirect(array('/restaurant/user'));
        }
        public function actionSaveStar() {
            $_SESSION['star']=$_POST['star'];
            echo CJSON::encode('msg');
        }
    public function actionSaveRest() {
        $_SESSION['eval_rest']=$_POST['opt'];
        header("Refresh:0");
    }
    public  function actionSaveNice()
    {
        $_SESSION['evals'] = $_POST['eval'];
        $_SESSION['dishes'] = $_POST['dish'];
    }
    public  function actionCancel()
    {
        unset($_SESSION['eval_rest']);
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
        $criteria->order = 'eval_time asc';
        $data = array();
        parent::_list($model, $criteria, 'user', $data);
    }
}