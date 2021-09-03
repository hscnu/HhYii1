<div class="box">
    <div class="box-title c"><span class="back"></span></div>
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">明细信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">

                <table>
                    <tr class="table-title">
                    </tr>

                    <tr>
                        <td style='text-align: center;'><?php echo $form->labelEx($model, 'species');?></td>
                        <td colspan="3"><?php echo Select2::activeDropDownList($model, 'species',Chtml::listData(FishingGoods::model()->getByType('type'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:80px;'));?>
                            <?php echo $form->error($model, 'species', $htmlOptions = array());?>
                        </td>
                    </tr>

                    <tr>
                        <td style='text-align: center;'><?php echo $form->labelEx($model, 'code');?></td>
                        <td colspan="3">
                        <?php echo $form->textField($model, 'code', array('class' => 'input-no-border','style'=>'width:60px;')); ?>
                            <?php echo $form->error($model, 'code', $htmlOptions = array());?>
                        </td>
                    </tr>



                    <tr>
                        <td style='text-align: center;'><?php echo $form->labelEx($model, 'unit');?></td>
                        <td colspan="3"><?php echo Select2::activeDropDownList($model, 'unit',Chtml::listData(FishingGoods::model()->getByType('unit'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:80px;'));?>
                            <?php echo $form->error($model, 'unit', $htmlOptions = array());?>
                        </td>
                    </tr>

                    <tr>
                        <td style='text-align: center;'><?php echo $form->labelEx($model, 'number'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'number', array('class' => 'input-text','style'=>'width:60px;')); ?>
                            <?php echo $form->error($model, 'number', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td style='text-align: center;'><?php echo $form->labelEx($model, 'remark');?></td>
                        <td colspan="3">
                            <?php echo $form->textArea($model, 'remark',  array('class' => 'input-text', 'style'=>'width:90%;height:30px','maxlength' => '100'));?>
                            <?php echo $form->error($model, 'remark', $htmlOptions = array());?>
                        </td>
                    </tr>
                    <tr>
                    <td style='text-align: center;'><?php echo $form->labelEx($model, 'img');?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'img', array('class' => 'input-text fl'));?>
                        <?php echo show_pic($model->img,get_class($model).'_'.'img')?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_img', 'jpg');
                        </script>
                        <?php echo $form->error($model, 'img', $htmlOptions = array());?>
                    </td>
                    </tr>
                </table>
            </div>
        </div><!--box-detail-tab-item end   style="display:block;"-->

    </div><!--box-detail-bd end-->



    <div class="box-detail-submit">
        <button onclick="save()" class="btn btn-blue" type="submit">保存</button>
        <?php if(empty($model->id)){ ?>
            <?php  echo " <button onclick=\"submitType='baonext'\" class=\"btn btn-blue\" type=\"submit\">保存继续输入</button>";?>
        <?php } ;?>
    </div>

    <?php $this->endWidget(); ?>
</div><!--box-detail end-->
</div><!--box end-->

<script>

    var species = $('#<?php echo get_class($model);?>_species');
    var code = $('#<?php echo get_class($model);?>_code');

    species.on('change',function (){
        $.get('<?php echo $this->createUrl('getUnit')?>',
            {'species':$(this).val()},
            (res)=>{
            console.log(res)
                code.val(res)
            },'json')
    })


    //后台点击保存按钮后，重定向自身页面（刷新），并转一个参数，通知关闭
    if('<?php echo $isClose==1?>'){
        $.dialog.data('detailId','<?php echo $model->id;?>')
        $.dialog.close();
    }

    $(function(){
        let api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        api.button(
            {
                name: '取消'
            }
        );


    });



</script>

<style>
    .input-no-border{
        border: none;
    }
</style>


