<div class="box">
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create'); ?>"><i class="fa fa-plus"></i>添加单位</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

            <a style="display:none;" id="j-delete" class="btn" href="javascript:;"
               onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i
                    class="fa fa-trash-o"></i>删除</a>

        </div><!--box-header end-->

        <div class="box-detail-tab box-detail-tab mt15">
            <ul class="c">
                <?php $action=strtolower(Yii::app()->controller->getAction()->id);?>

                <li<?php if($action=='index_appoint_wait'){?> class="current"<?php }?>>
                    <a href="<?php echo $this->createUrl('OnShelfInfo/index_appoint_wait');?>">待审核</a>
                </li>

                <li<?php if($action=='index_appoint_finish'){?> class="current"<?php }?>>
                    <a href="<?php echo $this->createUrl('OnShelfInfo/index_appoint_finish');?>">已审核</a>
                </li>

            </ul>
        </div>
        <!--box-detail-tab end-->




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
                    <span>申请上架日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date_apply" name="start_date_apply" value="<?php echo Yii::app()->request->getParam('start_date_apply');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date_apply" name="end_date_apply" value="<?php echo Yii::app()->request->getParam('end_date_apply');?>">
                </label>

                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->

        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th><?php echo $model->getAttributeLabel('apply_order'); ?></th>
                    <th><?php echo $model->getAttributeLabel('apply_date'); ?></th>
                    <th><?php echo $model->getAttributeLabel('apply_name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('state'); ?></th>
                    <th><?php echo $model->getAttributeLabel('operate_time'); ?></th>

                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->apply_order; ?></td>
                        <td style='text-align: center;'><?php echo $v->apply_date; ?></td>
                        <td><?php echo $v->apply_name; ?></td>
                        <td><?php echo $v->state; ?></td>
                        <td><?php echo $v->operate_time; ?></td>
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
    var $start_date=$('#start_date_apply');
    var $end_date=$('#end_date_apply');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>

