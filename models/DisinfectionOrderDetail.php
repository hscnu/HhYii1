<?php

class DisinfectionOrderDetail extends BaseModel {


    public $club_list_pic = '';

    public function tableName() {
        return '{{disinfection_order_detail}}';
    }

    /**health_list
     * 模型验证规则
     */
    public function rules() {
        return array(
//            array('order_id', 'required', 'message' => '{attribute} 不能为空'),

            array($this->safeField(), 'safe',),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
    }

    /**
     * 属性标签若没有自定义则调用父类方法自动自动显示全部字段
     */
    public function attributeLabels(){
        return array(
            'id' => 'ID',
            'order_id' => '订单ID',
            'tableware_type' => '餐具类型',
            'tableware_name' =>'餐具名称',
            'unit' => '消毒单位',
            'cost' => '消毒单价',
            'number' => '数量',
            'total_cost' => '总价'


        );
    }

    /**
     * 自定义属性标签
     * */
    public function DiyAttributeLabels(){
        return array(
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCode()
    {
        return $this->findAll('1=1');
    }
    public function getAllType(){
        $criteria = new CDbCriteria();
        $criteria->select = 'type';
        $criteria->group = 'type';
        $result=$this->model()->findAll($criteria);
        return $result;
    }

    public function getByType($f_type,$f_order='') {
        $criteria = new CDbCriteria;
        $criteria->addCondition("f_type = :f_type");
        $criteria->params[':f_type']=$f_type;


        if(!empty($f_order)) $criteria->order='f_name ASC';

        $result=$this->model()->findAll($criteria);
        return $result;
    }


}