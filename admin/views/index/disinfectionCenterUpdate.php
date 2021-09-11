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
<div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <div class="box-detail-tab">
        <ul class="c">
            <li class="current">基本信息</li>
        </ul>
    </div><!--box-detail-tab end-->
    <div class="box-detail-bd">
        <div style="display:block;" class="box-detail-tab-item">
            <table>
                <tr class="table-title">
                    <td colspan="2">申请信息</td>
                </tr>
                <tr>
                    <td width="30%"><?php echo $form->labelEx($model, 'name'); ?></td>
                    <td width="30%">
                        <?php echo $form->textField($model, 'name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                    </td>
                </tr>

                <tr>
                    <td><?php echo $form->labelEx($model, 'address'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'address', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'address', $htmlOptions = array()); ?>
                    </td>
                </tr>

                <tr>
                    <td><?php echo $form->labelEx($model, 'phone'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'phone', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'phone', $htmlOptions = array()); ?>
                    </td>
                </tr>


            </table>
        </div>
    </div><!--box-detail-tab-item end   style="display:block;"-->

</div><!--box-detail-bd end-->



<div class="box-detail-submit">
    <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
    <button class="btn" type="button" onclick="we.back();">取消</button>
</div>

<?php $this->endWidget(); ?>
</div><!--box-detail end-->
</body>
</html>


