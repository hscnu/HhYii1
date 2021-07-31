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
                        <td colspan="2">上架商品信息</td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'apply_order'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'apply_order', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'apply_order', $htmlOptions = array()); ?>
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
                        <td><?php echo $form->labelEx($model, 'number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'number', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'number', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'number_unit'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'number_unit', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'number_unit', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'price'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'price', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'price', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'put_time');?></td>
                        <td>
                            <?php echo $form->textField($model, 'put_time', array('class' => 'Wdate','style'=>'width:180px;'));?>
                            <?php echo $form->error($model, 'put_time', $htmlOptions = array());?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'sale_time');?></td>
                        <td>
                            <?php echo $form->textField($model, 'sale_time', array('class' => 'Wdate','style'=>'width:180px;'));?>
                            <?php echo $form->error($model, 'sale_time', $htmlOptions = array());?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'supplier'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'supplier', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'supplier', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'trade_means'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'trade_means', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'trade_means', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_details'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'contact_details', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'contact_details', $htmlOptions = array()); ?>
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
    $(function() {
            var $date=$('#<?php echo get_class($model);?>_put_time');
            $date.on('click', function() {
                    WdatePicker( {
                            startDate:'%y-%M-%D %H:%m:%s',dateFmt:'yyyy-MM-dd HH:mm:ss'
                        }
                    );
                }
            );
        }
    );

    $(function() {
            var $date=$('#<?php echo get_class($model);?>_sale_time');
            $date.on('click', function() {
                    WdatePicker( {
                            startDate:'%y-%M-%D %H:%m:%s',dateFmt:'yyyy-MM-dd HH:mm:ss'
                        }
                    );
                }
            );
        }
    );

</script>

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
