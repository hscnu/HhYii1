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
        foreach (Dish::model()->findAll(array('order' => 'd_name ASC', 'distinct' => true, 'condition' => 'd_rest=:d_rest',
            'params' => array(':d_rest'=>$tmp->eval_rest),)) as $d){
                $dish = $d->d_name;
                $eval_good = EvaluationTable::model()->findAll(array(
                    'order' => 'dish asc',
                    'condition' => 'nice=:nice and dish=:dish',
                    'params' => array(':nice' => 1,':dish'=>$dish),
                ));
                $counter = count($eval_good);
                if($eval_good!=null){
                $eval_all = EvaluationTable::model()->findAll(array(
                    'order' => 'dish asc',
                    'condition' => 'dish=:dish',
                    'params' => array(':dish'=>$dish),
                ));
                $sum = count($eval_all);
                $rate = ceil($counter*100 / $sum);
                $d->d_rate = $rate;
                $d->save();
                }
        }
        $restaurant = Restaurant::model()->find(array(
            'condition' => 'r_name=:r_name',
            'params' => array(':r_name'=>$tmp->eval_rest),
        ));
        $eval_star = 0;
        foreach (Evaluation::model()->findAll(array(
            'condition' => 'eval_rest=:eval_rest',
            'params' => array(':eval_rest'=>$tmp->eval_rest),
        )) as $r)
        {
            $eval_star = $eval_star + $r->eval_star;
        }
        $star_all = Evaluation::model()->findAll(array(
            'condition' => 'eval_rest=:eval_rest',
            'params' => array(':eval_rest'=>$tmp->eval_rest),
        ));
        $star_counter = count($star_all);
        $restaurant->r_service=round($eval_star/$star_counter,1);
        $restaurant->save();
        foreach (Restaurant::model()->findALL(array(
            'order'=>'r_service desc'
        )) as $key => $r)
        {
            $r->r_rank = $key;
            $r->r_rank+=1;
            $r->save();
        }
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