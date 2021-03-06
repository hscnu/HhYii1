<?php

class DisinfectionOrder extends BaseModel {

    public $check_save=1;
    public $club_list_pic = '';

    public function tableName() {
        return '{{disinfection_order}}';
    }

    /**health_list
     * 模型验证规则
     */
    public function rules() {

        if($this->check_save)
            $a=array(
                // array('id', 'required', 'message' => '{attribute} 不能为空'),
                //array('restaurant_id', 'required', 'message' => '{attribute} 不能为空'),
                array('disinfection_name', 'required', 'message' => '{attribute} 不能为空'),
                array('date', 'required', 'message' => '{attribute} 不能为空'),
                array('title', 'required', 'message' => '{attribute} 不能为空'),
                array('code', 'required', 'message' => '{attribute} 不能为空'),
                //array('complete_time', 'required', 'message' => '{attribute} 不能为空'),

            );

        $a[]= array($this->safeField(), 'safe');
        return $a;

    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
    }

    /**
     * 属性标签若没有自定义则调用父类方法自动自动显示全部字段
     */
    public function attributeLabels(){
        return array(
            'id' => 'ID',
            'restaurant_id' => '酒楼ID',
            'disinfection_id' => '消毒中心ID',
            'date' => '预约日期',
            'code' => '订单编号',
            'restaurant_name' => '酒楼名称',
            'state' => '订单状态',
            'disinfection_name' => '消毒中心名称',
            'complete_time' => '完成时间',
            'notes' => '备注',
            'title'=>'订单标题',
            'appointer_id'=>'申请人id',
            'appoint_time'=>'申请时间',
            'detail_number'=>'餐具种类数',
        );
    }

    /**
     * 自定义属性标签
     * */
    public function DiyAttributeLabels(){
        return array(
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCode()
    {
        return $this->findAll('1=1');
    }
    public function getUserUnit(){
        $userId=get_session('userId');
        $tmp=User::model()->find('userId='.$userId);
        if($tmp){
            return $tmp->unitId;
        }
    }
    public function getAppointCountList(){
        $unitCode=$this->getUserUnit();
        $disinfectionTmp=DisinfectionCenter::model()->find("code='".$unitCode."'");
        $restaurantTmp=Restaurant::model()->find("r_code='".$unitCode."'");
        $FExamine=0;
        $todayCount=0;
        $waitCount=0;
        $delivering1=0;
        $delivered=0;
        $waitSignCount=0;
        $signedCount=0;
        $delliverAll=0;
        $finishCount=0;
        $waitCenterSign=0;
        $deliver_wait=0;
        $deliver_wait2=0;
        $waitRestSign=0;
        if($disinfectionTmp){//消毒中心
            $FExamine = count($this->findAll("state=4 and disinfection_id='".$disinfectionTmp->id."'"));
            $waitCenterSign = count($this->findAll("state=15 and disinfection_id='".$disinfectionTmp->id."'"));
            $deliver_wait2 = count($this->findAll("state=14 and disinfection_id='".$disinfectionTmp->id."'"));
            $delivering1 = count($this->findAll("state=17 and disinfection_id='".$disinfectionTmp->id."'"));//手机配送中
            $delivered=count($this->findAll("state=10 and disinfection_id='".$disinfectionTmp->id."'"));//手机配送完成
            $waitSignCount=count($this->findAll("state=15 and disinfection_id='".$disinfectionTmp->id."'"));//手机等待签收
            $signedCount=count($this->findAll("state=14 and disinfection_id='".$disinfectionTmp->id."'"));//手机签收完成
            $delliverAll=$delivering1+$delivered;

        }
        if($restaurantTmp){//酒楼

            $todayCount = count($this->findAll("state=1 and restaurant_id='".$restaurantTmp->id."'"));
            $waitCount = count($this->findAll("state=2 and restaurant_id='".$restaurantTmp->id."'"));
            $finishCount = count($this->findAll("state=3 and restaurant_id='".$restaurantTmp->id."'"));
            $deliver_wait = count($this->findAll("state=13 and restaurant_id='".$restaurantTmp->id."'"));
            $delivering1 = count($this->findAll("state=16 and restaurant_id='".$restaurantTmp->id."'"));//手机配送中
            $delivered=count($this->findAll("state=15 and restaurant_id='".$restaurantTmp->id."'"));//手机配送完成
            $waitSignCount=count($this->findAll("state=10 and restaurant_id='".$restaurantTmp->id."'"));//手机等待签收
            $waitRestSign=$waitSignCount;
            $signedCount=count($this->findAll("state=11 and restaurant_id='".$restaurantTmp->id."'"));//手机签收完成
            $delliverAll=$delivering1+$delivered;
        }



        $IExamine = count($this->findAll('state=12'));


        return array(
            'todayCount'=>$todayCount,
            'waitCount'=>$waitCount,
            'finishCount'=>$finishCount,
            'waitCenterSignCount'=>$waitCenterSign,
            //'signedCount'=>$signedCount,
            'IExamineCount'=>$IExamine,
            'FExamineCount'=>$FExamine,
            'deliverwaitCount' => $deliver_wait,
            'waitRestSignCount'=>$waitRestSign,
            'deliverwait2Count'=>$deliver_wait2,
            'delivering1'=>$delivering1,
            'delivered'=>$delivered,
            'delliverAll'=>$delliverAll,
            'waitSignCount'=>$waitSignCount,
            'signedCount'=>$signedCount,
        );
    }
    public function getCHName($state){
        $a=array(
            1=>'申请中',
            2=>'已提交',
            3=>'待审核',
            4=>'待消毒中心审核',
            5=>'待接收',
            6=>'已接受',
            7=>'待消毒',
            8=>'消毒完成',
            9=>'待归还',
            10=>'待签收',
            11=>'已签收',//订单完成
            13=>'待配送',//酒楼送往中心
            16=>'等待取货中',//酒楼送往中心
            14=>'待消毒中心配送',//中心送往酒楼
            17=>'等待送还中',//中心送往酒楼
            15=>'待消毒中心签收',
        );
        return $a[$state] ?$a[$state]: '未知';
    }

}
