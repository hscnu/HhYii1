<?php

class OnShelfProductController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionDelete($id) {
        parent::_clear($id);
    }


//    public function actionCreate() {
//        $modelName = $this->model;
//        $model = new $modelName('create');
//        $data = array();
//        if (!Yii::app()->request->isPostRequest) {
//            $data['model'] = $model;
//            $this->render('update', $data);
//
//        } else {
//            $this->saveData($model, $_POST[$modelName]);
//        }
//    }


//    public function actionUpdate($id) {
//        $modelName = $this->model;
//        $model = $this->loadModel($id, $modelName);
//        $data = array();
//        $data['model'] = $model;
//        $this->render('update', $data);
//    }


//    function saveData($model, $post) {
//        $model->attributes = $post;
//        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
//    }


    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;

        $criteria -> condition = $this->getReportInfoKeyWords($keywords);

        $userId=get_session('userId');
        $tmp=User::model()->find('userId='.$userId);
        if($tmp){
            $roleName=$tmp->F_ROLENAME;
            $now_date = Date('Y-m-d H:i:s');
            if ($roleName==='用户'){
                $criteria->condition=get_where($criteria->condition,($now_date!=""),'sale_time<=',$now_date,'"');
            }
            elseif ($roleName==='审核员'){
                $criteria->condition=get_where($criteria->condition,($now_date!=""),'put_time<=',$now_date,'"');
            }
        }

        $data = array();
        parent::_list($model, $criteria, 'index', $data);

    }

    public function getReportInfoKeyWords($keywords){
        return  get_like('1','product_name,price,number,number_unit,supplier,trade_means,contact_details',$keywords);
    }

    function DecodeAsk($var,$default='0'){
        return isset($_REQUEST[$var])?$_REQUEST[$var]:$default;
    }
}
