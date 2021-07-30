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

                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_id'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'order_id', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'species'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'species', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'species', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'weight'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'weight', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'weight', $htmlOptions = array()); ?>
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






