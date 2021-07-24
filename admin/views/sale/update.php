<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>拍卖信息</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i
class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">拍卖信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
<table>
                    <tr class="table-title">
                        <td colspan="2">基本信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'title'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'title', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                        </td>
                    </tr>  
                    <tr>
                        <td><?php echo $form->labelEx($model, 'saler_id'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'saler_id', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'saler_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'buyer_id'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'buyer_id', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'buyer_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'saler_username'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'saler_username', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'saler_username', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'buyer_username'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'buyer_username', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'buyer_username', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'start_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'start_time', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'start_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'end_time', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'this_record_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'this_record_time', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'this_record_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'start_price'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'start_price', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'start_price', $htmlOptions = array()); ?>
                        </td>
                    </tr>  

                    <tr>
                        <td><?php echo $form->labelEx($model, 'buyer_price'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'buyer_price', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'buyer_price', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'goods_id'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'goods_id', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'goods_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'goods_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'goods_name', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'goods_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>   

                    <tr>
                        <td><?php echo $form->labelEx($model, 'goods_weight'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'goods_weight', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'goods_weight', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'goods_info'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'goods_info', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'goods_info', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'is_admit'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'is_admit', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'is_admit', $htmlOptions = array()); ?>
                        </td>
                    </tr>


                    </table>
                </div>


            </div><!--box-detail-tab-item end   style="display:block;"-->
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button onclick="submitType='baonext'" class="btn btn-blue" type="submit">保存并继续输入</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
//   设置input文本框成无框文本，要闪烁一下
//     $("input").attr('type','hidden');
//     var text= $(".input-text").children().prevObject;
//      for(var i =0;i<text.length;i++){
//          var id = text[i].id;
//          console.log("#"+id);
//          $("#"+id).after("<text>"+text[i].value+"</text>");
//      }

if(<?php echo Yii::app()->session['F_ROLENAME']!='系统管理员'?>){
    if(<?php echo $_SESSION['views']!='拍卖录入'?>)
        readonly();

}

    function readonly(){
    $("input").attr('disabled','disabled');
    $(".uploadifive-button").hide();
}


</script>



