<?php

class Residence extends BaseModel {

    public function tableName() {
        return '{{residence}}';
    }

    /**health_list
     * 模型验证规则
     */
    public function rules() {
        return array(
      //      array('id', 'required', 'message' => '{attribute} 不能为空'),

            array('contact_person', 'required', 'message' => '{attribute} 不能为空'),
            array('contact_number', 'required', 'message' => '{attribute} 不能为空'),
            array('apply_number', 'required', 'message' => '{attribute} 不能为空'),
            array('email', 'required', 'message' => '{attribute} 不能为空'),
            array('ID card_number', 'required', 'message' => '{attribute} 不能为空'),
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
            'id'=>'序号',
            'residence_type'=>'入驻类型',
            'account_number'=>'单位管理账号',
            'apply_unit_or_apply_person'=>'申请单位/申请人',
            'apply_number'=>'申请人账号',
            'location'=>'单位所在地',
            'contact_person'=>'联系人',
            'contact_number'=>'联系电话',
            'state'=>'状态',
            'establish_time'=>'创办时间',
            'operation_time'=>'操作时间',
            'eamil'=>'电子邮箱',
            'ID card_number'=>'身份证账号',
            'remark'=>'备注',
            'residence_time'=>'入驻时间',
            'job'=>'职业',
            'IDcard_photo'=>'身份证照',
            'business_license'=>'营业执照',
            'unit_name'=>'单位名称',
        );
    }

    public function getInfoFromMenu($views,$field) {
        $tmp1=Menu::model()->find("f_name='".$views."'");
        return $tmp1->{$field};
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

    protected function afterFind() {
     //   $this->p_picture=addUploadPath($this->p_picture);

        parent::afterFind();
        return true;
    }


    protected function beforeSave() {

        parent::beforeSave();
        return true;
    }
}
