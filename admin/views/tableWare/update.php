<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1><span class="back"><a class="btn"
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
                        <td><?php echo $form->labelEx($model, 'type'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'type', Chtml::listData(TableWareType::model()->getAllType(),'type', 'type'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'type', $htmlOptions = array()); ?>
                        </td>>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'code'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'code', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'unit'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'unit', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'unit', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'cost'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'cost', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'cost', $htmlOptions = array()); ?>
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



