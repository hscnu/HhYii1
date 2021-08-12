<?php

class DisinfectionSummaryDetailController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionDelete($id) {
        put_msg(15);
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
        //   put_msg($post);
        //  put_msg($model->attributes);

        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','tableware_name,date,number,cost,total_price',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'tableware_name,date,number,cost,total_price',$keywords);

        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
    //删除无用明细
    public function actionDeleteUselessDetail()
    {
        $db = Yii::app()->db;
        $sql = "DELETE  FROM `disinfection_order_detail` WHERE order_id not in (SELECT id FROM `disinfection_order` WHERE state >0)";
        $command = $db->createCommand($sql);
        show_status($command->execute(), '成功删除', get_cookie('_currentUrl_'), '没有多余的记录');
    }
}