<?php

class IndexController extends BaseController {

    public $layout = false;
    public function actionIndex() {
        $s1='index';
        if(!isset($_SESSION)){ session_start();}
        $s2=$_SESSION['admin_id'];
        if (empty($s2)) {
            $this->login_form();
        }
        else {
            $this->render('index');
        }
    }

    public function actionLogin(){
        $this->login_form();
    }

    public function actionLogout(){
        $this->login_form();
    }

    function login_form($TUNAME="",$TPWD="",$tname=""){
        Yii::app()->session['admin_id']=null;
        $_SESSION["admin"]=null;
        $model = new User('create');
        $data = array();
        $data['model'] = $model;
        $data['TUNAME'] = $TUNAME;
        $data['TNAME'] = $tname;
        $data['TPWD'] = $TPWD;
        $data['user_login'] = ($TUNAME) ? "1":"0";
        if ($TUNAME) $s1='login';//useoauth.php
        $s1='login';
        $this->render($s1,$data);
    }



    function check_pass($usercode,$pass,$role,&$data,$user_login='0')
    {
        put_msg(11);
        $model= User::model()->find("TCOD='". $usercode."' or TUNAME='".$usercode."'");
        put_msg(CJSON::encode($model));

        if(!empty($model)){
//            $pass=md5($pass);
            if($pass==$model->TPWD)
//            if($model->F_ROLENAME==$role)
            {
                $data['TCOD']=$model->TCOD;
                $data['TUNAME']=$model->TCNAME;
                $data['f_kcszid']=1;
                Yii::app()->session['TCNAME']=$model->TCNAME;
                Yii::app()->session['TCOD']=$model->TCOD;
                Yii::app()->session['F_ROLENAME']=$model->F_ROLENAME;
                Yii::app()->session['TUNAME']=$model->TUNAME;
                Yii::app()->session['userId']=$model->userId;

                $_SESSION['admin_id']=1;
//                $this->get_powen($role);
            }
        }
    }



    function dele_char($s1){
        $s1=str_replace(trim(' / '),"",$s1);
        $s1=str_replace(trim(' \ '),"",$s1);
        $s1=str_replace("'","",$s1);
        $s1=str_replace('"',"",$s1);
        $s1=str_replace('(',"",$s1);
        $s1=str_replace(')',"",$s1);
        $s1=str_replace(' ',"",$s1);
        $s1=str_replace(',',"",$s1);
        $s1=str_replace('-',"",$s1);
        $s1=str_replace('=',"",$s1);
        $s1=str_replace('<',"",$s1);
        $s1=str_replace('>',"",$s1);
        $s1=str_replace('*',"",$s1);
        $s1=str_replace('.',"",$s1);
        $s1=str_replace('&',"",$s1);
        $s1=str_replace('@',"",$s1);
        $s1=str_replace('$',"",$s1);
        $s1=str_replace('#',"",$s1);
        $s1=str_replace(trim(' / '),"",$s1);
        $s1=str_replace(trim(' \ '),"",$s1);
        $s1=str_replace('&',"",$s1);
        return $s1;
    }

    //测试更新
    public function actionCheckuser($USERNAME='',$PASSWORD='',$ROLE='',$user_login=0) {
        $usercode="0";//
        $mobile='0';//mobile=0表示教师或社工后台，1表示前台教师，2表示前台学生，用于控制样式使用
        $data = array();
        $USERNAME=$this->dele_char($USERNAME);
        $data['TUNAME']="";
        $data['TCOD']=$USERNAME;
        $data['ROLE']=$ROLE;
        $data['f_kcszid']=0;
        Yii::app()->session['admin_id']=null;
        Yii::app()->session['admin']=0;
        $this->check_pass($USERNAME,$PASSWORD,$ROLE,$data,$ROLE,$user_login);
        echo CJSON::encode($data);
    }

    function get_powen($role)
    {
        $tmp=Role::model()->find("f_rname='".$role."'");
        $tid='0';
        if(!empty($tmp)){ $tid=$tmp->f_opter;}
        if(empty($tid)) $tid='0';
        $tmp=Menu::model()->findAll("id in (".$tid.")");
        $power=array();
        $power['index']['logout']='1';
        $power['index']['login']='1';
        $b=trim(' / ');
        foreach($tmp as $v){
            $string = trim($v->f_url);
            $d1 = explode($b, $string);
            $power[$d1[0]][$d1[1]]='1';
        }
        Yii::app()->session['power']=$power;
    }


}
