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
                        <td><?php echo $form->labelEx($model, 'boat_id'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'boat_id', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'boat_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'boat_name'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'boat_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'boat_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'fishing_license_no'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'fishing_license_no', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'fishing_license_no', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'boat_type'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'boat_type', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'boat_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'port_of_registry'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'port_of_registry', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'port_of_registry', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'main_job_type'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'main_job_type', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'main_job_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'main_operation_mode'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'main_operation_mode', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'main_operation_mode', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'boat_length'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'boat_length', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'boat_length', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'boat_shape_width'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'boat_shape_width', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'boat_shape_width', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'boat_shape_depth'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'boat_shape_depth', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'boat_shape_depth', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'gross_tonnage'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'gross_tonnage', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'gross_tonnage', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'affiliated_company'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'affiliated_company', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'affiliated_company', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'registered_captain_name'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'registered_captain_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'registered_captain_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'captain_phone'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'captain_phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'captain_phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'registration_certificate');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'registration_certificate', array('class' => 'input-text fl'));?>
                            <?php echo show_pic($model->registration_certificate,get_class($model).'_'.'registration_certificate')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_registration_certificate', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'registration_certificate', $htmlOptions = array());?>
                        </td>
                    </tr>



                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'fishing_licence');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'fishing_licence', array('class' => 'input-text fl'));?>
                            <?php echo show_pic($model->fishing_licence,get_class($model).'_'.'fishing_licence')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_fishing_licence', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'fishing_licence', $htmlOptions = array());?>
                        </td>
                    </tr>



                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'boat_pic');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'boat_pic', array('class' => 'input-text fl'));?>
                            <?php echo show_pic($model->boat_pic,get_class($model).'_'.'boat_pic')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_boat_pic', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'boat_pic', $htmlOptions = array());?>
                        </td>
                    </tr>
                </table>

            </div><!--box-detail-tab-item end   style="display:block;"-->

        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" style="z-index:99999" type="submit">保存</button>
            <button onclick="submitType='tijiaoshenhe'" class="btn btn-blue" style="z-index:99999" type="submit">提交审核</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
            <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->