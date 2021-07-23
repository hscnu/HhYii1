




<div class="box">
    <div class="box-title c">
        <h2>
            <i class="fa fa-table"></i>
            当前界面：基本数据维护》角色授权管理》<span style="color:DodgerBlue">详情</span>
            <span class="back">
            <a2 class="btn" href="javascript:;" onclick="we.back();">
                <class="fa fa-reply"></i>
                返回
            </a2>
            </span>
        </h2>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div style="display:block;" class="box-detail-tab-item">
            <div class="mt15">
                <table>
                    <tr class="table-title">
                        <td colspan="4">单位角色授权管理</td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'f_rcode'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'f_rcode', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'f_rcode', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'f_rname'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'f_rname', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'f_rname', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="1">功能授权</td>
                        <td colspan="3">
                            <span style="font-size: larger;">所有模块</span>
                            <button id="SelectAll_jstb" class="btn" type="button" >全选</button>
                            <button id="SelectAll_jstb_qx" class="btn" type="button" style="margin-right: 60px">取消</button>


                        </td>
                    </tr>
                    <tr>

<!--                        <td colspan="1">--><?php //echo $form->labelEx($model, 'f_opter'); ?><!--</td>-->
<!--                        <td colspan="3">-->
<!--                            --><?php //echo $form->checkBoxList($model, 'f_opter', Chtml::listData(Menu::model()->getAllType('f_name'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
<!--                            --><?php //echo $form->error($model, 'f_opter', $htmlOptions = array()); ?>
<!--                        </td>-->
                        <td colspan="1"></td>
                        <td class="subnav" colspan="3">
                            <input id="ytRole_f_opter" type="hidden" value="" name="Role[f_opter]">
                            <span id="Role_f_opter">
                            <?php
                            if(empty($model->f_opter))$model->f_opter=array();
                            $pmenu=Menu::model()->getMenu();
                            foreach( $pmenu as $v){?>
<!--                             <div style="display:flex;flex-direction:row; align-items:center;">-->
                                <div class="subnav-hd">
                                    <a href="javascript:;"><i class="fa fa-angle-down"></i><?php echo $v[0];?></a>
                                </div>
<!--                            <input class="input-check" style="margin: 5px;zoom:130%; " type="checkbox" id="--><?php //echo $v[0];?><!--">-->
<!--                             </div>-->

                                <ul class="subnav-bd">
                                    <?php foreach($v as $v_item){
                                        if(is_array($v_item)){
                                            foreach($v_item as $v_subitem){
                                                if(count($v_subitem)>1){?>
                                                    <span class="check">
                                                    <input class="input-check" <?php echo in_array($v_subitem[2],$model->f_opter)?'checked="checked"':'checked:false' ?> id="Role_f_opter_<?php echo $v_subitem[2]?>" value="<?php echo $v_subitem[2];?>" type="checkbox" name="Role[f_opter][]">
                                                        <label for="Role_f_opter_<?php echo $v_subitem[2]?>">  <?php echo $v_subitem[0];?> </label>
                                                    </span>
                                                    <br>
                                                <?php }?>
                                            <?php }?>
                                        <?php }?>
                                    <?php }?>
                                </ul>
                            <?php }?>
                            </span>
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
</div><!--box end-->

<script>
$('#SelectAll_jstb').click(
    function () {
            for( var i =1;i<100;i++){
             $('#Role_f_opter_'+i).prop("checked",true);
         }
        alert('已全选模块！');
    }
)
$('#SelectAll_jstb_qx').click(
    function () {
        for( var i =1;i<100;i++){
            $('#Role_f_opter_'+i).prop("checked",false);
        }
        alert('已取消全选模块！');
    }
)
</script>


<?php $cs = Yii::app()->clientScript;?>
<?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/public.css');?>
<?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/font.css');?>
<?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/index.css');?>
<?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/jquery.nicescroll.js', CClientScript::POS_END);?>
<?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/index.js', CClientScript::POS_END);?>

