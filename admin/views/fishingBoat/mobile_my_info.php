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
                        <td><?php echo $form->label($model, 'boat_id'); ?></td>
                        <td colspan="3">
                            <?php echo $model->boat_id;?>
                        </td><!--单位管理账号-->
                    </tr>
s


                    <tr>
                        <td><?php echo $form->label($model, 'boat_name'); ?></td>
                        <td colspan="3">
                            <?php echo $model->boat_name;?>
                        </td><!--申请人账号-->
                    </tr>

                    <tr>
                        <td><?php echo $form->label($model, 'fishing_license_no'); ?></td>
                        <td colspan="3">
                            <?php echo $model->fishing_license_no;?>
                        </td><!--联系人-->
                    </tr>



                    <tr>
                        <td><?php echo $form->label($model, 'boat_type'); ?></td>
                        <td colspan="3">
                            <?php echo $model->boat_type;?>
                        </td>
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'port_of_registry'); ?></td>
                        <td colspan="3">
                            <?php echo $model->port_of_registry;?>
                        </td><!--Email-->
                    </tr>



                    <tr>
                        <td><?php echo $form->label($model, 'main_job_type'); ?></td>
                        <td colspan="3">
                            <?php echo $model->main_job_type;?>
                        </td><!--身份证账号-->
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'main_operation_mode'); ?></td>
                        <td colspan="3">
                            <?php echo $model->main_operation_mode;?>
                        </td><!--单位所在地-->
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'boat_length'); ?></td>
                        <td colspan="3">
                            <?php echo $model->boat_length;?>
                        </td><!--单位管理账号-->
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'boat_shape_width'); ?></td>
                        <td colspan="3">
                            <?php echo $model->boat_shape_width;?>
                        </td><!--单位名称-->
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'boat_shape_depth'); ?></td>
                        <td colspan="3">
                            <?php echo $model->boat_shape_depth;?>
                        </td>
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'gross_tonnage'); ?></td>
                        <td colspan="3">
                            <?php echo $model->gross_tonnage;?>
                        </td>
                    </tr>


                    <tr>
                        <td><?php echo $form->label($model, 'affiliated_company'); ?></td>
                        <td colspan="3">
                            <?php echo $model->affiliated_company;?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->label($model, 'registered_captain_name'); ?></td>
                        <td colspan="3">
                            <?php echo $model->registered_captain_name;?>
                        </td>
                    </tr>




                    <tr>
                        <td><?php echo $form->label($model, 'captain_phone'); ?></td>
                        <td colspan="3">
                            <?php echo $model->captain_phone;?>
                        </td>
                    </tr>


                    <tr>
                        <td colspan="1"><?php echo $form->label($model, 'registration_certificate');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'registration_certificate', array('class' => 'input-text fl','readonly'=>'readonly'));?>
                            <?php echo show_pic($model->registration_certificate,get_class($model).'_'.'registration_certificate')?>
                            <?php echo $form->error($model, 'registration_certificate', $htmlOptions = array());?>
                        </td>
                    </tr>


                    <tr>
                        <td colspan="1"><?php echo $form->label($model, 'fishing_licence');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'fishing_licence', array('class' => 'input-text fl','readonly'=>'readonly'));?>
                            <?php echo show_pic($model->fishing_licence,get_class($model).'_'.'fishing_licence')?>
                            <?php echo $form->error($model, 'fishing_licence', $htmlOptions = array());?>
                        </td>
                    </tr>



                    <tr>
                        <td colspan="1"><?php echo $form->label($model, 'boat_pic');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'boat_pic', array('class' => 'input-text fl','readonly'=>'readonly'));?>
                            <?php echo show_pic($model->boat_pic,get_class($model).'_'.'boat_pic')?>
                            <?php echo $form->error($model, 'boat_pic', $htmlOptions = array());?>
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