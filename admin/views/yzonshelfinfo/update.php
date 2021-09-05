<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>养殖商品上架信息</h1><span class="back"><a class="btn"
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
                        <td colspan="6">上架信息</td>
                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'apply_order'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'apply_order', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'apply_order', $htmlOptions = array()); ?>
                        </td>

                        <td width="30%"><?php echo $form->labelEx($model, 'apply_name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'apply_name', array('class' => 'input-text', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'apply_name', $htmlOptions = array()); ?>
                        </td>

                        <td width="30%"><?php echo $form->labelEx($model, 'apply_date');?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'apply_date', array('class' => 'Wdate','style'=>'width:180px;'));?>
                            <?php echo $form->error($model, 'apply_date', $htmlOptions = array());?>
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
                    <th style="text-align: center"><?php echo $model2->getAttributeLabel('number'); ?></th>
                    <th style="text-align: center"><?php echo $model2->getAttributeLabel('number_unit'); ?></th>
                    <th style="text-align: center"><?php echo $model2->getAttributeLabel('price'); ?></th>
                    <th style="text-align: center"><?php echo $model2->getAttributeLabel('origin_place'); ?></th>
<!--                    <th style="text-align: center">筛选</th>-->
                </tr>
                </thead>
                <tbody>
                <?php  $tmp=UserFarmProduct::model()->findAll('user_id='.get_session('userId').' order by product_id');

                $order_id = $model->apply_order;
                $R=0;
                $modelName2 = 'YzOnShelfProduct';
                foreach ($tmp as $v) {

                    $data = YzOnShelfProduct::model()->find('apply_order='.$order_id." and product_id=".$v->product_id);
                    if (empty($data)){
                        $data=new $modelName2();
                        $data->number = 0;
                        $data->price = 0;
                    }

                    ?>

                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->product_name; ?></td>
                        <td style='text-align: center;'><?php echo $form->textField($data, 'number', array('class' => 'input-text','name'=>'dataNumber['.$R.']')); ?></td>
                        <td style="text-align: center"><?php echo $v->production_unit; ?></td>
                        <td style='text-align: center;'><?php echo $form->textField($data, 'price', array('class' => 'input-text','name'=>'dataPrice['.$R.']')); ?></td>
                        <td style="text-align: center"><?php echo $v->origin_place; ?></td>

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
            var $date=$('#<?php echo get_class($model);?>_apply_date');
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
    //var deleteUrl = '<?php //echo $this->createUrl('YzOnShelfProduct/delete', array('id' => 'ID')); ?>//';
    //function updateDetail(id=0){
    //    saveFormDate()
    //    url = '<?php //echo $this->createUrl("OpenDialog");?>//'
    //    url += '&apply_order=<?php //echo $model->apply_order;?>//'
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




