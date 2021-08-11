
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
                        <td colspan="8">商品信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'ice_id'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'ice_id', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'ice_id', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'ice_type'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'ice_type', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'ice_type', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'specification'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'specification', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'specification', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'unit_price'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'unit_price', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'unit_price', $htmlOptions = array()); ?>
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