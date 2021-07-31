<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1><span class="back"></span></div><!--box-title end-->
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
                        <td colspan="2">上报信息</td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'report_order'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'report_order', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'report_order', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <!--                    <tr>-->
                    <!--                        <td>--><?php //echo $form->labelEx($model, 'tableware_type'); ?><!--</td>-->
                    <!--                        <td>-->
                    <!--                            --><?php //echo $form->dropDownList($model, 'tableware_type', Chtml::listData(TableWareType::model()->getAllType(),'type', 'type'), array('prompt'=>'请选择')); ?>
                    <!--                            --><?php //echo $form->error($model, 'tableware_type', $htmlOptions = array()); ?>
                    <!--                        </td>-->
                    <!--                    </tr>-->

                    <tr>
                        <td><?php echo $form->labelEx($model, 'product_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'product_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'product_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'production'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'production', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'production', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'production_unit'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'production_unit', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'production_unit', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'origin_place'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'origin_place', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'origin_place', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                </table>
            </div>
        </div><!--box-detail-tab-item end   style="display:block;"-->

    </div><!--box-detail-bd end-->



    <div class="box-detail-submit">
        <button onclick="save()" class="btn btn-blue" type="submit">保存</button>
    </div>

    <?php $this->endWidget(); ?>
</div><!--box-detail end-->
</div><!--box end-->

<script>
    //后台点击保存按钮后，重定向自身页面（刷新），并转一个参数，通知关闭
    if('<?php echo $isClose==1?>'){
        $.dialog.data('detailId','<?php echo $model->id;?>')
        $.dialog.close();
    }

    $(function(){
        let api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        api.button(
            {
                name: '取消'
            }
        );
    });
</script>
