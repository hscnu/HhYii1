<?php

class TestList extends BaseModel {
    public $club_list_pic = '';

    public function tableName() {
        return '{{test2_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
//            array('club_name', 'required', 'message' => '{attribute} 不能为空'),
            array('apply_name', 'required', 'message' => '{attribute} 不能为空'),

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
            'id' => 'ID',
            'club_code' => '社区编码',
            'club_name' => '名称',
            'apply_name'=>'姓名',
            'club_address'=>'地址',
            'contact_phone'=>'联系电话',
            'drop_down'=>'下拉选择',
            'radio_button'=>'单选框',
            'text_area'=>'文本区域',
            'img'=>'图片上传',
            'check_button'=>'复选框',
            'date'=>'日期',
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

    protected function afterFind() {
        $this->img=addUploadPath($this->img);
        parent::afterFind();
        return true;
    }


    protected function beforeSave() {
        $this->img=delUploadPath($this->img);
        parent::beforeSave();
        return true;
    }

}
