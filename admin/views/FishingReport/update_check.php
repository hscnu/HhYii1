<div class="box">
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
                        <td width="30%"><?php echo $form->labelEx($model, 'name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'name', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                        </td>
                        <td width="30%"><?php echo $form->labelEx($model, 'boat_id'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'boat_id', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'boat_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'fishingtime');?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'fishingtime', array('class' => 'Wdate','style'=>'width:180px;'));?>
                            <?php echo $form->error($model, 'fishingtime', $htmlOptions = array());?>
                        </td>
                    </tr>

                    <tr>
                    </tr>
                </table>
            </div>
        </div><!--box-detail-tab-item end   style="display:block;"-->
        <?php $index=1; ?>
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th style='text-align: center;'>序号</th>
                    <?php $model2 = ReportDetail::model();?>
                    <?php
                    $str='code,species,unit,number';
                    echo $model2->gridHead($str); ?>
                </tr>
                </thead>
                <tbody>
                <?php
                if(isset($detailList))
                    foreach ($detailList as $v) { ?>
                        <tr>
                            <td style='text-align: center;'><?php echo $index++; ?></td>
                            <?php echo $v->gridRow($str); ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </br>
            <h1><?php echo  '审核结果'.'<span class="required">*</span>'; ?>
                <td>
                    <?php echo $form->radioButtonList($model, 'state', Chtml::listData(BaseCodefish::model()->getByType('statename'), 'f_code', 'f_name'), array('template' => '<li style="display:inline-block;">{input} {label}</li>','separator' => ' ')); ?>
                    <?php echo $form->error($model, 'state', $htmlOptions = array()); ?>
                </td>
            </h1>
            <table style="margin-top: 10px">
                <tr >
                    <td colspan="1"><?php echo $form->labelEx($model, 'opinion'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textArea($model, 'opinion', array('class' => 'input-text', 'maxlength'=>'80','style'=>'height:40px')); ?>
                        <?php echo $form->error($model, 'opinion', $htmlOptions = array()); ?>

                    </td>
                </tr>
            </table>
        </div><!--box-table end-->
    </div><!--box-detail-bd end-->
    <div class="box-detail-submit">
        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
    </div>
    <?php $this->endWidget(); ?>
</div><!--box-detail end-->
</div><!--box end-->

<script>
    $(function() {
            var $date=$('#<?php echo get_class($model);?>_fishingtime');
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
    function DetailVerify2(id=0){
        url = '<?php echo $this->createUrl("UpdateDetailVerify2");?>'
        url +='&detail_id='+id
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'updateDetail',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:"审核上报产品",
            close: function () {
                redirect = '<?php echo str_replace('create','update_check',Yii::app()->request->getUrl())?>'
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
