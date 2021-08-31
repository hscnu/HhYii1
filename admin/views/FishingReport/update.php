<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>更新信息</h1><span class="back"></span></div><!--box-title end-->

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
                        <td colspan="1"><?php echo $form->labelEx($model, 'title');?></td>
                        <td colspan="3" >
                            <?php echo $form->textField($model, 'title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'title', $htmlOptions = array());?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'name'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="1"> <?php echo $form->labelEx($model, 'boat_id'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'boat_id', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'boat_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'reporttime'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'reporttime', array('class' => 'input-text','value'=>Date('Y-m-d'))); ?>
                            <?php echo $form->error($model, 'reporttime', $htmlOptions = array()); ?>
                        </td>
                    </tr
                    >
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'fishingtime');?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'fishingtime', array('class' => 'Wdate','style'=>'width:105px;','readonly' => true));?>
                            <?php echo $form->error($model, 'fishingtime', $htmlOptions = array());?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'remark'); ?></td>
                        <td colspan="3" > <?php echo $form->textArea($model, 'remark',  array('class' => 'input-text', 'style'=>'width:90%;height:35px','maxlength' => '100','placeholder'=>"本栏目限填100字"));?>
                            <?php echo $form->error($model, 'remark', $htmlOptions = array());?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'image'); ?></td>
                        <td colspan="3" ><button class="btn" type="button" onclick="chooseImg()">选择图片</button>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end   style="display:block;"-->
        </div><!--box-detail-bd end-->

        <div class="box-table">
            <button class="btn btn-green" style="float: right;margin:5px" type="button" onclick="updateDetail();">+添加</button>
            <table class="list">
                <thead>
                <tr>
                    <th style='text-align: center;'>序号</th>
                    <?php $model2 =ReportDetail::model();?>
                    <?php
                    $str='code,species,unit,number';
                    echo $model2->gridHead($str); ?>
                    <th style='text-align: center;'>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php $index=1; ?>
                <?php
                if(isset($detailList))
                    foreach ($detailList as $v) { ?>
                        <tr>
                            <td style='text-align: center;'><?php echo $index++; ?></td>
                            <?php echo $v->gridRow($str); ?>
                            <td style='text-align: center;'>
                                <button class="btn" type="button" onclick="updateDetail(<?php echo $v->id;?>);">编辑</button>
                                <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id; ?>', deleteUrl);"
                                   title="删除">删除</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
<!--
        <table>
            <div class="golf">
                <div class="photo"><img src="static/admin/img/trash.png"></div>
                <div class="intro">
                    <h3>高尔夫</h3>
                    <p>高尔夫球运动是一项健康、绿色、快乐、回归自然的体育运动，打高尔夫球能让人体验挑战与激情，实现人与自然的和谐。人与人礼貌谦让的良好运动精神，是高尔夫球运动的精髓所在。山东的高尔夫球场近30家，全部是按国际标准建造的，场内服务功能及设施完备，是比赛、会议、旅游休闲、商务于一体的度假场所，来山东打高尔夫球定会让您亲身体验到高尔夫应享的尊贵服务。
                    </p>
                </div>
            </div>
        </table>
-->
        </div>
    </div>
    <div class="box-detail-submit">
        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
        <button class="btn" type="button" onclick="we.back();">返回</button>
    </div>
    <?php $this->endWidget(); ?>
</div>
</div>

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
            height:'90%',
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
<style>
.photo{
float:left;
width:25%;
}
.intro{
float:right;
width:25%;
}
</style>
<script>


    function chooseImg(){
        url = '<?php echo $this->createUrl("OpenDialogImg");?>'+'&orderId='+'<?php echo $model->id?>'
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'chooseImg',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:'选择图片',
            close: function () {
                if($.dialog.data('img')>0){
                    s1='<?php echo $this->createUrl('changeOrderImg')?>'
                    s1=s1+'&oId='+'<?php echo $model->id?>'
                    s1=s1+'&img='+$.dialog.data('img')
                    $.ajax({
                        type: 'get',
                        url: s1,
                        dataType: 'json',
                        success: function(data){
                            we.reload()
                        },

                    });
                }
            }

        });
    };

</script



