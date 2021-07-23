<?php

class UserController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionDelete($id) {
        parent::_clear($id,'','userId');
    }

    public function actionTest($name=''){
        $t=TestList::model()->find('apply_name='.$name);
        $data=array();
        $data['ID']=$t->id;
        $data['NAME']=$t->name;
        echo CJSON::encode($data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        if(!empty( $model->check_button))
            $model->check_button =  explode(',',  $model->check_button );
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }


    function saveData($model, $post) {
        $model->attributes = $post;
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','userName,userId,TUNAME,TCNAME',$keywords);

        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }






    public function actionWxLogin() //获取openid，自定义登录态
    {
        $data=array();
        $json=$_REQUEST;
        $appid = Basefun::model()->get_appid();  //appId
        $secret = Basefun::model()->get_secret(); //appSecret
        $code = $json["code"];
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
// 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        $json_obj = json_decode($res, true);
        //生成并返回token
        Yii::$enableIncludePath = false;
        Yii::import('application.extensions.JWT', 1);
        $payload=array(
            'openid'=>$json_obj["openid"],
            'session_key'=>$json_obj["session_key"]);
        $jwt=new Jwt;
        $token=$jwt->getToken($payload);
        $w1="wx_openid='".$json_obj["openid"]."'";
        $data['isSaveSuccess']=$this->addUserInfo($json["encryptedData"],$json["iv"],$json_obj['session_key']);
        //返回token用于用户识别

        $data['user']=User::model()->get_userinfo($w1);
        $userid=$data['user']['userId'];
       // $address=UserAddress::model()->get_user_address($userid);
       // $data['address']=$address;
        $rs=array('userId'=>$userid,'data'=>$data,'code'=>'200','msg'=>'调用登录成功',);
        $rs['token'] =$token;
        echo CJSON::encode($rs);
    }




    public function actionWxLogin2() //获取openid，自定义登录态
    {
        $data=array();
        $json=$_REQUEST;
        $appid = Basefun::model()->get_appid();  //appId
        $secret = Basefun::model()->get_secret(); //appSecret
        $code = $json["code"];
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        $json_obj = json_decode($res, true);
        //生成并返回token
        Yii::$enableIncludePath = false;
        Yii::import('application.extensions.JWT', 1);
        $payload=array(
            'openid'=>$json_obj["openid"],
            'session_key'=>$json_obj["session_key"]);
        $jwt=new Jwt;
        $token=$jwt->getToken($payload);

        $data['isSaveSuccess']=$this->addUserPhone($json["encryptedData"],$json["iv"],$json_obj['session_key']);
        $rs=array('data'=>$data,'code'=>'200','msg'=>'获取电话成功');
        $rs['token'] =$token;
        echo CJSON::encode($rs);
    }


    public function addUserInfo($encryptedData, $iv, $sessionKey){
        $data=$this->decryptData($encryptedData, $iv, $sessionKey);
        $s='login';
        $rs='false';

        if($data){
            //用电话登录的话可以改成用电话查找

            $user=User::model()->find("wx_openid='".$data['openId']."'");
            if(empty($user)){
                $user_info=new User();
                $user_info->isNewRecord=true;
                $user_info->wx_url=$data['avatarUrl'];
                $user_info->nickName=$data['nickName'];
                $user_info->userSex=$data['gender'];
                $user_info->province=$data['province'];
                $user_info->city=$data['city'];
                $user_info->country=$data['country'];
                $user_info->wx_openid=$data['openId'];
                $user_info->createTime=date('Y-m-d H:i:s',$data['watermark']['timestamp']);
                $user_info->userFrom=2;
                $user_info->userStatus=1;
                $s=$user_info->save();
                $rs=array('success'=>$s,'code'=>0,'msg'=>"注册已经成功!");
            }
            else{
                $user->wx_url=$data['avatarUrl'];
                $user->nickName=$data['nickName'];
                $user->userSex=$data['gender'];
                $user->province=$data['province'];
                $user->city=$data['city'];
                $user->country=$data['country'];
                $user->lastTime=date('Y-m-d H:i:s',$data['watermark']['timestamp']);
                $s=$user->save();
                $rs=array('success'=>$s,'code'=>0,'msg'=>"登录已经成功!");
            }
        }
        return $rs;
    }


    public function addUserPhone($encryptedData, $iv, $sessionKey){
        $data=$this->decryptData($encryptedData, $iv, $sessionKey);
        if($data){
            $user=User::model()->find("userId=".DecodeAsk('userId'));
            $user->PHONE=$data['phoneNumber'];
            $s=$user->save();
            $rs=array('isSave'=>$s,'code'=>0,'msg'=>"添加电话成功");
            return $rs;

        }
    }

    //获取用户信息：通过这三个参数将用户信息译码出来
    protected function decryptData($encryptedData, $iv, $sessionKey)
    {
        $appid = Basefun::model()->get_appid();
        if (strlen($sessionKey) != 24 || strlen($iv) != 24) {
            return false;
        }
        $aesKey = base64_decode($sessionKey);
        $aesIV = base64_decode($iv);
        $aesCipher = base64_decode($encryptedData);
        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $data = json_decode($result, true);

        if(empty($data) || $data['watermark']['appid'] != $appid) {
            return false;
        }
        return $data;
    }








    public function actionLogin($userName='0',$password='0') {
        $para=$this->getLoginName();
        $this->checkPass($para['nickname'],$para['password'],$para['openid']);
    }

    public function getLoginName() {
        $para=getParameter();
        $nickname="";
        $password="000";
        if(isset($para['formData']['userName']))
        {$nickname=$para['formData']['userName'];}
        if(isset($para['userName']))
        {$nickname=$para['userName'];}
        if(isset($para['nickName']))
        {$nickname=$para['nickName'];}
        if(isset($para['formData']['password']))
        {$password=$para['formData']['password'];}
        if(isset($para['password']))
        {$password=$para['password'];}
        if(empty($para['openid'])){
            $para['openid']='';
        }
        $para['nickname']=$nickname;
        $para['password']=$password;
        return $para;
    }

    public function checkPass($userName='0',$password='0',$openid="") {
        $w1= "loginName='".$userName."'";
        $staff =User::model()->find($w1);
        $er=1;$userid=0;
        $msg='账号或密码错误';
        if($staff){
            if($staff['loginPwd']==md5($password.$staff['loginSecret'])){
                $userid=$staff['userId'];
//                $this->save_log($staff,$userName,'');
//                Users::model()->updateAll(array('wx_openid'=>''),"wx_openid='".$openid."'");
//                Users::model()->updateAll(array('wx_openid'=>$openid),'userId='.$userid);
                $msg="登录正确";
                $er=0;
            }
        }

        $this->get_adress($userid,$er,$msg);
    }


    public function get_adress($userid,$er,$msg) {
//        $address=UserAddress::model()->get_user_address($userid);
        if($er==0){
            $data=array('userId'=>$userid,'token'=>'1');
            $data['user']=User::model()->get_userinfo('userId='.$userid);
            $wx_userid=$userid;
            $rs=array('data'=>$data,'code'=>'200','msg'=>$msg);

        }
        else{
        $rs=array('code'=>'200','msg'=>$msg);
        }
        echo json_encode($rs);

    }


    public function actionRegister(){
        $request = file_get_contents('php://input');
        $arr =json_decode($request,true);
        $para=$arr['formData'];
        $rs0=array('success'=>'1','code'=>0,'msg'=>"注册已经成功!");
        $rs = User::model()->find("loginName='".$para['account']."'");
        if(empty($rs)){
            $tmp=new User();
            $tmp->isNewRecord = true;
            unset($tmp->userId);  //   $this->f_msg=$pmsg;
            $tmp->loginName=$para['account'];
            $loginSecret = rand(1000,9999);
            $tmp->loginSecret=$loginSecret;
            $tmp->TPWD=$para['password'];
            $tmp->loginPwd=md5($para['password'].$loginSecret);
            $tmp->userName=$para['name'];
            $tmp->PHONE=$tmp->userPhone=$para['account'];
            $tmp->userFrom=2;
            $tmp->userStatus=1;
            $tmp->userName=$para['name'];
            $tmp->trueName=$para['name'];
            $tmp->TCNAME=$para['name'];

//            $tmp->wxname=$para['wxname'];
//            $tmp->wxurl=$para['wxurl'];
            $tmp->save();
        }
        else{
            $rs0=array('success'=>'0','code'=>0,'msg'=>"该账号已经注册!");
        }


        echo json_encode($rs0);
    }






}
