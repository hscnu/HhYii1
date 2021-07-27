
<?php

class FishingReportController extends BaseController {

    protected $model = '';
//ceshi
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

    function saveData($model, $post) {
        $model->attributes = $post;
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }


//列表搜索
    public function actionIndex($keywords = '',$start_date='',$state='2') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $start_date=$start_date?$start_date:Date('Y-m-d');
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','name,number',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'name,number',$keywords);
        $criteria-> condition = get_like( $criteria -> condition,'reporttime',$start_date);
        $criteria-> condition = get_like( $criteria -> condition,'state',$state);
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

  
    //全部审核
    public function checkall(){
        FishingReport::model()->updateAll(array('state' => '1'), "state = '2'");
    }

    //单个审核
    public function actionshenhe($id,$keywords = '') {
        $tmp=FishingReport::model()->find('id = '.$id);
        $tmp->state='1';
        $tmp->save();
        $this->actionIndex($keywords);
    }

    //批量审核
    public function actionPutOut($id,$keywords = '') {
        $tmp=FishingReport::model()->findAll('id in (' . $id . ')');
        foreach ($tmp as $v){
            $v->state='1';
            $v->save();
        }
    }




    public function actionIndex_Wait($keywords = '') {
        $this->actionIndex('待审核',$keywords);
    }

    public function actionIndex_History($keywords = '') {
        $this->actionIndex('已审核',$keywords);
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


}