<?php

class Ice extends BaseModel
{
    public $check_save=1;

    public function tableName()
    {
        return '{{ice_order}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {
        if($this->check_save)
            $a=array(
                // array('id', 'required', 'message' => '{attribute} 不能为空'),
                array('order_name', 'required', 'message' => '{attribute} 不能为空'),
                array('order_tel', 'required', 'message' => '{attribute} 不能为空'),
                //array('order_destination', 'required', 'message' => '{attribute} 不能为空'),
                array('order_id', 'required', 'message' => '{attribute} 不能为空'),
                array('order_time', 'required', 'message' => '{attribute} 不能为空'),
                array('take_type', 'required', 'message' => '{attribute} 不能为空'),
            );
        $a[]= array($this->safeField(), 'safe');
        return $a;
    }

    /**
     * 模型关联规则
     */
    public function relations()
    {
        return array();
    }

    /**
     * 属性标签
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'order_id'=>'订单编号',
            'order_time' => '收货时间',
            'title'=>'标题',
            'company'=>'单位/公司',
            'order_name' => '联系人',
            'order_tel' => '联系人电话',
            'order_remark' => '备注',
            'take_type'=>'取冰方式',
            'order_destination' => '收货地点',
            'deliver_id'=>'送货人ID',
            'deliver_name'=>'送货人姓名',
            'deliver_tel'=>'送货人电话',
            'order_state' => '订单状态',
            'fishing_boat'=> '渔船名称',
            'longitude' =>'经度',
            'latitude'=>'维度'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function getCode()
    {
        return $this->findAll('1=1');
    }
}