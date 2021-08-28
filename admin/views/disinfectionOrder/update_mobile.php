<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>填写信息</h1><span class="back"></span></div><!--box-title end-->
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
                        <td colspan="3">填写订单信息</td>
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'code'); ?></td>
                        <td colspan="2">
                            <?php $code_value=Date('Ymd');$code_value.=$code;?>
                            <?php echo $form->textField($model, 'code', array('class' => 'input-text','value'=>$code_value)); ?>
                            <?php echo $form->error($model, 'code', $htmlOptions = array()); ?>
                        </td >
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'title'); ?></td>
                        <td colspan="2">
                            <?php $title_value=Date('Y-m-d');$title_value.=' ';$title_value.=$restaurant_name;$title_value.='消毒订单'?>
                            <?php echo $form->textField($model, 'title', array('class' => 'input-text','value'=>$title_value)); ?>
                            <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'disinfection_name');?></td>
                        <td colspan="2"><?php echo Select2::activeDropDownList($model, 'disinfection_name',Chtml::listData(DisinfectionCenter::model()->getAllName(), 'name', 'name'), array('prompt'=>'请选择','style'=>'width:120px;'));?>
                            <?php echo $form->error($model, 'disinfection_name', $htmlOptions = array());?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'date');?></td>
                        <td colspan="2">
                            <?php echo $form->textField($model, 'date', array('class' => 'Wdate','style'=>'width:150px;','value'=>Date('Y-m-d H:m:s')));?>
                            <?php echo $form->error($model, 'date', $htmlOptions = array());?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"> <?php echo $form->labelEx($model, 'notes');?></td>
                        <td colspan="2"> <?php echo $form->textArea($model, 'notes',
                                array('class' => 'input-text', 'style'=>'width:90%;height:35px','maxlength' => '200','placeholder'=>"本栏目限填200字"));?>
                            <?php echo $form->error($model, 'notes', $htmlOptions = array());?>
                        </td>
                    </tr>


                </table>
            </div>
        </div><!--box-detail-tab-item end   style="display:block;"-->

        <div class="box-table">
            <div id="dg" style="z-index: 9999; position: fixed ! important; right: 0px; top: 0px;">
                <table width=""100% style="position: absolute; width:260px; right: 0px; top: 0px;">
                    <button class="btn btn-green" style="float: right;margin:5px" type="button" onclick="updateDetail();">+添加餐具</button>
                    <button class="btn btn-green" style="float: right;margin:5px" type="button" onclick="presetDetail();">+添加预设</button>
                </table>
            </div>

            <table class="list">
                <tbody>
                <?php
                if(isset($detailList))
                    foreach ($detailList as $v){?>
                        <div class="article-item">
                            <div class="article-content">
                                <h4 class="article-title">
                                    <?php echo $v->tableware_name;?>
                                </h4>

                                <div class="article-note">
                                    <p>编号：<?php echo $v->tableware_code;?> 单位：<?php echo $v->unit;?> 数量：<?php echo $v->number;?></p>
                                </div>

                                <div class="article-info">
                                    <p>
                                        <span class="muted">备注：<?php echo $v->notes;?></span>
                                    </p>
                                </div>

                            </div>
                        </div>
                    <?php }?>
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

    function presetDetail(){
        saveFormDate();
        url = '<?php echo $this->createUrl("OpenPreset");?>'
        url += '&order_id=<?php echo $model->id;?>'
        $.dialog.open(url,{
            id: 'updateDetail',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:'请勾选所需要的餐具',
            close: function () {
                redirect = '<?php echo str_replace('create','update',Yii::app()->request->getUrl())?>'
                redirect+='&id='+'<?php echo $model->id;?>'
                window.location.href = redirect;
            }
        });
    }

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




