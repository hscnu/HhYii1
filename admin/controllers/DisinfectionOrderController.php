<?php

class DisinfectionOrderController extends BaseController {

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
        $model->check_save=0;
        $model->save();
        $this->actionUpdate($model->id);
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $detailList=DisinfectionOrderDetail::model()->findAll('order_id='.$id);
        $uid=get_session('userId');
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['detailList'] = $detailList;

            $temp=DisinfectionOrder::model()->find("appointer_id = '".$uid."' order by date desc");
            if($temp){
                $model->disinfection_name=$temp->disinfection_name;
            }

            $resId=$this->getUserUnit();
            $data['restaurant_name']=Restaurant::model()->getNameFromId($resId);
            $data['code']=$id;
            $this->render('update', $data);
        } else {
            $model->appointer_id=$uid;
            $this->saveData($model, $_POST[$modelName]);
        }
    }

    //获取用户所属单位
    function getUserUnit(){
        $userId=get_session('userId');
        $tmp=User::model()->find('userId='.$userId);
        if($tmp){
            return $tmp->unitId;
        }
    }


    function saveData($model, $post) {
        $model->attributes = $post;
//识别用户单位
        $resId=$this->getUserUnit();
        $model['restaurant_id']=$resId;
        $model['restaurant_name']=Restaurant::model()->getNameFromId($model['restaurant_id']);

        if($model['state']==0){
            $model['state']=1;
        }

        $model['disinfection_id']=DisinfectionCenter::model()->getIdFromName($model['disinfection_name']);
        $model['appoint_time']=date('Y-m-d');
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        ///测试
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        ///测试end
//        $userId=get_session('userId');
//        $tmp=User::model()->find('userId='.$userId);
//        if($tmp){
//            $resId=$tmp->unitId;
//            $criteria ->addCondition('restaurant_id='.$resId);
//        }

        $model->deleteAll('state'.' in (' . 0 . ')');


        $data = $this->getAppointCountList();

        parent::_list($model, $criteria, 'index', $data);
    }
    //添加明细
    public function actionOpenDialog(){
        $modelName='DisinfectionOrderDetail';
        $detail_id=DecodeAsk('detail_id');
        if($detail_id){
            $model=$this->loadModel($detail_id,$modelName);
        }
        else{
            $model = new DisinfectionOrderDetail();
            $model->order_id=DecodeAsk('order_id');
        }

        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['isClose'] = DecodeAsk('isClose');
            $this->render('update_detail', $data);
        }else {
            $this->Save_detail($model, $_POST['DisinfectionOrderDetail']);
        }
    }
    public function actionOpenPreset($order_id){
        $modelName='TableWare';
        $model = $modelName::model();
        $criteria=new CDbCriteria();
        $data = array();
        $data['model'] = $model;
        $data['order_id']=$order_id;
        parent::_list($model, $criteria, 'preset_detail', $data);
    }
    public function actionSavePreset($tablewareIds,$order_id,$number=0){
        foreach (explode(',',$tablewareIds) as $id){
            $tmp=TableWare::model()->find('id='.$id);
            if($tmp){
                $detailModel = new DisinfectionOrderDetail();
                $detailModel->order_id=$order_id;
                $detailModel->number=$number;
                $detailModel->tableware_type=$tmp->type;
                $detailModel->tableware_name=$tmp->name;
                $detailModel->unit=$tmp->unit;
                $detailModel->cost=$tmp->cost;
                $detailModel->tableware_code=$tmp->code;
                $detailModel->save();
            }
        }
        echo CJSON::encode(array('yes'=>'yes'));
    }

    public function Save_detail($model, $post) {
        $model->attributes = $post;
        $tmp = TableWare::model()->find("name='".$model->tableware_name."'");
        $model->tableware_code=$tmp->code;
        $url=Yii::app()->request->getUrl().'&isClose=1';
        show_status($model->save(), '保存成功',$url, '保存失败');
    }



    public function actionSaveFormDate($id){
        $model=$this->loadModel($id,$this->model);
        $model->check_save=0;
        $model->attributes = $_REQUEST[$this->model];
        $model->save();
    }
    //添加明细end
    /////导航栏

    public function actionIndex_by_condition($next_index,$keywords = '',$w='',$examineType='None',$istoday=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;

        $criteria -> condition = $this->getDisinfectionKeyWords($keywords);
        if($w){
            $criteria -> addCondition($w);
        }
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $data = $this->getAppointCountList();
        $data['istoday']=$istoday;
        $data['examineType']=$examineType;

        $indexToUserLimit=array(
            'index_appointed'=>'rest',
            'index_examine'=>'rest',
            'index_get_delivered'=>'rest',
            'index_sign2'=>'rest',
            'index_examine2'=>'disinfection_center',
            'index_sign'=>'disinfection_center',
            'index_get_delivered2'=>'disinfection_center',
        );
        if(isset($indexToUserLimit[$next_index])){
            if($indexToUserLimit[$next_index]=='rest'){
                $criteria -> addCondition($this->rest_limit());
                $data['usersUnit']=$this->getUserUnitName('rest');
            }
            elseif ($indexToUserLimit[$next_index]=='disinfection_center'){
                $criteria -> addCondition($this->disinfection_center_limit());
                $data['usersUnit']=$this->getUserUnitName('disinfection_center');
            }
        }
        else{ $data['usersUnit']='未知';}

        parent::_list($model, $criteria, $next_index, $data);
    }


    //申请中
    public function actionIndex_appoint($keywords = '') {
        $w="state=1";
        $this->actionIndex_by_condition('index_appointed',$keywords,$w,1);
    }

    //已提交
    public function actionIndex_appoint_wait($keywords = '') {
        $w="state=2";
        $this->actionIndex_by_condition('index_appointed',$keywords,$w);
    }

    //待审核
    public function actionIndex_appoint_finish($keywords = '') {
        $w="state=3";
        $examineType='I_examine';
        $this->actionIndex_by_condition('index_examine',$keywords,$w,$examineType);
    }
    //内部审核通过
    public function actionIndex_I_examine($keywords = '') {
        $w="state=12";
        $this->actionIndex_by_condition('index_examine',$keywords,$w);
    }
    //消毒中心审核通过
    public function actionIndex_F_examine($keywords = '') {
        $w="state=4";
        $examineType='F_examine';
        $this->actionIndex_by_condition('index_examine2',$keywords,$w,$examineType);
    }
    //待消毒中心签收
    public function actionIndex_wait_sign($keywords = '') {
        $w="state=15";
        $examineType='Center_Sign';
        $this->actionIndex_by_condition('index_sign',$keywords,$w,$examineType);
    }
    //待酒楼签收
    public function actionIndex_waitRestSign($keywords = '')
    {
        $w = "state=10";
        $examineType='Rest_Sign';
        $this->actionIndex_by_condition('index_sign2', $keywords, $w,$examineType);
    }
    //酒楼已签收
    public function actionIndex_signed($keywords = '') {
        $w="state=11";
        $this->actionIndex_by_condition('index_sign2',$keywords,$w);
    }
    //待酒楼配送
    public function actionIndex_deliver_wait($keywords = '')
    {
        $w = "state=13";
        $this->actionIndex_by_condition('index_get_delivered', $keywords, $w);
    }
    //待消毒中心配送
    public function actionIndex_deliver_wait2($keywords = '')
    {
        $w = "state=14";
        $this->actionIndex_by_condition('index_get_delivered2', $keywords, $w);
    }
    public function getAppointCountList(){
        $modelName = $this->model;
        $userUnit=$this->getUserUnit();
        $todayCount = count($modelName::model()->findAll('state=1'));
        $waitCount = count($modelName::model()->findAll('state=2'));
        $finishCount = count($modelName::model()->findAll('state=3'));
        $waitCenterSign = count($modelName::model()->findAll('state=15'));
        $signedCount = count($modelName::model()->findAll('state=11'));
        $IExamine = count($modelName::model()->findAll('state=12'));
        $FExamine = count($modelName::model()->findAll("state=4 and disinfection_id='".$userUnit."'"));
        $deliver_wait = count($modelName::model()->findAll('state=13'));
        $waitRestSign = count($modelName::model()->findAll('state=10'));
        $deliver_wait2 = count($modelName::model()->findAll('state=14'));
        return array(
            'todayCount'=>$todayCount,
            'waitCount'=>$waitCount,
            'finishCount'=>$finishCount,
            'waitCenterSignCount'=>$waitCenterSign,
            'signedCount'=>$signedCount,
            'IExamineCount'=>$IExamine,
            'FExamineCount'=>$FExamine,
            'deliverwaitCount' => $deliver_wait,
            'waitRestSignCount'=>$waitRestSign,
            'deliverwait2Count'=>$deliver_wait2,
        );
    }
    public function getDisinfectionKeyWords($keywords = ''){
        return get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
    }

    //////导航栏end
    /// 查看明细
    public function actionGetOrderDetails($oId,$shrId){
        //$shr=User::model()->find('userId='.$shrId);//根据送货人ID找到该用户信息
        $order=DisinfectionOrderDetail::model()->findAll("id in (".$oId.")");//找订单

        if($order){
            /*foreach ($order as $v){
                $v->deliver_id=$shrId;//填入送货人信息
                $v->deliver_name=$shr->TCNAME;
                $v->deliver_tel=$shr->PHONE;
                $v->order_state='已派送';//修改状态
               // $v->save();
            }*/

        }
        echo CJSON::encode('succeed');
    }

    public function getOrderKeyWords($keywords){
        return  get_like('1','order_id',$keywords);
    }


    public function actionOpenDialogOrder($keywords='',$Id=0,$nowView='None',$examineType='None'){

        $modelName = $this->model;
        $order_model =$this->loadModel($Id,$modelName);

        $model = DisinfectionOrderDetail::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = $this->getOrderKeyWords($Id);
        $data = array();
        $data['order_model']=$order_model;
        $data['nowView']=$nowView;
        $data['examineType']=$examineType;
        parent::_list($model, $criteria, 'detail', $data);//渲染detail
    }
    /// 查看明细end
    /// 配送订单
    public function actionSetShrIdAndName($oId, $shrId)
    {
        $shr = DistributorCen::model()->find('user_id=' . $shrId);//根据送货人ID找到该用户信息
        $order = DisinfectionOrder::model()->findAll("id in (" . $oId . ")");//找订单
        if ($order) {
            foreach ($order as $v) {
                $v->deliver_id = $shrId;//填入送货人信息
                $v->deliver_name = $shr->user_name;
                $v->deliver_tel = $shr->user_tel;
                $v->state =(($v->state==13)?15:10);//修改状态 13=>待酒楼配送 10=>待酒楼签收 15=>待消毒中心签收
                $v->save();
            }
        }
        echo CJSON::encode('succeed');
    }

    public function getUserKeyWords($keywords)
    {
        return get_like('1', 'user_name', $keywords);
    }

    public function actionOpenDialogShr($keywords = '')
    {
        $model = DistributorCen::model();
        $criteria = new CDbCriteria;
        $criteria->condition = $this->getUserKeyWords($keywords);
        $data = array();
        parent::_list($model, $criteria, 'select', $data);//渲染select
    }
    //配送订单end
    /// 状态改变按钮
    public function actionChangeState($id,$Now_state,$keywords=''){
        $modelname=$this->model;
        $tmp=$modelname::model()->find('id='.$id);
        $a=array(
            '签收'=>11,
            '外部审核通过'=>13,
            '消毒中心签收'=>14,
            '内部审核通过'=>4,
            '提交'=>2,
            '送往审核'=>3,
        );
        $tmp->state= $a[$Now_state] ?$a[$Now_state] : $Now_state;
        if($Now_state=='签收'){
            $tmp->complete_time=Date('Y-m-d');
        }
        $tmp->save();

        echo '<script>window.history.back();</script>';
    }

    public function chge_state_btn($v,$titleName,$action_chosed=''){
        $action=strtolower(Yii::app()->controller->getAction()->id);
        $judgeAction=strtolower($action_chosed);
        $html='<a class="btn btn-blue" href="';
        $url=$this->createUrl('ChangeState',array('id' => $v->id,'Now_state'=>$titleName));
        $html.=$url.'">'.$titleName.'</a>';
        if($action==$judgeAction){
            return $html;
        }
    }
    public function edit_btn($v){
        $action=strtolower(Yii::app()->controller->getAction()->id);
        $html='<a class="btn" href="';
        $url=$this->createUrl('update',array('id' => $v->id));
        $html.=$url.'"'.'title="编辑"><i class="fa fa-edit"></i></a>';

        if('index_appoint'==$action){
            return $html;
        }

    }
    /// 状态改变end
    /// 订单签收
    public function actionIndex_sign($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);


        $model->deleteAll('state'.' in (' . 0 . ')');


        $data = $this->getAppointCountList();
        $data['examineType']='None';
        parent::_list($model, $criteria, 'index_sign', $data);
    }
    public function actionIndex_sign2($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $criteria->addCondition("state>=10");
        $criteria->addCondition("state<=11");
        $criteria -> addCondition($this->rest_limit());
        $model->deleteAll('state'.' in (' . 0 . ')');

        $data = $this->getAppointCountList();
        $data['examineType']='None';
        $data['usersUnit']=$this->getUserUnitName('rest');
        parent::_list($model, $criteria, 'index_sign2', $data);
    }
    /// 订单签收end
    /// 订单审核
    public function actionIndex_examine($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $criteria->addCondition("state=3");
        $criteria -> addCondition($this->rest_limit());
        $model->deleteAll('state'.' in (' . 0 . ')');


        $data = $this->getAppointCountList();
        $data['examineType']='None';
        $data['usersUnit']=$this->getUserUnitName('rest');
        parent::_list($model, $criteria, 'index_examine', $data);
    }
    public function actionIndex_examine2($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $criteria->addCondition("state=4");
        $criteria -> addCondition($this->disinfection_center_limit());
        $model->deleteAll('state'.' in (' . 0 . ')');


        $data = $this->getAppointCountList();
        $data['examineType']='None';
        $data['usersUnit']=$this->getUserUnitName('disinfection_center');
        parent::_list($model, $criteria, 'index_examine2', $data);
    }
    /// 订单审核end

    ///配送订单
    public function actionIndex_get_delivered($keywords='')
    {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $model->deleteAll('state'.' in (' . 0 . ')');
        $data = $this->getAppointCountList();
        parent::_list($model, $criteria, 'index_get_delivered', $data);
    }
    public function actionIndex_get_delivered2($keywords='')
    {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $model->deleteAll('state'.' in (' . 0 . ')');
        $data = $this->getAppointCountList();
        parent::_list($model, $criteria, 'index_get_delivered2', $data);
    }
    ///配送订单end
    ///申请订单
    public function actionIndex_appointed($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'restaurant_id,restaurant_name,disinfection_name,complete_time,disinfection_id,date',$keywords);
        $start_date=DecodeAsk('start_date');
        $criteria -> condition= get_like( $criteria -> condition,'date',$start_date);
        $model->deleteAll('state'.' in (' . 0 . ')');
        $data = $this->getAppointCountList();
        parent::_list($model, $criteria, 'index_appointed', $data);
    }
    ///申请订单end
    public function actionGetDetailUnit($name){
        $tem = TableWare::model()->find("name='".$name."'");
        echo CJSON::encode($tem->unit);
    }
   ///角色所属单位控制
    public function rest_limit(): string
    {
        $unitId=$this->getUserUnit();
        return "restaurant_id='".$unitId."'";
    }
    public function disinfection_center_limit(): string
    {
        $unitId=$this->getUserUnit();
        return "disinfection_id='".$unitId."'";
    }
    public function getUserUnitName($unitType){
        $unitId=$this->getUserUnit();
        $name='未知';
        if($unitType=='rest'){
            $temp=Restaurant::model()->find("r_code='".$unitId."'");
            if($temp){
                $name=$temp->r_name;
            }
        }
        elseif ($unitType=='disinfection_center'){
            $temp=DisinfectionCenter::model()->find("code='".$unitId."'");
            if($temp){
                $name=$temp->name;
            }
        }
        return $name;
    }
    ///角色所属单位控制end
}