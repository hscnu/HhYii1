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
                        <td><?php echo $form->labelEx($model, 'product_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'product_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'product_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'report_date'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'report_date', array('class' => 'Wdate','style'=>'width:180px;','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'report_date', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'production'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'production', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'production', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'origin_place'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'origin_place', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'origin_place', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>

            </div><!--box-detail-tab-item end   style="display:block;"-->

        </div><!--box-detail-bd end-->


        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->

<script>
    $(function() {
            var $date=$('#<?php echo get_class($model);?>_report_date');
            $date.on('click', function() {
                    WdatePicker( {
                            startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'
                        }
                    );
                }
            );
        }
    );
</script>

