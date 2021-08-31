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
<div class="wrapper flex-center">
   <div class="background-white container-card">
       <div class="item-card">
           <span class="item-card-title"><h1>入驻类型</h1></span>
           <div class="item-list">
            <div class="bd-grey">
                <a>
                    <div>
                        送冰
                    </div>
                    <div>
                        提示信息
                    </div>
                </a>
            </div>
               <div class="bd-grey">


               <a>
                   <div>
                       捕鱼
                   </div>
                   <div>
                       提示信息
                   </div>
               </a>
             </div>

           </div>
       </div>
   </div>
</div><!--wrapper end-->
</body>
</html>

<script>
   $(function () {
    $('.bd-grey').on('click',function () {
        $('.bd-grey').attr('style','background-color: none')
        $(this).attr('style','background-color: #e7e7e7')
    })
   })
</script>

