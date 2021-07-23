<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>信息</h1><span class="back"><a class="btn"
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
                        <td width="30%"><?php echo $form->labelEx($model, 'order_name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'order_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_tel'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'order_tel', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_tel', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'ice_amount'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'ice_amount', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'ice_amount', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_destination'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'order_destination', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_destination', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_time');?></td>
                        <td>
                            <?php echo $form->textField($model, 'order_time', array('class' => 'Wdate','style'=>'width:180px;'));?>
                            <?php echo $form->error($model, 'order_time', $htmlOptions = array());?>
                        </td>
                    </tr>

                    <script>
                        $(function() {
                                var $date=$('#<?php echo get_class($model);?>_order_time');
                                $date.on('click', function() {
                                        WdatePicker( {
                                                startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd HH:mm:ss'
                                            }
                                        );
                                    }
                                );
                            }
                        );
                    </script>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_remark'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'order_remark', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_remark', $htmlOptions = array()); ?>
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




