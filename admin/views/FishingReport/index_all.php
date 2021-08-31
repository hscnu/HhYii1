<div class="box">
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </div><!--box-header end-->

        <div class="box-detail-tab box-detail-tab mt15">
            <ul class="c">
                <?php $action=strtolower(Yii::app()->controller->getAction()->id);?>
                <li<?php if($action=='index_all'){?> class="current"<?php }?>>
                    <a href="<?php echo $this->createUrl('Fishingreport/index_all');?>">已审核通过</a>
                </li>
            </ul>
        </div><!--box-detail-tab end-->

        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords"
                           value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                </label>

                <label style="margin-right:10px;">
                    <span>上报日期：</span>
                    <?php $start_date_search= Yii::app()->request->getParam('start_date');?>
                    <input style="width:120px;" class="input-text" type="text" id="start_date"
                           name="start_date" value="<?php echo $start_date_search?$start_date_search:Date('Y-m-d') ?>">
                    <span>-</span>
                    <?php $end_date_search= Yii::app()->request->getParam('end_date');?>
                    <input style="width:120px;" class="input-text" type="text" id="end_date"
                           name="end_date" value="<?php echo $end_date_search?$end_date_search:Date('Y-m-d') ?>">
                </label>


                <button class="btn btn-blue" type="submit">查询</button>
                <br>

            </form>
            </form>
            </form>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th style='text-align: center;'>序号</th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('report_id'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('title'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('name'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('boat_id'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('reporttime'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('count'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('remark'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('opinion'); ?></th>
                    <th style='text-align: center;'>操作</th>
                </tr>
                </thead>
                <?php $index=1; ?>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><?php echo $index++; ?></td>
                        <td style='text-align: center;'><?php echo $v->report_id; ?></td>
                        <td style='text-align: center;'><?php echo $v->title; ?></td>
                        <td style='text-align: center;'><?php echo $v->name; ?></td>
                        <td style='text-align: center;'><?php echo $v->boat_id; ?></td>
                        <td style='text-align: center;'><?php echo $v->reporttime; ?></td>
                        <td style='text-align: center;'><?php echo $v->count; ?></td>
                        <td style='text-align: center;'><?php echo $v->remark; ?></td>
                        <td style='text-align: center;'><?php echo $v->opinion; ?></td>
                        <td style='text-align: center;'>
                            <button class="btn" type="button" onclick="AuditDetail3(<?php echo $v->id;?>);">查看</button>
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
    var plshUrl = '<?php echo $this->createUrl('plsh', array('id' => 'ID')); ?>';
</script>
<script>
    var $start_date=$('#start_date');
    var $end_date=$('#end_date');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.singleSelect').select2();

    });

    var plsh = function(op, url) {
        console.log(123)
        console.log(op);
        url = url.replace(/ID/, op);
        var $this = $(op);
        var sortid = parseInt($this.val());
        $.ajax({
            type: 'get',
            url: url,
            data: {sortid: sortid},
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };

</script>

<style>
    .singleSelect{
        width: 130px;
    }
</style>
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
    function AuditDetail3(id=0){
        url = '<?php echo $this->createUrl("UpdateVerify3");?>'
        url +='&id='+id
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'updateDetail',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:"捕鱼上报查看",
            close: function () {
                redirect = '<?php echo str_replace('create','update',Yii::app()->request->getUrl())?>'
                redirect+='&id='+'<?php echo $model->id;?>'
                window.location.href = redirect;
            }
        });
    };
</script>