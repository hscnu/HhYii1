<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
        </span>
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
                        <td colspan="2">申请信息</td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'report_order'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'report_order', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'report_order', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'reporter_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'reporter_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'reporter_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'report_date'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'report_date', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'report_date', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'face_url'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'face_url', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'face_url', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'evaluate_wrd'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'evaluate_wrd', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'evaluate_wrd', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'evaluate_img'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'evaluate_img', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                                                      <?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'evaluate_img', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'evaluate_stars'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'evaluate_stars', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'evaluate_stars', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'evaluate_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'evaluate_time', array('class' => 'input-text')); ?>

                            <?php echo $form->error($model, 'evaluate_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                </table>
                <div class="mt15">
                    <table style='margin-top:5px;'>
                        <tr class="table-title">
                            <td colspan="2">联系人信息</td>
                        </tr>

                        <tr>
                            <td><?php echo $form->labelEx($model, 'res_owner_phone'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'res_owner_phone', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'res_owner_phone', $htmlOptions = array()); ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $form->labelEx($model, 'user_name'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'user_name', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'user_name', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'face_url'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'face_url', array('class' => 'input-text')); ?>

                                <?php echo $form->error($model, 'face_url', $htmlOptions = array()); ?>
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



