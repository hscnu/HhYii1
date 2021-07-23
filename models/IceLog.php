<?php

class IceLog extends BaseModel
{
    public $club_list_pic = '';

    public function tableName()
    {
        return '{{ice_log}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {

        return array(
//            array('condition', 'required', 'message' => '{attribute} 不能为空'),
//            array('order_tel', 'required', 'message' => '{attribute} 不能为空'),
//            array('ice_amount', 'required', 'message' => '{attribute} 不能为空'),
//            array('order_destination', 'required', 'message' => '{attribute} 不能为空'),
//            array('order_time', 'required', 'message' => '{attribute} 不能为空'),

            array($this->safeField(), 'safe',),
        );
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
            'condition' => '订单状态',
            'revise_time' => '修改时间',
            'modifier' => '修改人',
            'remark' => '备注',
            'order_id' => '订单编号'
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