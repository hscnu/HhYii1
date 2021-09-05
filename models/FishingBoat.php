<?php

class FishingBoat extends BaseModel {

    public function tableName() {
        return '{{fishing_boat}}';
    }

    /**health_list
     * 模型验证规则
     */
    public function rules() {
        return array(
            // array('id', 'required', 'message' => '{attribute} 不能为空'),
            // array('registered_captain_name', 'required', 'message' => '{attribute} 不能为空'),
            // array('captain_phone', 'required', 'message' => '{attribute} 不能为空'),
            // array('captain_id_card', 'required', 'message' => '{attribute} 不能为空'),
            // array('boat_type', 'required', 'message' => '{attribute} 不能为空'),
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
            'user_id'=>'用户序号',
            'id'=>'序号',
            'boat_id'=>'渔船编码',
            'boat_name'=>'船名',
            'fishing_license_no'=>'渔业捕捞许可证编号',
            'boat_type'=>'船舶种类',
            'port_of_registry'=>'船籍港',
            'main_job_type'=>'主作业类型',
            'main_operation_mode'=>'主作业方式',
            'boat_length'=>'船长度',
            'boat_shape_width'=>'型宽',
            'boat_shape_depth'=>'型深',
            'gross_tonnage'=>'总吨位',
            'affiliated_company'=>'渔船所属公司',
            'registered_captain_name'=>'登记船长姓名',
            'captain_phone'=>'船长电话号码',
            'registration_certificate'=>'船舶登记证书',
            'fishing_licence'=>'捕捞许可证',
            'boat_pic'=>'渔船图片',
            'state'=>'状态',
            'operation_time'=>'操作时间',
            'residence_time'=>'入驻时间',
            'examine_person'=>'审核人',
            'examine_time'=>'审核时间',
            'examine_explain'=>'审核说明',
        );
    }

    public function getInfoFromMenu($views,$field) {
        $tmp1=Menu::model()->find("f_name='".$views."'");
        return $tmp1->{$field};
    }

    public function picLabels(){
        return 'registration_certificate,fishing_licence,boat_pic';
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
    public function getModelByUserId(){
        return $this->find('user_id='.get_session('userId'));
    }
}
