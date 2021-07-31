<?php

class ProductReport extends BaseModel
{
    public $club_list_pic = '';

    public function tableName()
    {
        return '{{ProductReport}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {

        return array(
            array('product_id', 'required', 'message' => '{attribute} 不能为空'),
            array('product_name', 'required', 'message' => '{attribute} 不能为空'),
            array('product_yield', 'required', 'message' => '{attribute} 不能为空'),
            
            array('pR_time', 'required', 'message' => '{attribute} 不能为空'),

            array('farmer_id', 'required', 'message' => '{attribute} 不能为空'),
            array('farmer_name', 'required', 'message' => '{attribute} 不能为空'),
            array('farmer_telephone', 'required', 'message' => '{attribute} 不能为空'),

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
            'product_id' => '产品ID',
            'product_name' => '产品名称',
            'product_yield' => '产量',
            'product_origin' => '产地',
            'pR_time' => '上报时间',
            'farmer_id' => '农户ID',
            'farmer_name' => '农户姓名',
            'farmer_telephone' => '农户联系电话',
            'farmer_address' => '农户地址',

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