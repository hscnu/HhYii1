<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="zh-cn"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="zh-cn"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="zh-cn"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="zh-cn"><!--<![endif]-->






<head>
    <meta charset="utf-8">
    <title>後臺管理系統</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge，chrome=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <?php $cs = Yii::app()->clientScript;?>
    <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/public.css');?>
    <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/font.css');?>
    <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/index.css');?>
    <?php //$cs->registerCoreScript('jquery', CClientScript::POS_END);?>
    <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/jquery.js', CClientScript::POS_END);?>
    <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/jquery.nicescroll.js', CClientScript::POS_END);?>
    <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/index.js', CClientScript::POS_END);?>



  
    <title>我的信息</title>
    <link href="css/ionic.min.css" rel="stylesheet">
    <script src="js/ionic.bundle.min.js"></script>
     <script type="text/javascript">
    angular.module('ionicApp', ['ionic'])
    .controller('SlideController', function($scope) {
      $scope.myActiveSlide = 0;
    });

    </script>






</head>

<body>
  

 


<div class="wrapper">
         <div class="tabs tabs-positive tabs-icon-top">
        <div class="tabs tabs-positive tabs-icon-top">
            <a class="tab-item active " target="container-iframe" href="<?php echo $this->createUrl('Ice/index_appoint_finish');?>">
            <i class="icon ion-ios-home-outline"></i>投稿</a>
            <a class="tab-item active " target="container-iframe" href="<?php echo $this->createUrl('Ice/index_appoint_wait');?>">
            <i class="icon ion-ios-paper-outline"></i>优秀文章</a>
            <a class="tab-item active " target="container-iframe" href="my.php">
            <i class="icon ion-ios-person-outline"></i>我</a>
    </div>  
    </div> 
   <div class="bar bar-header bar-positive item-input-inset " >
     <h1 id="title" class="title"></h1>
    </div>
      
    </div>
   

    <div class="container">
<iframe id="container-iframe" height="100%" width="100%"name="container-iframe" allowfullscreen="true" scrolling="yes" src="<?php echo $this->createUrl('public/index');?>"></iframe>
 </div>



</div><!--wrapper end-->
</body>
</html>


<script>
    $(function () {
        $('a').on('click',function () {
            $('#title').html(this.text)
        })
    })
</script>
