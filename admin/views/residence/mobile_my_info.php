<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>我的信息</h1>
        <span class="back"><a class="btn"zhref="javascript:;"onclick="we.back();">
            <i class="fa fa-reply">
            </i>返回</a></span>
    </div><!--box-title end-->

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
                        <td colspan="4">基本信息</td>
                    </tr>



                    <tr>

                        <td><?php echo $form->label($model, 'residence_type'); ?></td>
                        <td colspan="3">
<!--                            --><?php //echo $form->textField($model, 'residence_type', array('class' => 'input-text','readonly'=>'readonly')); ?>
<!--                            --><?php //echo $form->error($model, 'residence_type', $htmlOptions = array()); ?>
                            <?php echo $model->residence_type;?>
                        </td>
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'account_number'); ?></td>
                        <td colspan="3">
                            <?php echo $model->account_number;?>
                        </td><!--单位管理账号-->
                    </tr>
s


                    <tr>
                        <td><?php echo $form->label($model, 'apply_number'); ?></td>
                        <td colspan="3">
                            <?php echo $model->apply_number;?>
                        </td><!--申请人账号-->
                    </tr>

                    <tr>
                        <td><?php echo $form->label($model, 'contact_person'); ?></td>
                        <td colspan="3">
                            <?php echo $model->contact_person;?>
                        </td><!--联系人-->
                    </tr>



                    <tr>
                        <td><?php echo $form->label($model, 'contact_number'); ?></td>
                        <td colspan="3">
                            <?php echo $model->contact_number;?>
                        </td><!--联系电话-->
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'email'); ?></td>
                        <td colspan="3">
                            <?php echo $model->email;?>
                        </td><!--Email-->
                    </tr>



                    <tr>
                        <td><?php echo $form->label($model, 'ID_card_number'); ?></td>
                        <td colspan="3">
                            <?php echo $model->ID_card_number;?>
                        </td><!--身份证账号-->
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'location'); ?></td>
                        <td colspan="3">
                            <?php echo $model->location;?>
                        </td><!--单位所在地-->
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'account_number'); ?></td>
                        <td colspan="3">
                            <?php echo $model->account_number;?>
                        </td><!--单位管理账号-->
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'unit_name'); ?></td>
                        <td colspan="3">
                            <?php echo $model->unit_name;?>
                        </td><!--单位名称-->
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'job'); ?></td>
                        <td colspan="3">
                            <?php echo $model->job;?>
                        </td>
                    </tr><!--职业-->


                    <tr>
                        <td colspan="1"><?php echo $form->label($model, 'IDcard_photo_front');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'IDcard_photo_front', array('class' => 'input-text fl','readonly'=>'readonly'));?>
                            <?php echo show_pic($model->IDcard_photo_front,get_class($model).'_'.'IDcard_photo_front')?>
                            <?php echo $form->error($model, 'IDcard_photo_front', $htmlOptions = array());?>
                        </td>
                    </tr><!--身份证照正面-->



                    <tr>
                        <td colspan="1"><?php echo $form->label($model, 'IDcard_photo_back'); ?></td>
                        <td colspan="3">
                            <?php echo show_pic($model->IDcard_photo_back,get_class($model).'_'.'IDcard_photo_back')?>
                            <?php echo $form->error($model, 'IDcard_photo_back', $htmlOptions = array()); ?>
                        </td>
                    </tr><!--身份证照反面-->



                    <tr>
                        <td colspan="1"><?php echo $form->label($model, 'business_license');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'business_license', array('class' => 'input-text fl','readonly'=>'readonly'));?>
                            <?php echo show_pic($model->business_license,get_class($model).'_'.'business_license')?>
                            <?php echo $form->error($model, 'business_license', $htmlOptions = array());?>
                        </td>
                    </tr><!--营业执照-->

                </table>

            </div><!--box-detail-tab-item end   style="display:block;"-->

        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
            <a class="btn btn-blue" style="z-index:99999" type="submit" href="<?php echo $this->createUrl('mobile_revise_my_info');?>"><h1>编辑</h1></a>
        </div>
            <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->