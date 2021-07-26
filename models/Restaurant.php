<?php

class Restaurant extends BaseModel {


    public $club_list_pic = '';

    public function tableName() {
        return '{{restaurant}}';
    }

    /**health_list
     * 模型验证规则
     */
    public function rules() {
        return array(
            // array('id', 'required', 'message' => '{attribute} 不能为空'),

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
            'r_name' => '酒楼名称',
            'r_address' => '酒店地址',
            'r_phone' => '酒店电话',

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
    public function getNameFromId($id=''){
        //$criteria = new CDbCriteria();
        $tmp=$this->model()->find("id='".$id."'");
        $result = $tmp['r_name'];
        return $result;
    }



}
