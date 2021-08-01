<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="zh-cn"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="zh-cn"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="zh-cn"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="zh-cn"><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>后台管理系统</title>
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
</head>
<body>
<div class="wrapper">
    <input type="hidden" name="user_login" value="<?php echo $user_login;?>">
    <div class="main">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_login()); ?>
        <div class="item"><h1>后台管理系统</h1></div>
        <?php
        if($user_login=='1'){
            ?>
            <input type="hidden" name="User_TPWD" value="<?php echo $TPWD;?>">
            <input type="hidden" name="TUNAME" id="TUNAME" value="<?php echo $TUNAME;?>">
            <div class="item"> 用户名: <?php echo $TNAME;?>
            </div><!--item end-->
        <?php } else{
            ?>
            <div class="item">
                <?php echo $form->textField($model, 'TUNAME', array('maxlength' => 50, 'class' => 'user-input', 'placeholder'=>'用户名')); ?>
                <?php echo $form->error($model, 'TUNAME', $htmlOptions = array()); ?>
            </div><!--item end-->
            <div class="item">
                <?php echo $form->passwordField($model, 'TPWD', array('class' => 'pwd-input', 'placeholder'=>'密码')); ?>
                <?php echo $form->error($model, 'TPWD', $htmlOptions = array()); ?>
            </div><!--item end-->
        <?php }
        ?>
        <div class="item">
            <?php echo '用户身份：'?>
            <?php echo Select2::activeDropDownList($model, 'F_ROLENAME', Chtml::listData(MobileRole::model()->findAll(), 'f_rname', 'f_rname'), array('prompt'=>'请选择','style'=>'width:160px;', 'placeholder'=>'用户角色',"options" => array('系统管理员'=> array('selected' => true)))); ?>
            <?php echo $form->error($model, 'F_ROLENAME', $htmlOptions = array()); ?>
        </div>

        <div class="item">
            <button class="button "  type="submit"  onclick="login();" style="color: #ff000" >进入系统</button></div><!--item end-->
        <?php $this->endWidget(); ?>
    </div><!--main end-->
</div><!--wrapper end-->
</body>
</html>

<script>
    function login() {
        var post_data = $("#login_form").serialize();
        var s1=$("#User_TUNAME").val();
        var s2='<?php echo $this->createUrl("index/checkUser");?>';
        $.ajax({
            type: 'get',
            url: s2,
            data: {USERNAME: s1,PASSWORD:$("#User_TPWD").val(),
                ROLE:$("#User_F_ROLENAME").val(),
                user_login:$("#user_login").val()
            },
            dataType:'json',
            success: function(data) {
                s1=data.f_kcszid;
                if (s1>0){
                    var s22='https://zcps.scnu.edu.cn<?php echo $this->createUrl("index/index&TCOD=");?>'+s1;
                    s22='/Hhyii/index.php?r=index/index';
                    self.location.href =s22;
                }else{
                    alert("密码 或 用户身份 错误");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
            }
        });
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

