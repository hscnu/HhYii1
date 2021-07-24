<?php

class ReportProduct extends BaseModel
{
    public $club_list_pic = '';

    public function tableName()
    {
        return '{{report_product}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {

        return array(
            array('report_order', 'required', 'message' => '{attribute} 不能为空'),
            array('production', 'required', 'message' => '{attribute} 不能为空'),
            array('product_name', 'required', 'message' => '{attribute} 不能为空'),
            array('origin_place', 'required', 'message' => '{attribute} 不能为空'),
            array('production_unit', 'required', 'message' => '{attribute} 不能为空'),

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
            'report_order' => '上报单号',
            'product_name' => '产品名称',
            'production' => '产量',
            'origin_place' => '产地名',
            'production_unit'=>'产量单位'
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