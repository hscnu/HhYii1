<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>填写消毒订单</h1><span class="back"><a class="btn"
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
                        <td colspan="4">填写订单信息</td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'code'); ?></td>
                        <td>
                            <?php $code_value=Date('Y-m-d');$code_value.='-';$code_value.=$code;?>
                            <?php echo $form->textField($model, 'code', array('class' => 'input-text','value'=>$code_value)); ?>
                            <?php echo $form->error($model, 'code', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'title'); ?></td>
                        <td>
                            <?php $title_value=Date('Y-m-d');$title_value.=' ';$title_value.=$restaurant_name;$title_value.='消毒订单'?>
                            <?php echo $form->textField($model, 'title', array('class' => 'input-text','value'=>$title_value)); ?>
                            <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'disinfection_name');?></td>
                        <td><?php echo Select2::activeDropDownList($model, 'disinfection_name',Chtml::listData(DisinfectionCenter::model()->getAllName(), 'name', 'name'), array('prompt'=>'请选择','style'=>'width:160px;'));?>
                            <?php echo $form->error($model, 'disinfection_name', $htmlOptions = array());?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'date');?></td>
                        <td>
                            <?php echo $form->textField($model, 'date', array('class' => 'Wdate','style'=>'width:180px;','value'=>Date('Y-m-d H:m:s')));?>
                            <?php echo $form->error($model, 'date', $htmlOptions = array());?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"> <?php echo $form->labelEx($model, 'notes');?></td>
                        <td colspan="3"> <?php echo $form->textArea($model, 'notes',
                                array('class' => 'input-text', 'style'=>'width:97%;height:100px','maxlength' => '200','placeholder'=>"本栏目限填200字"));?>
                            <?php echo $form->error($model, 'notes', $htmlOptions = array());?>
                        </td>
                    </tr>


                </table>
            </div>
        </div><!--box-detail-tab-item end   style="display:block;"-->

        <div class="box-table">
            <button class="btn btn-green" style="float: right;margin:5px" type="button" onclick="updateDetail();">+添加餐具</button>
            <table class="list">
                <thead>
                <tr>
                    <!--                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>-->
                    <?php $model2 = DisinfectionOrderDetail::model();?>
                    <?php
                    $str='tableware_code,tableware_type,tableware_name,unit,number';
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
            var $date=$('#<?php echo get_class($model);?>_date');
            $date.on('click', function() {
                    WdatePicker( {
                            startDate:'%y-%M-%D %H:%m:%s',dateFmt:'yyyy-MM-dd HH:mm:ss'
                        }
                    );
                }
            );
        }
    );

    $(function() {
            var $date=$('#<?php echo get_class($model);?>_complete_time');
            $date.on('click', function() {
                    WdatePicker( {
                            startDate:'%y-%M-%D %H:%m:%s',dateFmt:'yyyy-MM-dd HH:mm:ss'
                        }
                    );
                }
            );
        }
    );
</script>

<script>
    var deleteUrl = '<?php echo $this->createUrl('DisinfectionOrderDetail/delete', array('id' => 'ID')); ?>';
    function updateDetail(id=0){
        saveFormDate();
        url = '<?php echo $this->createUrl("OpenDialog");?>'
        url += '&order_id=<?php echo $model->id;?>'
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




