<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1>
        <span class="back"><a class="btn"
                                                                                           href="javascript:;"
                                                                                           onclick="we.back();"><i
                        class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
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
                        <td colspan="2">单位基本信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'residence_type'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'residence_type', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'residence_type', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'account_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'account_number', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'account_number', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'apply_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'apply_number', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'apply_number', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'contact_person'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'contact_person', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'contact_person', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_number'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'contact_number', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'contact_number', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'email'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'email', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                        </td>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'ID card_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'ID card_number', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'ID card_number', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'IDcard_photo');?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'IDcard_photo', array('class' => 'input-text fl'));?>
                            <?php echo show_pic($model->IDcard_photo,get_class($model).'_'.'IDcard_photo')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_IDcard_photo', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'IDcard_photo', $htmlOptions = array());?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'job');?></td>
                        <td><?php echo Select2::activeDropDownList($model, 'job',Chtml::listData(BaseCode::model()->getByType('job'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:160px;'));?>
                            <?php echo $form->error($model, 'job', $htmlOptions = array());?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'business_license');?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'business_license', array('class' => 'input-text fl'));?>
                            <?php echo show_pic($model->IDcard_photo,get_class($model).'_'.'business_license')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_business_license', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'business_license', $htmlOptions = array());?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'location'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'location', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'location', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr class="table-title">
                        <td colspan="2">推荐单位</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'account_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'account_number', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'account_number', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'unit_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'unit_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'unit_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>


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

