<div class="box">
    <div class="box-title c">
        <h2>
            <i class="fa fa-table"></i>
            当前界面：基本数据维护》基本数据》<span style="color:DodgerBlue">数据修改</span>
            <span class="back">
            <a2 class="btn" href="javascript:;" onclick="we.back();">
                <class="fa fa-reply"></i>
                返回
            </a2>
            </span>
        </h2>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>

        <div style="display:block;" class="box-detail-tab-item">

            <div class="mt15">
                <table>
                    <tr class="table-title">
                        <td colspan="2">基本数据维护设置</td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'f_name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'f_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'f_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'f_group'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'f_group', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'f_group', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'f_type'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'f_type', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'f_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'f_type_CN'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'f_type_CN', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'f_type_CN', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'f_order'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'f_order', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'f_order', $htmlOptions = array()); ?>
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
