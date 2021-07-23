<?php

class PackageController extends BaseController {

    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
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
        $url=get_cookie('_currentUrl_');
        if ($_POST['submitType'] == 'baocun'){
            $s2=str_replace('package/index_register','package/index_register',$url);
        } elseif($_POST['submitType'] == 'baonext'){
            $s2=str_replace('package/index_register','package/create',$url);
        }
        show_status($model->save(), '保存成功',$s2, '保存失败');
    }

    //列表搜索
    public function actionIndex($views='',$keywords = '',$w='',$template='index') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        //模型筛选条件
        $criteria = $this->addcondition($model,$views,$keywords,$w);
        //判断按钮操作
        if(DecodeAsk('oper','')=='putOutAll'){
            $this->putOutAll();
        }
        $data = array();
        $data['time']=$model::model()->getInfoFromMenu($views,'p_time');
        $data['views']=$views;
        $_SESSION['views']=$views;
        put_msg(CJSON::encode($criteria));
        parent::_list($model, $criteria, $template, $data);
    }

    public function addcondition($model,$views,$keywords,$w){
        $criteria = new CDbCriteria;
        $isputout=DecodeAsk('is_putout','');
        $criteria -> condition = get_like( '1' ,'id,p_name,c_name,c_number,p_picture,p_type,pick_state',$keywords);
        //附加条件
        $p_condition=$model::model()->getInfoFromMenu($views,'p_condition');
        if(!empty($p_condition))
            $criteria->addCondition($p_condition);
        if($isputout!=''){
            $criteria->addCondition('is_putout='.$isputout);
        }
        if(!empty($w)){
            $criteria->addCondition($w);
        }
        //个人视图
        if($views!='等待取件'&&$views!='代领广场') {
            $w2=$this->adminfilter('c_id = '. Yii::app()->session['userId']);
            $criteria->addCondition($w2);
        }
        return $criteria;
    }


    //管理员条件过滤
    public function adminfilter($w){
        return substr_count(Yii::app()->session['F_ROLENAME'],'管理员')?'':$w;
    }

    //全部上架
    public function putOutAll(){
        Package::model()->updateAll(array('is_putout' => '1','put_time'=>Date('Y-m-d H:i:s')), "is_putout = '0'");
    }

    //单个上架
    public function actionPutKd($id,$keywords = '') {
        $tmp=Package::model()->find('id = '.$id);
        $tmp->is_putout='1';
        $tmp->put_time=Date('Y-m-d H:i:s');
        $tmp->save();
        $this->actionIndex('快递上架',$keywords);
    }

    //批量上架
    public function actionPutOut($id,$keywords = '') {
        $tmp=Package::model()->findAll('id in (' . $id . ')');
        foreach ($tmp as $v){
            $v->is_putout='1';
            $v->put_time=Date('Y-m-d H:i:s');
            $v->save();
        }
    }


    public function actionIndex_Register($keywords = '') {
        $this->actionIndex('快递录入',$keywords);
    }

    public function actionIndex_Pickup_Wait($keywords = '') {
       $w=$this->adminfilter('c_id = '.Yii::app()->session['userId'].' or dl_id= '.Yii::app()->session['userId']);
       $this->actionIndex('等待取件',$keywords,$w);
    }

    public function actionIndex_Help_Wait($keywords = '') {
        $this->actionIndex('等待代领',$keywords);
    }

    public function actionIndex_Confirm_Wait($keywords = '') {
        $this->actionIndex('等待收货',$keywords);
    }

    public function actionIndex_Pickup_History($keywords = '') {
        $this->actionIndex('已经取件',$keywords);
    }

    public function actionIndex_Help_History($keywords = '') {
        $this->actionIndex('已经代领',$keywords);
    }

    public function actionIndex_Confirm_History($keywords = '') {
        $this->actionIndex('已经收货',$keywords);
    }

    public function actionIndex_Square($keywords = '') {
        $this->actionIndex('代领广场',$keywords);
    }

    public function actionIndex_Put($keywords = '') {
        $this->actionIndex('快递上架',$keywords);
    }

    public function actionIndex_flow($keywords = '') {
        $w=" (DATE_FORMAT(register_time,'%Y-%m-%d')) = '".Date('Y-m-d')."'";
        $w.=" or (DATE_FORMAT(pickup_time,'%Y-%m-%d')) = '".Date('Y-m-d')."'";
        $this->actionIndex('今日流水',$keywords,$w);
    }


}
