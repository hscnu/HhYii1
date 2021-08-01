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
                        <td>
                            <?php echo $form->textField($model, 'boat_id', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'boat_id', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'boat_type'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'boat_type', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'boat_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'affiliated_company'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'affiliated_company', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'affiliated_company', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'registered_captain_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'registered_captain_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'registered_captain_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'captain_phone'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'captain_phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'captain_phone', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'captain_id_card'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'captain_id_card', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'captain_id_card', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'design_draft'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'design_draft', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'design_draft', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'design_drainage'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'design_drainage', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'design_drainage', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'registration_certificate');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'registration_certificate', array('class' => 'input-text fl'));?>
                            <?php echo show_pic($model->registration_certificate,get_class($model).'_'.'registration_certificate')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>registration_certificate', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'registration_certificate', $htmlOptions = array());?>
                        </td>
                    </tr>



                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'fishing_licence');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'fishing_licence', array('class' => 'input-text fl'));?>
                            <?php echo show_pic($model->fishing_licence,get_class($model).'_'.'fishing_licence')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>fishing_licence', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'fishing_licence', $htmlOptions = array());?>
                        </td>
                    </tr>



                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'boat_pic');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'boat_pic', array('class' => 'input-text fl'));?>
                            <?php echo show_pic($model->boat_pic,get_class($model).'_'.'boat_pic')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>boat_pic', 'jpg');
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