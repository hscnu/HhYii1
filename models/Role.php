<?php

class Role extends BaseModel {

    public function tableName() {
        return '{{role}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {

        return array(
            array('f_rcode', 'required', 'message' => '{attribute} 不能为空'),
            array('f_rname', 'required', 'message' => '{attribute} 不能为空'),

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
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'f_tcode'=>'树结构父',
            'f_rcode'=>'角色编码',
            'f_rname'=>'角色名称',
            'f_type'=>'级别',
            'f_opter'=>'功能授权',
            'f_sysdefault'=>'系统内部使用',
            'f_default'=>'申报人使用，1 是，0 不是',
            'f_level'=>'使用级别',
            'f_optname'=>'操作名称',

        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    public function getCode() {
        return $this->findAll('1=1');
    }

    public function getAllType(){
        $criteria = new CDbCriteria();
        $criteria->select = 'f_rcode,f_rname';
        $criteria->group = 'f_rcode,f_rname';
        $result=$this->model()->findAll($criteria);
        return $result;
    }


}
