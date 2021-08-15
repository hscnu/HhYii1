<?php


class IceDetail extends BaseModel
{
    public $club_list_pic = '';
    public $check_save=1;

    public function tableName()
    {
        return '{{ice_detail}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {
        if($this->check_save)
            $a=array(

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
            'ice_number'=>'冰的编号',
            'ice_type'=>'冰的名称',
            'order_id' => '订单编号',
            'ice_id'=>'冰编号',
            'ice_name'=>'名称',
            'specification'=>'规格',
            'amount'=>'数量',
            'unit_price'=>'单价',
            'remark'=>'备注',
            'total_price'=>'总额'
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