<?php

class DistributorCenController extends BaseController {

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

    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant,res_owner_phone,food_class,food_name,user_name',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant,res_owner_phone,food_class,food_name,user_name',$keywords);

        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
    public function actionGetDistributorDetails($oId, $shrId)
    {
        $shr=DistributorCen::model()->find('user_id='.$shrId);//根据送货人ID找到该用户信息
        $order = DisinfectionOrder::model()->findAll("order_id in (" . $oId . ")");//找订单
        put_msg(11);
        if ($order) {
           foreach ($order as $v){
                $v->deliver_id=$shrId;//填入送货人信息
                $v->deliver_name=$shr->user_name;
                $v->deliver_tel=$shr->user_tel;
                $v->order_state='已派送';//修改状态
                $v->save();
            }

        }
        echo CJSON::encode('succeed');
    }

    public function getOrderKeyWords($keywords)
    {
        return get_like('1', 'user_name', $keywords);
    }


    public function actionOpenDialogDistributor($keywords = '')
    {
        //put_msg($Id);
        $model = DistributorCen::model();
        $criteria = new CDbCriteria;
        $criteria->condition = $this->getOrderKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'select', $data);//渲染select
    }




}