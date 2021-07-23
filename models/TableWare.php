<?php

class TableWare extends BaseModel {


    public $club_list_pic = '';

    public function tableName() {
        return '{{tableware}}';
    }

    /**health_list
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('type', 'required', 'message' => '{attribute} 不能为空'),
            array('code', 'required', 'message' => '{attribute} 不能为空'),
            array('name', 'required', 'message' => '{attribute} 不能为空'),
            array('unit', 'required', 'message' => '{attribute} 不能为空'),
            array('cost', 'required', 'message' => '{attribute} 不能为空'),

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
            'type' => '餐具类型',
            'code' => '餐具编号',
            'name' => '餐具名称',
            'unit' => '消毒单位',
            'cost' => '消毒单价',


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


}