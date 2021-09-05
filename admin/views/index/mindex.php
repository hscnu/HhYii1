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
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.3.min.js"></script> <!--jquery库 -->
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script> <!--百度地图的文件 -->
    <script type="text/javascript" src="http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script> <!--城市选择的-->
    <?php $cs = Yii::app()->clientScript;
    $js_path=Yii::app()->request->baseUrl.'/static/admin'; ?>
    <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/public.css');?>
    <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/font.css');?>
    <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/index.css');?>
    <?php //$cs->registerCoreScript('jquery', CClientScript::POS_END);?>
    <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/jquery.js', CClientScript::POS_END);?>
    <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/jquery.nicescroll.js', CClientScript::POS_END);?>
    <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/index.js', CClientScript::POS_END);?>
    <?php $cs->registerCssFile($js_path.'/layui-v2.6.8/layui/css/layui.css');?>
    <?php $cs->registerScriptFile($js_path.'/layui-v2.6.8/layui/layui.js');?>
</head>
<body>

<link href="css/ionic.min.css" rel="stylesheet">
<script src="js/ionic.bundle.min.js"></script>


<div class="wrapper">
    <div class="tabs tabs-positive tabs-icon-top">
        <div class="tabs tabs-positive tabs-icon-top">
            <?php
            $role= Yii::app()->session['F_ROLENAME'];
            $mrole=MobileRole::model()->find("f_rname='".$role."'");
            $tmp=MobileMenu::model()->findALL("f_code like '%".$mrole->f_tcode."%'");
            foreach ($tmp as $v) {
                $url=$v->url;
                $typename=$v->typename;
                $class=$v->class;
                ?>
                <a class="tab-item active navbar" target="container-iframe" href="<?php echo $this->createUrl($url);?>"
                   data-code="<?php echo substr($v->f_code,0,1)?>"
                   data-title="<?php echo $v->f_title?$v->f_title:$typename?>">

                    <i class="<?php echo $class?>"></i><?php echo $typename?></a>
            <?php }?>
        </div>
    </div>




    <div class="header c">
<!--        <div class="logo"><a href="--><?php //echo Yii::app()->homeUrl;?><!--">-->
<!--                <img src="--><?php //echo SITE_PATH;?><!--/static/admin/img/logo.png">-->
<!--            </a>-->
<!--        </div>-->
<!--        <a class="btn-menu" href="#"><i class="fa fa-reorder"></i></a>-->


<!--        <ul class="nav">-->
<!--            <li><a href="--><?php //echo SITE_PATH;?><!--/" target="_blank"> <span>角色:--><?php //echo Yii::app()->session['F_ROLENAME']?><!--</span></a></li>-->
<!--        </ul>-->
        <ul class="nav nav-host">
            <li><a id="host" href="javascript:;"><i class="icon ion-home"></i><span>主页</span></a></li>
        </ul>
        <span class="nav-title"></span>

<!--        <ul class="tool">-->
<!--            <li><a href="--><?php //echo SITE_PATH;?><!--/" target="_blank"> <span>操作者:--><?php //echo Yii::app()->session['TCNAME']?><!--</span></a></li>-->
<!--            <li><a target="_blank" href="--><?php //echo $this->createUrl('index/index',array('views'=>'index'));?><!--"><i class="fa fa-sign-out"></i> <span>电脑版</span></a></li>-->
<!--            <li><a href="--><?php //echo $this->createUrl('index/logout');?><!--"><i class="fa fa-sign-out"></i> <span>退出</span></a></li>-->
<!--        </ul>-->



    </div><!--header end-->



    <div class="container">
        <div class="container-right-mobile">
            <iframe id="container-iframe" name="container-iframe" frameborder="0" scrolling="auto" src="<?php echo $this->createUrl('public/index');?>"></iframe>
        </div><!--container-right end-->
    </div><!--container end-->




</div><!--wrapper end-->
</body>
</html>


<script type="text/javascript">
    function sleep (time) {
        return new Promise((resolve) => setTimeout(resolve, time));
    }

    function reloadWindow(){
        sleep(10).then(()=>{
            window.location.reload(true);
        })
    }

    $('#host').on('click',function () {
        $.get('<?php echo $this->createUrl('setRole',array('role'=>'主页'))?>',(e)=>{
            console.log(e);
        },'json')
        reloadWindow()
    })

    $('.navbar').on('click',function () {
        if($(this).data('code')==='Z') {
           reloadWindow()
       }
        else {
            $('.nav-title').html($(this).data('title'));
        }

    })

</script>


<style>
    .tabs-positive>.tabs, .tabs.tabs-positive{
        border-color: #368EE0;
        background-color: #368EE0;
        background-image: linear-gradient(
                0deg
                ,#368EE0,#368EE0 50%,transparent 50%);
        color: #fff;
    }


</style>