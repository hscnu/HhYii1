<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>后台管理</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i
class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">用户反馈</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="2">详情表格</td>
                    </tr>
                    <?php foreach ($filed_arr as $k=>$v){
                        echo $model->showUpdate($form,$k,'textField');
                    }?>


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
<script>
    $(function(){
        var $date=$('#<?php echo get_class($model);?>_date');
        $date.on('click', function(){
            WdatePicker({
                startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});});
    });
</script>



