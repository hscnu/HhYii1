<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1><span class="back"><a class="btn"
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
                        <td width="30%"><?php echo $form->labelEx($model, 'd_image'); ?></td>
                        <td width="30%">
                            <?php echo $form->hiddenField($model, 'd_image', array('class' => 'input-text fl')); ?>
                            <?php echo show_pic($model->d_image,get_class($model).'_'.'d_image')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_d_image', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'd_image', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'd_name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'd_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'd_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'd_rest'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'd_rest', array('class' => 'input-text', 'style'=>"border-style:none", 'readonly'=>"readonly",'value'=>$_SESSION['rest'])); ?>
                            <?php echo $form->error($model, 'd_rest', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'd_price'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'd_price', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'd_price', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'd_introduce'); ?></td>
                        <td >
                            <?php echo $form->textArea($model, 'd_introduce', array('class' => 'input-text', 'style'=>'width:95%','maxlength' => '20','placeholder'=>"限填20字")); ?>
                            <?php echo $form->error($model, 'd_introduce', $htmlOptions = array()); ?>
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



