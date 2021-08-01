<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>单位信息</h1>
        <span class="back"><a class="btn"zhref="javascript:;"onclick="we.back();">
            <i class="fa fa-reply">
            </i>返回</a></span>
    </div><!--box-title end-->

    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">单位基本信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>


                    <tr class="table-title">
                        <td colspan="4">单位基本信息</td>
                    </tr>



                    <tr>

                        <td><?php echo $form->labelEx($model, 'residence_type'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'residence_type', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'residence_type', $htmlOptions = array()); ?>

                        <td><?php echo $form->labelEx($model, 'account_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'account_number', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'account_number', $htmlOptions = array()); ?>
                        </td><!--单位管理账号-->
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'apply_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'apply_number', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'apply_number', $htmlOptions = array()); ?>
                        </td><!--申请人账号-->

                        <td><?php echo $form->labelEx($model, 'contact_person'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'contact_person', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'contact_person', $htmlOptions = array()); ?>
                        </td><!--联系人-->
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'contact_number', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'contact_number', $htmlOptions = array()); ?>
                        </td><!--联系电话-->

                        <td><?php echo $form->labelEx($model, 'email'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'email', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                        </td><!--Email-->
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'ID card_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'ID card_number', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'ID card_number', $htmlOptions = array()); ?>
                        </td><!--身份证账号-->
                        <td><?php echo $form->labelEx($model, 'location'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'location', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'location', $htmlOptions = array()); ?>
                        </td><!--单位所在地-->
                    </tr>


                    <tr>
                        <td><?php echo $form->labelEx($model, 'account_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'account_number', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'account_number', $htmlOptions = array()); ?>
                        </td><!--单位管理账号-->

                        <td><?php echo $form->labelEx($model, 'unit_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'unit_name', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'unit_name', $htmlOptions = array()); ?>
                        </td><!--单位名称-->
                    </tr>


                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'IDcard_photo_front');?></td>
                        <td colspan="2">
                            <?php echo $form->hiddenField($model, 'IDcard_photo_front', array('class' => 'input-text fl','readonly'=>'readonly'));?>
                            <?php echo show_pic($model->IDcard_photo_front,get_class($model).'_'.'IDcard_photo_front')?>
                            <?php echo $form->error($model, 'IDcard_photo_front', $htmlOptions = array());?>
                        </td>
                    </tr><!--身份证照正面-->



                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'IDcard_photo_back'); ?></td>
                        <td colspan="2">
                            <?php echo show_pic($model->IDcard_photo_front,get_class($model).'_'.'IDcard_photo_back')?>
                            <?php echo $form->error($model, 'IDcard_photo_back', $htmlOptions = array()); ?>
                        </td>
                    </tr><!--身份证照反面-->




                    <tr>
                        <td><?php echo $form->labelEx($model, 'job'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'job', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'job', $htmlOptions = array()); ?>
                        </td>
                    </tr><!--职业-->



                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'business_license');?></td>
                        <td colspan="2">
                            <?php echo $form->hiddenField($model, 'business_license', array('class' => 'input-text fl','readonly'=>'readonly'));?>
                            <?php echo show_pic($model->IDcard_photo_front,get_class($model).'_'.'business_license')?>
                            <?php echo $form->error($model, 'business_license', $htmlOptions = array());?>
                        </td>
                    </tr><!--营业执照-->
                </table>

            </div><!--box-detail-tab-item end   style="display:block;"-->

        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
