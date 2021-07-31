<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
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
                        <td colspan="4">上报信息</td>
                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'report_order'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'report_order', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'report_order', $htmlOptions = array()); ?>
                        </td>
                        <td width="30%"><?php echo $form->labelEx($model, 'reporter_name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'reporter_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'reporter_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'report_date');?></td>
                        <td>
                            <?php echo $form->textField($model, 'report_date', array('class' => 'Wdate','style'=>'width:180px;'));?>
                            <?php echo $form->error($model, 'report_date', $htmlOptions = array());?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'state'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'state', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'state', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                    </tr>
                    </table>
                </div>
            </div><!--box-detail-tab-item end   style="display:block;"-->

        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
<!--                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>-->
                    <?php $model2 = ReportProduct::model();?>
                    <?php
                    $str='report_order,product_name,production,production_unit,origin_place';
                    echo $model2->gridHead($str); ?>
                </tr>
                </thead>
                <tbody>
                <?php
                if(isset($detailList))
                foreach ($detailList as $v) { ?>
                    <tr>
                        <?php echo $v->gridRow($str); ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            </br>
            <h1><?php echo  '审核结果'.'<span class="required">*</span>'; ?>
                <td>
                    <?php echo $form->radioButtonList($model, 'state', Chtml::listData(BaseCode::model()->getByType('state_name'), 'f_name', 'f_name'), array('template' => '<li style="display:inline-block;">{input} {label}</li>','separator' => ' ')); ?>
                    <?php echo $form->error($model, 'state', $htmlOptions = array()); ?>
                </td>
            </h1>
            <table style="margin-top: 10px">
                <tr >
                    <td colspan="1"><?php echo $form->labelEx($model, 'audit_opinion'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textArea($model, 'audit_opinion', array('class' => 'input-text', 'maxlength'=>'80','style'=>'height:40px')); ?>
                        <?php echo $form->error($model, 'audit_opinion', $htmlOptions = array()); ?>

                    </td>
                </tr>
            </table>
        </div><!--box-table end-->
        </div><!--box-detail-bd end-->



        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <?php if($model::model()->count('id>'.$model->id))
                echo " <button onclick=\"submitType='baonext'\" class=\"btn btn-blue\" type=\"submit\">审核一下条</button>";
            ?>
<!--            <button class="btn" type="button" onclick="we.back();">取消</button>-->
        </div>

        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->

<script>
    $(function() {
            var $date=$('#<?php echo get_class($model);?>_report_date');
            $date.on('click', function() {
                    WdatePicker( {
                            startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'
                        }
                    );
                }
            );
        }
    );

</script>

<script>
    if('<?php echo $isClose==1?>'){
        $.dialog.data('detailId','<?php echo $model->id;?>')
        $.dialog.close();
    }
    function DetailVerify(id=0){
        url = '<?php echo $this->createUrl("UpdateDetailVerify");?>'
        url +='&detail_id='+id
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'updateDetail',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:"审核上报产品",
            close: function () {
                redirect = '<?php echo str_replace('create','update_verify',Yii::app()->request->getUrl())?>'
                redirect+='&id='+'<?php echo $model->id;?>'
                window.location.href = redirect;
            }
        });
    };
    $(function(){
        let api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        api.button(
            {
                name: '取消'
            }
        );
    });
</script>




