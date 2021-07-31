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
                array('order_destination', 'required', 'message' => '{attribute} 不能为空'),
                array('order_time', 'required', 'message' => '{attribute} 不能为空'),
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
            'order_name' => '联系人',
            'order_tel' => '联系人电话',
            'order_time' => '收货时间',
            'ice_amount' => '冰的数量',
            'order_destination' => '收货地点',
            'order_remark' => '备注',
            'order_state' => '订单状态',
            'deliver_id'=>'送货人ID',
            'deliver_name'=>'送货人姓名',
            'deliver_tel'=>'送货人电话'
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