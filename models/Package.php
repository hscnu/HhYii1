<?php

class Package extends BaseModel {

    public function tableName() {
        return '{{package_msg}}';
    }

    /**health_list
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('au_code', 'required', 'message' => '{attribute} 不能为空'),

            array('p_name', 'required', 'message' => '{attribute} 不能为空'),
            array('c_name', 'required', 'message' => '{attribute} 不能为空'),
            array('c_number', 'required', 'message' => '{attribute} 不能为空'),
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
            'p_id'=>'快递编号',
            'p_name'=>'包裹名称',
            'c_name'=>'联系人姓名',
            'c_number'=>'联系电话',
            'p_picture'=>'包裹图片',
            'p_type'=>'包裹类别',
            'p_size'=>'包裹大小',

            'dl_switch'=>'代领开关',
            'dl_id'=>'代领人ID',
            'dl_address'=>'代领地址',
            'remarks'=>'备注',
            'dl_contact'=>'代领联系方式',
            'au_code'=>'提货码',
            'picker_id'=>'取件人ID',

            'is_putout'=>'是否上架',
            'pick_state'=>'取件状态',  //有没有取件，实际有本人取和代领
            'help_state'=>'代领状态',  //有没有代领取件，分待代领和已经代领取件
            'confirm_receipt_state'=>'确认收货状态', //有没有确认收货，分本人取件收货和代领确认收货

            //未取件，允许代领 等于待代领
            //已取件，允许代领 存在自己取件和代领取件，help_state:1 表示 代领取件

            'register_time'=>'快递录入时间',
            'pickup_time'=>'取件时间',
            'help_time'=>'代领签收时间',
            'put_time'=>'上架时间',
            'tui_time'=>'退货时间',
            'confirm_receipt_time'=>'本人确认收货时间',
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
        $this->p_picture=addUploadPath($this->p_picture);

        parent::afterFind();
        return true;
    }


    protected function beforeSave() {
        $this->p_picture=delUploadPath($this->p_picture);
        if($this->isNewRecord){
            $phone=$this->c_number;
            $tmp=user::model()->find('PHONE = '.$phone);
            if($tmp){
                //已注册，填入与用户相关字段
                $this->c_id=$tmp->userId;
                $this->show_switch=$tmp->always_show;
                $this->dl_contact=$phone;
                $this->dl_address=$tmp->send_address;
                $this->sex=$tmp->sex;
                //$this->p_size='中';
                //$this->c_name=$this->trueName||$this->userName;
            }
            $this->register_time=Date("Y-m-d h:i:s");
          //还要自动填充 常用代领开关 常用联系方式 常用联系地址
        }

        if($this->dl_switch==0){
            $this->dl_id=0;
            $this->dl_name='';
        }


        parent::beforeSave();
        return true;
    }
}
