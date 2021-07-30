<?php

class DistributorCen extends BaseModel
{
    public $club_list_pic = '';

    public function tableName()
    {
        return '{{distributorcen}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {

        return array(
//            array('restaurant', 'required', 'message' => '{attribute} 不能为空'),
//            array('res_owner_phone', 'required', 'message' => '{attribute} 不能为空'),
//            array('food_class', 'required', 'message' => '{attribute} 不能为空'),

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
//            'user_name' => '餐厅名',
//            'food_class' => '菜品类属',
//            'food_name' => '菜品名',
            'user_name' => '用户姓名',
            'user_tel' => '联系电话',
            'order_id' => '订单号',
            'user_id' => '用户编号',
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