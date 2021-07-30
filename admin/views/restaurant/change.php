<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>店家信息</h1><span class="back"><a class="btn"
                                                                                           href="javascript:;"
                                                                                           onclick="we.back();"><i
                    class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
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
                        <td width="30%"><?php echo $form->labelEx($model, 'r_name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'r_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'r_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'r_address'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'r_address', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'r_address', $htmlOptions = array()); ?>
                        </td>
                    </tr>


                    <tr>
                        <td><?php echo $form->labelEx($model, 'r_phone'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'r_phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'r_phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'r_image'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'r_image', array('class' => 'input-text fl')); ?>
                            <?php echo show_pic($model->r_image,get_class($model).'_'.'r_image')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_r_image', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'r_image', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'r_introduce'); ?></td>
                        <td >
                            <?php echo $form->textArea($model, 'r_introduce', array('class' => 'input-text', 'style'=>'width:95%;height:100px','maxlength' => '2000','placeholder'=>"限填1000字")); ?>
                            <?php echo $form->error($model, 'r_introduce', $htmlOptions = array()); ?>
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



