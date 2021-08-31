<?php

class ReportDetail extends BaseModel
{
    public $club_list_pic = '';
    public $check_save=1; //设置跳过检验标志符
    public function tableName()
    {
        return '{{reportdetail}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        if($this->check_save)
            $a=array(
                // array('id', 'required', 'message' => '{attribute} 不能为空'),

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
            'order_id'=>'表单号',
            'species' => '名称',
            'number' => '数量',
            'code'=>'商品号',
            'unit'=>'单位',
            'remark'=>'备注',
            'img'=>'图片'
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