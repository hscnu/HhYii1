<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>评价</h1><span class="back"><a class="btn"
                                                                                           href="javascript:;"
                                                                                           onclick="we.back();"><i
                        class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list());?>
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
                    <td><?php echo $form->labelEx($model, 'eval_rest'); ?></td>
                    <td>
                        <?php echo Select2::activeDropDownList($model, 'eval_rest',  Chtml::listData(Restaurant::model()->findAll(array(
                            'select'=> array('r_name'),
                            'order' => 'r_name DESC',
                        )),'r_name','r_name'), array('prompt'=>'请选择','style'=>'width:200px')); ?>
                        <?php echo $form->error($model, 'eval_rest', $htmlOptions = array()); ?>
                    </td>

                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'eval_star'); ?>
                        </td>
                        <td>
                            <ul>
                                    <li class="cleanfloat">&#9733;</li>
                                    <li class="cleanfloat">&#9733;</li>
                                    <li class="cleanfloat">&#9733;</li>
                                    <li class="cleanfloat">&#9733;</li>
                                    <li class="cleanfloat">&#9733;</li>
                              </ul>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'eval_image'); ?></td>
                        <td width="30%">
                            <?php echo $form->hiddenField($model, 'eval_image', array('class' => 'input-text fl')); ?>
                            <?php echo show_pic($model->eval_image,get_class($model).'_'.'eval_image')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_eval_image', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'eval_image', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'eval_content'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'eval_content', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'eval_content', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'evaluator'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'evaluator', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'evaluator', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div><!--box-detail-tab-item end   style="display:block;"-->

    </div><!--box-detail-bd end-->


    <div class="box-detail-submit">
        <button onclick="submitType='baocun'"class="btn btn-blue" type="submit" id = 'submit'>保存</button>
        <button class="btn" type="button" onclick="we.back();">取消</button>
    </div>

    <?php $this->endWidget(); ?>
</div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function () {
        var star;
        $("ul li").hover(function () {
            $(this).addClass('hs');
            $(this).prevAll().addClass('hs');
            star = $(this).prevAll().length + 1;
        }, function () {
            $(this).removeClass('hs');
            $(this).prevAll().removeClass('hs');
            star = $(this).prevAll().length + 1;
        })
        $("ul li").click(function () {
            $(this).addClass('cs');
            $(this).prevAll().addClass('cs');
            $(this).nextAll().removeClass('cs');
            star = $(this).prevAll().length + 1;
            $.ajax({
                url: '<?php echo $this->createUrl('SaveStar')?>',//目的php文件
                data: {'star': star},//传输的数据
                type: 'post',//数据传送的方式get/post
                dataType: 'text',//数据传输的格式是text
                success: function (response) {
                },
            })
        })
    })
</script>


