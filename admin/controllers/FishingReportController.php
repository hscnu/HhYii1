<?php

class FishingReportController extends BaseController {

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
        $model->check_save=0;//跳过必填（required）检验
        $model->save();
        $this->actionUpdate($model->id);//跳转到修改动作
    }





//列表搜索
    public function actionIndex($views='',$keywords = '',$w='',$state='',$start_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        //$criteria = new CDbCriteria;
        //$criteria -> condition = get_like('1','name,number',$keywords);
        //$criteria -> condition = get_like( $criteria -> condition,'name,number',$keywords);
        //$criteria-> condition = get_like( $criteria -> condition,'state',$state);
        //模型筛选条件
        $criteria = $this->addcondition($model,$views,$keywords,$w,$state);
        //判断按钮操作
        if(DecodeAsk('oper','')=='checkall'){
            $this->checkall();
        }
        $data = array();
        $data['time']=$model::model()->getInfoFromMenu($views,'p_time');
        $data['views']=$views;
        $_SESSION['views']=$views;
        // put_msg(CJSON::encode($criteria));
        parent::_list($model, $criteria, 'index', $data);
    }
    public function addcondition($model,$views,$keywords,$w,$state){
        $criteria = new CDbCriteria;
        $start_date=DecodeAsk('start_date',Date('Y-m-d'));
        $state=DecodeAsk('state',$state);
        $criteria -> condition = get_like( '1' ,'id,name,fishingtime,reporttime,count,state,number,company',$keywords);
        $criteria-> condition = get_like( $criteria -> condition,'reporttime',$start_date);
        //附加条件
        $p_condition=$model::model()->getInfoFromMenu($views,'p_condition');
        if(!empty($p_condition))
            $criteria->addCondition($p_condition);
        if($state!=''){
            $criteria->addCondition('state='.$state);
        }
        if(!empty($w)){
            $criteria->addCondition($w);
        }
        put_msg(CJSON::encode($criteria));
        return $criteria;
    }


    public function actionIndex_Register($keywords = '') {
        $this->actionIndex('捕鱼上报',$keywords);
    }

    public function actionIndex_Wait($keywords = '') {
        $this->actionIndex('待审核',$keywords,'','1');
    }

    public function actionIndex_History($keywords = '') {
        $this->actionIndex('已审核',$keywords);
    }

    public function actionIndex_all($keywords = '') {
        $this->actionIndex('所有上报',$keywords);
    }

    //全部审核通过
    public function checkall(){
        FishingReport::model()->updateAll(array('state' => '2'), "state = '1'");
    }


    //单个审核通过
    public function actionshenhe($id,$keywords = '') {
        $tmp=FishingReport::model()->find('id = '.$id);
        $tmp->state='2';
        $tmp->save();
        $this->actionIndex('待审核',$keywords);
    }

    //批量审核通过
    public function actionPlsh($id,$keywords = '') {
        $tmp=FishingReport::model()->findAll('id in (' . $id . ')');
        put_msg(CJSON::encode($tmp));
        foreach ($tmp as $v){
            $v->state='2';
            $v->save();
        }

    }


    //单个审核不通过
    public function actionshenhen($id,$keywords = '') {
        $tmp=FishingReport::model()->find('id = '.$id);
        $tmp->state='3';
        $tmp->save();
        $this->actionIndex('待审核',$keywords);
    }

    public function actionOpenDialog(){
        $modelName='ReportDetail';
        $detail_id=DecodeAsk('detail_id');
        if($detail_id){
            $model=$this->loadModel($detail_id,$modelName);
        }
        else{
            $model = new ReportDetail();
            $model->order_id=DecodeAsk('order_id');
        }

        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['isClose'] = DecodeAsk('isClose');
            $this->render('update_detail', $data);
        }else {
            $this->Save_detail($model, $_POST['ReportDetail']);
        }
    }

    public function Save_detail($model, $post) {
        $model->attributes = $post;
        $url=Yii::app()->request->getUrl().'&isClose=1';
        show_status($model->save(), '保存成功',$url, '保存失败');
    }

    public function actionSaveFormDate($id){
        $model=$this->loadModel($id,$this->model);
        $model->check_save=0;
        $model->attributes = $_REQUEST[$this->model];
        $model->save();
    }

    function saveData($model, $post) {
        $model->attributes = $post;
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }



    public function actionUpdate($id='0') {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $detailList=ReportDetail::model()->findAll('order_id='.$id);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['detailList'] = $detailList;
            $this->render('update', $data);
        } else {
            $this->Save_detail($model, $_POST[$modelName]);
        }
    }





}