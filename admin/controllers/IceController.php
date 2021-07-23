<?php

class IceController extends BaseController {

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


    function saveData($model, $post) {
        $model->attributes = $post;
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    //渔民预约冰页面
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
    //物流人员业务页面
    public function actionIndex_logistic($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'index_logistic', $data);
    }
    //派送订单页面
    public function actionIndex_appointing($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'index_appointing', $data);
    }

    public function getIceKeyWords($keywords){
        return  get_like('1','id,order_name,order_tel,order_time,ice_amount,order_remark,order_time',$keywords);
    }
    //选择派送人员
    public function actionSetShrIdAndName($oId,$shrId){
        $shr=User::model()->find('userId='.$shrId);
        $order=Ice::model()->findAll("id in (".$oId.")");
        if($order){
            foreach ($order as $v){
                $v->deliver_id=$shrId;
                $v->deliver_name=$shr->TCNAME;
                $v->deliver_tel=$shr->PHONE;
                $v->order_state=5;
                $v->save();
            }
        }
        echo CJSON::encode('succeed');
    }
    //获取用户keyword
    public function getUserKeyWords($keywords){
        return  get_like('1','TCNAME',$keywords);
    }
    //打开弹出框
    public function actionOpenDialogShr($keywords=''){
        $model = User::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getUserKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'select', $data);
    }
    //按键确认
    public function actionqrsh($id,$keywords=''){
        $tmp=Ice::model()->find('id='.$id);
        $tmp->order_state=4;
        $tmp->save();
        $this->actionIndex_logistic($keywords);
    }
    //展示地图
    public function actionShowMap($keywords='',$oId){
        $tmp=Ice::model()->find('id='.$oId);
        $model = Ice::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getUserKeyWords($keywords);
        $data = array();
        $data["longitude"]=$tmp->longitude;
        $data["latitude"]=$tmp->latitude;
        parent::_list($model, $criteria, 'map', $data);
    }







    public function getAppointCountList(){
        $date=array();
        $modelName = $this->model;
        $model = $modelName::model();
        $date['todayCount']= $model->count("order_state=1");
        $date['waitCount']= $model->count("order_state=2");
        $date['finishCount']= $model->count("order_state=3");
        put_msg($date["todayCount"]);
        return $date;
    }


    public function actionIndex_appoint_by_condition($keywords = '',$w='',$istoday=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getIceKeyWords($keywords);
        if($w){
            $criteria -> addCondition($w);
        }
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'order_time',$start_date);
        $data = $this->getAppointCountList();
        $data['istoday']=$istoday;
        put_msg($data["todayCount"]);
        parent::_list($model, $criteria,'index', $data);
    }


    //今日预约
    public function actionIndex_appoint($keywords = '') {
        put_msg(1);
        $w="order_state=1";
        $this->actionIndex_appoint_by_condition($keywords,$w);
    }

    //待派送
    public function actionIndex_appoint_wait($keywords = '') {
        $w="order_state=2";
        $this->actionIndex_appoint_by_condition($keywords,$w);
    }

    //已派送
    public function actionIndex_appoint_finish($keywords = '') {
        $w="order_state=3";
        $this->actionIndex_appoint_by_condition($keywords,$w);
    }










    public function getNav($navData){
        $html='<div class="box-detail-tab box-detail-tab mt15">';
        $html.='<ul class="c">';
        $action=strtolower(Yii::app()->controller->getAction()->id);

        foreach($navData as $item){
            $judgeAction=strtolower($item[0]);
            $titleName=$item[1];
            $hz=$item[2];
            $html.='<li ';
            if($action==$judgeAction){
                $html.='class="current"';
            }
            $html.='>';
            $html.='< a href="';
            $url=$this->createUrl($this->model.'/'.$judgeAction);
            $html.=$url.'">'.$titleName.$hz;
            $html.='</ a></li>';
        }
        $html.='</ul></div>';
        return $html;
    }
}