<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>养殖收成产量上报信息</h1><span class="back"><a class="btn"
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
                        <td colspan="6">上报信息</td>
                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'report_order'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'report_order', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'report_order', $htmlOptions = array()); ?>
                        </td>

                        <td width="30%"><?php echo $form->labelEx($model, 'reporter_name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'reporter_name', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'reporter_name', $htmlOptions = array()); ?>
                        </td>

                        <td width="30%"><?php echo $form->labelEx($model, 'report_date');?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'report_date', array('class' => 'Wdate','style'=>'width:180px;'));?>
                            <?php echo $form->error($model, 'report_date', $htmlOptions = array());?>
                        </td>

                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'theme'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'theme', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'theme', $htmlOptions = array()); ?>
                        </td>

                        <td width="30%"><?php echo $form->labelEx($model, 'remark'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'remark', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'remark', $htmlOptions = array()); ?>
                        </td>

                        <td width="30%"><?php echo $form->labelEx($model, 'state'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'state', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'state', $htmlOptions = array()); ?>
                        </td>

                    </tr>
                    </table>
                </div>
            </div><!--box-detail-tab-item end   style="display:block;"-->

        <div class="box-table">
            <table class="list">

                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th style="text-align: center"><?php echo $model2->getAttributeLabel('product_name'); ?></th>
                    <th style="text-align: center"><?php echo $model2->getAttributeLabel('production'); ?></th>
                    <th style="text-align: center"><?php echo $model2->getAttributeLabel('production_unit'); ?></th>
                    <th style="text-align: center"><?php echo $model2->getAttributeLabel('origin_place'); ?></th>
                    <th style="text-align: center">筛选</th>
                </tr>
                </thead>
                <tbody>
                <?php  $tmp=UserFarmProduct::model()->findAll('user_id='.get_session('userId').' order by product_id');

                $order_id = $model->report_order;
                $R=0;
                foreach ($tmp as $v) {

                    $data = YzReportHarvestProduct::model()->find('report_order='.$order_id." and product_id=".$v->product_id);
                    if (empty($data)){
                        $v->production = 0;
                    }
                    else $v->production = $data->production;
                    ?>

                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->product_name; ?></td>
                        <td style='text-align: center;'><?php echo $form->textField($v, 'production', array('class' => 'input-text','name'=>'dataArray['.$R.']')); ?></td>
                        <td style="text-align: center"><?php echo $v->production_unit; ?></td>
                        <td style="text-align: center"><?php echo $v->origin_place; ?></td>

                        <td style="text-align: center">
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id; ?>', deleteUrl);"
                               title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                <?php   $R=$R+1;
                }?>
                </tbody>

            </table>
        </div><!--box-table end-->
        </div><!--box-detail-bd end-->





        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button onclick="submitType='tijiao'" class="btn btn-blue" type="submit">提交</button>
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
    //var deleteUrl = '<?php //echo $this->createUrl('YzReportHarvestProduct/delete', array('id' => 'ID')); ?>//';
    //function updateDetail(id=0){
    //    saveFormDate()
    //    url = '<?php //echo $this->createUrl("OpenDialog");?>//'
    //    url += '&report_order=<?php //echo $model->report_order;?>//'
    //    url +='&detail_id='+id
    //    tl= id===0?'添加明细':'修改明细'
    //    $.dialog.data('id',0)
    //    $.dialog.open(url,{
    //        id: 'updateDetail',
    //        lock:true,opacity:0.3,
    //        width:'1000px',
    //        height:'80%',
    //        title:tl,
    //        close: function () {
    //            redirect = '<?php //echo str_replace('create','update',Yii::app()->request->getUrl())?>//'
    //            redirect+='&id='+'<?php //echo $model->id;?>//'
    //            window.location.href = redirect;
    //        }
    //    });
    //};
    //
    ////打开弹窗前先保存订单一次
    //function saveFormDate() {
    //    let form=$('#active-form').serialize();
    //    let s1='<?php //echo $this->createUrl('SaveFormDate');?>//'
    //    s1=s1+'&'+form+'&id='+'<?php //echo $model->id;?>//'
    //    $.ajax({
    //        url: s1,
    //        type: 'get',
    //        dataType: 'json',
    //    })
    //}

    //function submitOrder(id=0) {
    //    url = '<?php //echo $this->createUrl("SubmitOrder");?>//'
    //    url += 'id=' +id
    //增加一个提交按钮要怎么改
    //
    //}
</script>




