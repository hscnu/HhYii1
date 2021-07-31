<?php

class OnShelfProduct extends BaseModel
{
    public $club_list_pic = '';

    public function tableName()
    {
        return '{{onshelf_product}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {

        return array(
            array('apply_order', 'required', 'message' => '{attribute} 不能为空'),
            array('product_name', 'required', 'message' => '{attribute} 不能为空'),
            array('put_time', 'required', 'message' => '{attribute} 不能为空'),
            array('sale_time', 'required', 'message' => '{attribute} 不能为空'),
            array('number', 'required', 'message' => '{attribute} 不能为空'),
            array('number_unit', 'required', 'message' => '{attribute} 不能为空'),
            array('price', 'required', 'message' => '{attribute} 不能为空'),
            array('supplier', 'required', 'message' => '{attribute} 不能为空'),
            array('trade_means', 'required', 'message' => '{attribute} 不能为空'),
            array('contact_details', 'required', 'message' => '{attribute} 不能为空'),

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
            'apply_order' => '申请上架单号',
            'product_name' => '商品名称',
            'put_time' => '上架时间',
            'sale_time' => '销售时间',
            'price' => '价格',
            'number' => '数量',
            'number_unit'=>'数量单位',
            'supplier' => '供应商',
            'trade_means' => '交易方式',
            'contact_details' => '联系方式',
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