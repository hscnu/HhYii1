<?php

class User extends BaseModel {
    public $TPWD2;
    public function tableName() {
        return '{{user}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {

        return array(
          //  array('TCOD', 'required', 'message' => '{attribute} 不能为空'),
            //array('TUNAME', 'required', 'message' => '{attribute} 不能为空'),
//            array('TCNAME', 'required', 'message' => '{attribute} 不能为空'),
//            array('USER_TYPE', 'required', 'message' => '{attribute} 不能为空'),
//            array('TIDN', 'required', 'message' => '{attribute} 不能为空'),
//            array('TBIRTH', 'required', 'message' => '{attribute} 不能为空'),
//            array('TPWD', 'required', 'message' => '{attribute} 不能为空'),
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
            'userId' => 'ID',
            'TCOD' => '管理员编号',
            'TUNAME' => '用户编号',
            'TPWD'=>'密码',
            'TCNAME'=>'用户姓名',
            'USER_TYPE'=>'用户类型',
            'TIDN'=>'身份证号码',
            'F_ROLENAME'=>'角色',
            'TBIRTH'=>'生日',
            'user_id'=>'用户账号',
            'au_code'=>'授权码用户标志',
            'PHONE'=>'电话',
            'contact_info'=>'常用联系方式',
            'send_address'=>'常用送货地址',
            'always_dl'=>'常用代领开关',
            'intergra'=>'积分',
            'distance'=>'距离',
            'times'=>'服务次数',
            'credibility'=>'信誉度',
            'address'=>'宿舍地址',
            'wechat_num'=>'微信账号',
            'sex'=>'用户性别',
            'userName'=>'用户名',

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

//    protected function afterFind() {
//        parent::afterFind();
//        return true;
//    }
//
//
    protected function beforeSave() {
        if($this->isNewRecord){
            $this->initUser();
        }
        $this->initPackage();


        parent::beforeSave();
        return true;
    }

    protected function initUser(){
        $this->F_ROLENAME='用户';
        $this->sex=$this->userSex==1?'男':'女';
        $this->credibility='60';
        $this->intergra='0';
        if(!empty($this->wx_openid)){
            $this->userName=$this->nickName;
            $this->TCNAME=$this->nickName;
        }


    }

    protected function initPackage(){
        $tmp=Package::model()->findAll("c_number='".$this->PHONE."'");
        put_msg(CJSON::encode($tmp));
        if($tmp){
            foreach ($tmp as $v){
                $v->c_id=$this->userId;
                $v->save();
            }
        }
    }


    function get_userinfo($w1){
        $tmp =$this->find($w1);
        $check = user::model()->find("userId!=".$tmp->userId." and PHONE ='".$tmp->PHONE."'");//查找除了当前账号，电话又相同的
        $userId=$tmp->userId;
        if(!empty($check)){
            $userId=$check->userId;  //如果有相同手机的账号，返回前一个用户记录的userId，防止包裹
        }
        $data=array('userId'=>$userId,'wx_openid'=>$tmp->wx_openid,'loginName'=>$tmp->loginName,'userSex'=>$tmp->userSex);
        $data['userName']='';//昵称',
        $data['trueName']='';//'trueName'=> '真名',
        $data['UserIntegral']='0';//余额
        $data['UserMBean']='0';//深海豆
        $data['isHavingPhone']=empty($tmp->PHONE)?'0':'1';
        $data['admin']=$tmp->F_ROLENAME=='系统管理员'?'1':'';//管理员权限

        $userItem=array();
//        if($tmp)
//            $userItem=Orders::model()->get_center_info($tmp->userId);
//        if($tmp){
//            $data=$tmp->attributes;
//            $data['UserIntegral']=$tmp->userMoney*100;//余额,小程序除100
//            $data['UserMBean']=$tmp->seabean;//深海豆
//
//        }
        return array_merge($data,$userItem);
    }

}
