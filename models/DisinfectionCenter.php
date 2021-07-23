<?php

class DisinfectionCenter extends BaseModel {


    public $club_list_pic = '';

    public function tableName() {
        return '{{disinfection_center}}';
    }

    /**health_list
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('name', 'required', 'message' => '{attribute} 不能为空'),
            array('address', 'required', 'message' => '{attribute} 不能为空'),
            array('phone', 'required', 'message' => '{attribute} 不能为空'),

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
            'name' => '消毒中心名称',
            'address' => '消毒中心地址',
            'phone' => '消毒中心电话',

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

    public function getAllName(){
        $criteria = new CDbCriteria();
        $criteria->select = 'name';
        $criteria->group = 'name';
        $result=$this->model()->findAll($criteria);
        return $result;
    }

    public function getIdFromName($name=''){
        //$criteria = new CDbCriteria();
        $tmp=$this->model()->find("name='".$name."'");
        $result = $tmp['id'];
        return $result;
    }



}
