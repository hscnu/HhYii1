
<div class="box">
    <div class="box-title c">
        <h2><i class="fa fa-table"></i> 当前界面：社区单位》意向入驻管理》
            <span style="color:DodgerBlue">添加渔船</span></h2>
        <a class="btn" href="<?php echo $this->createUrl('create'); ?>"><i class="fa fa-plus"></i>添加</a>
        <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

        <a style="display:none;" id="j-delete" class="btn" href="javascript:;"
           onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i
                    class="fa fa-trash-o"></i>删除</a>
        <form action="<?php echo Yii::app()->request->url; ?>" method="get">
            <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
            <label style="margin-right:10px;">
                <span>申请日期：</span>
                <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                <span>-</span>
                <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
            </label>
            <label style="margin-right:10px;">
                <span>关键字：</span>
                <input style="width:200px;" class="input-text" type="text" name="keywords"
                       value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
            </label>
            <button class="btn btn-blue" type="submit">查询</button>
        </form>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>

                    <th><?php echo $model->getAttributeLabel('boat_id'); ?></th>
                    <th><?php echo $model->getAttributeLabel('boat_name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('boat_type'); ?></th>
                    <th><?php echo $model->getAttributeLabel('affiliated_company'); ?></th>
                    <th><?php echo $model->getAttributeLabel('registered_captain_name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('captain_phone'); ?></th>
                    <th><?php echo $model->getAttributeLabel('gross_tonnage'); ?></th>
                    <th><?php echo $model->getAttributeLabel('state'); ?></th>

                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->boat_id; ?></td>
                        <td style='text-align: center;'><?php echo $v->boat_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->boat_type; ?></td>
                        <td><?php echo $v->affiliated_company; ?></td>
                        <td><?php echo $v->registered_captain_name; ?></td>
                        <td><?php echo $v->captain_phone; ?></td>
                        <td><?php echo $v->gross_tonnage; ?></td>
                        <td><?php echo $v->state; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id' => $v->id)); ?>"
                               title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id; ?>', deleteUrl);"
                               title="删除"><i class="fa fa-trash-o"></i></a>
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

</script>
<style>
    .singleSelect{
        width: 130px;
    }
</style>

