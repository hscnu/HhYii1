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

            'restaurant_name' => '酒楼名称',
            'state' => '订单状态',
            'disinfection_name' => '消毒中心名称',
            'complete_time' => '完成时间',
            'notes' => '备注',
            'title'=>'订单标题',

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

    public function getAppointCountList(){

        $todayCount = count($this->findAll('state=1'));
        $waitCount = count($this->findAll('state=2'));
        $finishCount = count($this->findAll('state=3'));
        return array(
            'todayCount'=>$todayCount,
            $waitCount,
            $finishCount,
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
            11=>'已签收',
            13=>'待配送',
            //14=>'已配送',
        );
        return $a[$state] ? $a[$state] :'未知';
    }

}
