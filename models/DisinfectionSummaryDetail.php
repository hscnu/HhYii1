<?php

class DisinfectionSummaryDetail extends BaseModel {

    public $check_save=1;
    public $club_list_pic = '';

    public function tableName() {
        return '{{disinfection_summary_detail}}';
    }

    /**health_list
     * 模型验证规则
     */
    public function rules() {

        if($this->check_save)
            $a=array(
                // array('id', 'required', 'message' => '{attribute} 不能为空'),
                //array('restaurant_id', 'required', 'message' => '{attribute} 不能为空'),

                //array('complete_time', 'required', 'message' => '{attribute} 不能为空'),

            );

        $a[]= array($this->safeField(), 'safe');
        return $a;

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
            'tableware_name' => '餐具名称',
            'date' => '日期',
            'number' => '数量',
            'cost' => '单价',
            'total_price' => '总价',
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



}
