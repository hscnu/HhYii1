<div class="box">
    <div class="box-content">
        <div class="box-header">
<!--         <a class="btn" href="--><?php //echo $this->createUrl('create'); ?><!--"><i class="fa fa-plus"></i>添加单位</a>-->
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

            <a style="display:none;" id="j-delete" class="btn" href="javascript:;"
               onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i
                        class="fa fa-trash-o"></i>删除</a>


        </div><!--box-header end-->
        <div class="box-detail-tab box-detail-tab mt15">
            <ul class="c">
                <?php $action=strtolower(Yii::app()->controller->getAction()->id);?>

                <li<?php if($action=='index_appoint_wait'){?> class="current"<?php }?>>
                    <a href="<?php echo $this->createUrl('ReportInfo/index_appoint_wait');?>">待审核<?php echo "(".$waitCount.")";?></a>
                </li>

                <li<?php if($action=='index_appoint_finish'){?> class="current"<?php }?>>
                    <a href="<?php echo $this->createUrl('ReportInfo/index_appoint_finish');?>">已审核<?php echo '('.$auditedCount.')';?></a>
                </li>

            </ul>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords"
                           value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                </label>
                <label style="margin-right:10px;">
                    <span>操作时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date_operate" name="start_date_operate" value="<?php echo Yii::app()->request->getParam('start_date_operate');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date_operate" name="end_date_operate" value="<?php echo Yii::app()->request->getParam('end_date_operate');?>">
                </label>

                <label style="margin-right:10px;">
                    <span>上报日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date_report" name="start_date_report" value="<?php echo Yii::app()->request->getParam('start_date_report');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date_report" name="end_date_report" value="<?php echo Yii::app()->request->getParam('end_date_report');?>">
                </label>

                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th style="text-align: center"><?php echo $model->getAttributeLabel('report_order'); ?></th>
                    <th style="text-align: center" width="15%"><?php echo $model->getAttributeLabel('report_date'); ?></th>
                    <th style="text-align: center"><?php echo $model->getAttributeLabel('reporter_name'); ?></th>
                    <th style="text-align: center"><?php echo $model->getAttributeLabel('operate_time'); ?></th>
                    <th style="text-align: center"><?php echo $model->getAttributeLabel('state'); ?></th>
                    <th style="text-align: center" width="20%"><?php echo $model->getAttributeLabel('audit_opinion'); ?></th>


                    <th style="text-align: center">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->report_order; ?></td>
                        <td style='text-align: center;'><?php echo $v->report_date; ?></td>
                        <td style="text-align: center"><?php echo $v->reporter_name; ?></td>
                        <td style="text-align: center"><?php echo $v->operate_time; ?></td>
                        <td style="text-align: center"><?php echo $v->state; ?></td>
                        <td style="text-align: center"><?php echo $v->audit_opinion; ?></td>

                        <td style="text-align: center">
                            <button class="btn" type="button" onclick="AuditDetail(<?php echo $v->id;?>);">审核</button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
    function AuditDetail(id=0){
        url = '<?php echo $this->createUrl("UpdateVerify");?>'
        url +='&id='+id
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'updateDetail',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:"产量上报审核界面",
            close: function () {
                redirect = '<?php echo str_replace('create','update',Yii::app()->request->getUrl())?>'
                redirect+='&id='+'<?php echo $model->id;?>'
                window.location.href = redirect;
            }
        });
    };
</script>
<script>
    var $start_date=$('#start_date_operate');
    var $end_date=$('#end_date_operate');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>
<script>
    var $start_date=$('#start_date_report');
    var $end_date=$('#end_date_report');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>
<script>

    function Return(id=0){

    }
</script>