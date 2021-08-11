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
                        <td colspan="2">申请信息</td>
                    </tr>

                    <!--                    <tr>-->
                    <!--                        <td>--><?php //echo $form->labelEx($model, 'tableware_type'); ?><!--</td>-->
                    <!--                        <td>-->
                    <!--                            --><?php //echo $form->dropDownList($model, 'tableware_type', Chtml::listData(TableWareType::model()->getAllType(),'type', 'type'), array('prompt'=>'请选择')); ?>
                    <!--                            --><?php //echo $form->error($model, 'tableware_type', $htmlOptions = array()); ?>
                    <!--                        </td>-->
                    <!--                    </tr>-->

                    <tr>
                        <td><?php echo $form->labelEx($model, 'ice_id');?></td>
                        <td><?php echo Select2::activeDropDownList($model, 'ice_id',Chtml::listData(IceType::model()->getByType('choose'), 'ice_id', 'ice_id'), array('prompt'=>'请选择','style'=>'width:160px;'));?>
                            <?php echo $form->error($model, 'ice_id', $htmlOptions = array());?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'ice_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'ice_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'ice_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'specification'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'specification', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'specification', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'amount'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'amount', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'amount', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'unit_price'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'unit_price', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'unit_price', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'remark'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'remark', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'remark', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'total_price'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'total_price', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'total_price', $htmlOptions = array()); ?>
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




