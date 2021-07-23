<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>包裹信息</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i
class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">包裹信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="2">基本信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'c_id'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'c_id', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'c_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'au_code'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'au_code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'au_code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'c_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'c_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'c_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'p_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'p_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'p_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'c_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'c_number', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'c_number', $htmlOptions = array()); ?>
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
    if(<?php echo $_SESSION['views']!='快递录入'?>)
        readonly();

}

    function readonly(){
    $("input").attr('disabled','disabled');
    $(".uploadifive-button").hide();
}


</script>



