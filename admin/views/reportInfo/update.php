<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1><span class="back"><a class="btn"
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
                        <td colspan="2">上报信息</td>
                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'report_order'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'report_order', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'report_order', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
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
                    </tr>


                    <tr>
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
            <button class="btn btn-green" style="float: right;margin:5px" type="button" onclick="updateDetail();">+添加上报明细</button>
            <table class="list">
                <thead>
                <tr>
                    <!--                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>-->
                    <?php $model2 = ReportProduct::model();?>
                    <?php
                    $str='report_order,product_name,production,production_unit,origin_place';
                    echo $model2->gridHead($str); ?>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(isset($detailList))
                    foreach ($detailList as $v) { ?>
                        <tr>
                            <!--                        <td class="check check-item"><input class="input-check" type="checkbox"-->
                            <!--                                                            value="--><?php //echo CHtml::encode($v->id); ?><!--"></td>-->
                            <?php echo $v->gridRow($str); ?>

                            <td>
                                <button class="btn" type="button" onclick="updateDetail(<?php echo $v->id;?>);">编辑</button>
                                <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id; ?>', deleteUrl);"
                                   title="删除"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
    </div><!--box-detail-bd end-->



    <div class="box-detail-submit">
        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
        <button class="btn" type="button" onclick="we.back();">取消</button>
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
    var deleteUrl = '<?php echo $this->createUrl('ReportProduct/delete', array('id' => 'ID')); ?>';
    function updateDetail(id=0){
        saveFormDate()
        url = '<?php echo $this->createUrl("OpenDialog");?>'
        url += '&report_order=<?php echo $model->report_order;?>'
        url +='&detail_id='+id
        tl= id===0?'添加明细':'修改明细'
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'updateDetail',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:tl,
            close: function () {
                redirect = '<?php echo str_replace('create','update',Yii::app()->request->getUrl())?>'
                redirect+='&id='+'<?php echo $model->id;?>'
                window.location.href = redirect;
            }
        });
    };

    //打开弹窗前先保存订单一次
    function saveFormDate() {
        let form=$('#active-form').serialize();
        let s1='<?php echo $this->createUrl('SaveFormDate');?>'
        s1=s1+'&'+form+'&id='+'<?php echo $model->id;?>'
        $.ajax({
            url: s1,
            type: 'get',
            dataType: 'json',
        })
    }
</script>




