<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>更新信息</h1><span class="back"><a class="btn"
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
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        
                       <td> <?php echo $form->labelEx($model, 'company'); ?></td>
                         <td >
                            <?php echo $form->textField($model, 'company', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'company', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                    <td><?php echo $form->labelEx($model, 'fishingtime');?></td>
                    <td>
                    <?php echo $form->textField($model, 'fishingtime', array('class' => 'Wdate','style'=>'width:180px;'));?>
                    <?php echo $form->error($model, 'fishingtime', $htmlOptions = array());?>
                    </td>
                    </tr>

                    <tr>
                    <td><?php echo $form->labelEx($model, 'reporttime');?></td>
                    <td>
                    <?php echo $form->textField($model, 'reporttime', array('class' => 'Wdate','style'=>'width:180px;'));?>
                    <?php echo $form->error($model, 'reporttime', $htmlOptions = array());?>
                    </td>
                    </tr>
                     
                </table>

            </div><!--box-detail-tab-item end   style="display:block;"-->
        </div><!--box-detail-bd end-->

        <div class="box-table">
            <button class="btn btn-green" style="float: right;margin:5px" type="button" onclick="updateDetail();">+上报明细</button>
            <table class="list">
                <thead>
                <tr>
<!--                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>-->
                    <?php $model2 =ReportDetail::model();?>
                    <?php
                    $str='order_id,species,weight';
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
    $(function() {
            var $date=$('#<?php echo get_class($model);?>_reporttime');
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
    var deleteUrl = '<?php echo $this->createUrl('ReportDetail/delete', array('id' => 'ID')); ?>';
    function updateDetail(id=0){
        saveFormDate()
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


