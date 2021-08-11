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

                    <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'star', array('class' => 'input-text fl'));?>
                            <div style="float:left;font-size: 16px;margin:3px;position: relative;top: 10px;">总体服务</div>
                            <ul class="cleanfloat">
                                <li class="cleanfloat">&#9733;</li>
                                <li class="cleanfloat">&#9733;</li>
                                <li class="cleanfloat">&#9733;</li>
                                <li class="cleanfloat">&#9733;</li>
                                <li class="cleanfloat">&#9733;</li>
                            </ul>
                            <div id="show_star" style="float:left;margin:3px;font-size: 16px;position: relative;top: 10px;"></div>
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


<style>
    .cleanfloat::after{clear: both; content:""; visibility: hidden;}/*清浮动*/
    .cleanfloat{ float:left; font-size:28px; margin:3px; color:#ccc; cursor:pointer;}/*五角星样式*/
    .hs,.cs{
        float:left; font-size:28px; margin:3px; cursor:pointer;
        color:orangered;
    }/*五角星点击后样式*/
</style>


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
            var s = 0;
            switch (star){
                case 1:s='非常差';break;
                case 2:s='差';break;
                case 3:s='一般';break;
                case 4:s='满意';break;
                case 5:s='非常满意';break;
            }
            document.getElementById("show_star").innerHTML = s;
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



<style>
    .cleanfloat::after{clear: both; content:""; visibility: hidden;}/*清浮动*/
    .cleanfloat{ float:left; font-size:28px; margin:3px; color:#ccc; cursor:pointer;}/*五角星样式*/
    .hs,.cs{
        float:left; font-size:28px; margin:3px; cursor:pointer;
        color:orangered;
    }/*五角星点击后样式*/
</style>


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
            var s = 0;
            switch (star){
                case 1:s='非常差';break;
                case 2:s='差';break;
                case 3:s='一般';break;
                case 4:s='满意';break;
                case 5:s='非常满意';break;
            }
            document.getElementById("show_star").innerHTML = s;
            $('#<?php echo get_class($model)?>_star').val(star)
        })
    })
</script>

