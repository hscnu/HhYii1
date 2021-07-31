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
            'order_id' => '关联订单ID',
            'strip_ice_amount'=>'条冰数量',
            'crushed_ice_amount'=>'碎冰数量'
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