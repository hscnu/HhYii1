<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="zh-cn"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="zh-cn"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="zh-cn"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="zh-cn"><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>薄荷博客——轻松一刻</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge，chrome=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <?php $cs = Yii::app()->clientScript;?>
    <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/login.css');?>
    <?php $cs->registerCoreScript('jquery');?>
    <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/jquery.nicescroll.js');?>
    <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/js/jquery.fallr/jquery.fallr.css');?>
    <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/jquery.fallr/jquery.fallr.js');?>
    <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/public.js');?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl.'/static/admin/img/bh.png';?>"/>

</head>
<body>
<div class="wrapper flex-center">
    <input type="hidden" name="user_login" value="<?php echo $user_login;?>">

    <div class="main ">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_login()); ?>
        <div class="item"><span class="login-title">用户注册</span></div>

        <?php
        if($user_login=='1'){
            ?>
            <input type="hidden" name="User_TPWD" value="<?php echo $TPWD;?>">
            <input type="hidden" name="TUNAME" id="TUNAME" value="<?php echo $TUNAME;?>">
            <div class="item"> 用户名: <?php echo $TCNAME;?>
            </div><!--item end-->
        <?php } else{
            ?>
            <div class="item">
                <?php echo $form->textField($model, 'TUNAME', array('maxlength' => 50, 'class' => 'user-input', 'placeholder'=>'请输入用户账号')); ?>
                <?php echo $form->error($model, 'TUNAME', $htmlOptions = array()); ?>
            </div><!--item end-->
            <div class="item">
                <?php echo $form->textField($model, 'TCNAME', array('class' => 'user-input', 'placeholder'=>'请输入昵称')); ?>
                <?php echo $form->error($model, 'TCNAME', $htmlOptions = array()); ?>
            </div><!--item end-->
            <div class="item">
                <?php echo $form->passwordField($model, 'TPWD', array('class' => 'pwd-input', 'placeholder'=>'请输入密码')); ?>
                <?php echo $form->error($model, 'TPWD', $htmlOptions = array()); ?>
            </div><!--item end-->
            <div class="item">
                <?php echo $form->passwordField($model, 'TPWD2', array('class' => 'pwd-input', 'placeholder'=>'请再次确认密码')); ?>
                <?php echo $form->error($model, 'TPWD2', $htmlOptions = array()); ?>
            </div><!--item end-->
        <?php }
        ?>
<!--        <div class="item">-->
<!--            --><?php //echo '用户身份：'?>
<!--            --><?php //echo Select2::activeDropDownList($model, 'F_ROLENAME', Chtml::listData(Role::model()->findAll(), 'f_rname', 'f_rname'), array('prompt'=>'请选择','style'=>'width:160px;', 'placeholder'=>'用户角色',"options" => array('系统管理员'=> array('selected' => true)))); ?>
<!--            --><?php //echo $form->error($model, 'F_ROLENAME', $htmlOptions = array()); ?>
<!--        </div>-->
        <!--item end-->

        <div class="item">
            <button class="button" onclick="register();">注册</button><!--item end-->
        </div>
        <div class="register flex-center">
            <a href="<?php echo $this->createUrl('index/login')?>" onclick="Goback();" >返回登录</a>
<!--            |-->
<!--            <a href="--><?php //echo $this->createUrl('index/index')?><!--" >返回首页</a>-->
        </div>

        <?php $this->endWidget(); ?>

    </div><!--main end-->
</div><!--wrapper end-->
</body>
</html>

<script>
   function  register() {
       var post_data = $("#login_form").serialize();
       var s1=$("#User_TUNAME").val();
       var scname=$("#User_TCNAME").val();
       var PWD1=$("#User_TPWD").val();
       var PWD2=$("#User_TPWD2").val();

       var s2='<?php echo $this->createUrl("index/checkRegister");?>';

       if(PWD1!==PWD2){
           alert('两次密码输入不一致，请重新输入!');
           clearPWD();
           return;
       }


       var regex = new RegExp('(?=.*[0-9])(?=.*[a-zA-Z]).{8,16}');
       if (!regex.test(PWD1)) {
           alert("密码中必须包含字母、数字，且长度大于8，小于16");
           clearPWD();
           return;
           }


       $.ajax({
           type: 'get',
           url: s2,
           data: {
               USERNAME: s1,PASSWORD:PWD1,TCNAME:scname,
               user_login:$("#user_login").val()
           },
           dataType:'json',
           success: function(data) {
               s1=data.f_kcszid;
               if (s1===1){
                   alert('注册成功');
                  window.history.back(-1);
               }else if(s1===0){
                   alert("该用户名已经注册");
               }
           },
           error: function(XMLHttpRequest, textStatus, errorThrown) {
               console.log(XMLHttpRequest);
           }
       });
   }

    function clearPWD(){
        $("#User_TPWD").val('');
        $("#User_TPWD2").val('');
    }



   window.alert=function(str)
   {
       var iframe = document.createElement("IFRAME");
       iframe.style.display="none";
       iframe.setAttribute("src", 'data:text/plain');
       document.documentElement.appendChild(iframe);
       window.frames[0].window.alert(str);
       iframe.parentNode.removeChild(iframe);
   }


</script>

