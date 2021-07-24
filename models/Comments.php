<?php

class Comments extends BaseModel {
    public $selectval=array(2);
    public function tableName() {
        return '{{comment}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('food_name', 'required', 'message' => '{attribute} 不能为空'),
            array('res_name', 'required', 'message' => '{attribute} 不能为空'),
            array('user_name', 'required', 'message' => '{attribute} 不能为空'),
            array('food_name,res_name,user_name,comment,time_stamp,comment_star','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
    }
    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'food_name' => '菜名',
            'res_name' => '酒店',
            'user_name' => '用户名',
            'comment' => '评论内容',
            'time_stamp' => '评论时间',
            'comment_star'=>'评价分数',
        );
    }




    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }




    protected function beforeSave() {
        parent::beforeSave();
      
        return true;
    }

}
