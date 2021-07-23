<?php

class RoleController extends BaseController {

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
        }else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $model->f_opter =  explode(',',  $model->f_opter );
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }/*曾老师保留部份，---结束*/

    function saveData($model,$post) {
        $model->attributes =$post;

        if(!empty( $model->f_opter)||is_array($model->f_opter)) $model->f_opter = implode(',',$post['f_opter']);

        show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    ///列表搜索
    public function actionIndex( $keywords = '',$type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_like('1','f_rname,f_rcode',$keywords,'');
        if ($type != null){
            $criteria->addCondition("f_rname = :f_rname");
            $criteria->params[':f_rname']=$type;
        }

        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

}
