
<div class="box">
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

            <a style="display:none;" id="j-delete" class="btn" href="javascript:;"
               onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i
                    class="fa fa-trash-o"></i>删除</a>

            <div class="box-detail-tab box-detail-tab mt15">
                <ul class="c">
                    <?php $action=strtolower(Yii::app()->controller->getAction()->id);?>
                    <li<?php if($action=='index_confirm_deliver'){?> class="current"<?php }?>>
                        <a href="<?php echo $this->createUrl('Ice/index_confirm_deliver');?>">待确认<?php echo '('.$examine_logisticsCount.')'?></a>
                    </li>
                    <li<?php if($action=='index_wait_deliver'){?> class="current"<?php }?>>
                        <a href="<?php echo $this->createUrl('Ice/index_wait_deliver');?>">待配送<?php echo '('.$wait_deliver_Count.')'?></a>
                    </li>
                    <li<?php if($action=='index_delivering'){?> class="current"<?php }?>>
                        <a href="<?php echo $this->createUrl('Ice/index_delivering');?>">配送中<?php echo '('.$delivering_Count.')'?></a>
                    </li>
                    <li<?php if($action=='index_finish_deliver'){?> class="current"<?php }?>>
                        <a href="<?php echo $this->createUrl('Ice/index_finish_deliver');?>">已完成<?php echo '('.$finishCount.')'?></a>
                    </li>
                </ul>
            </div>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords"
                           value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->

        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>

                    <th width="6%"><?php echo $model->getAttributeLabel('order_id'); ?></th>
                    <th width="15%"><?php echo $model->getAttributeLabel('title'); ?></th>
                    <th width="8%"><?php echo $model->getAttributeLabel('fishing_boat'); ?></th>
                    <th width="11%"><?php echo $model->getAttributeLabel('order_time'); ?></th>
                    <th width="24%"><?php echo $model->getAttributeLabel('order_destination'); ?></th>
                    <th width="20%"><?php echo $model->getAttributeLabel('order_remark'); ?></th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->order_id; ?></td>
                        <td style='text-align: center;'><?php echo $v->title; ?></td>
                        <td style='text-align: center;'><?php echo $v->fishing_boat; ?></td>
                        <td style='text-align: center;'><?php echo $v->order_time; ?></td>
                        <td style='text-align: center;'><?php echo $v->order_destination; ?></td>
                        <td style='text-align: center;'><?php echo $v->order_remark; ?></td>
                        <td>
                            <button class="btn" type="button" onclick="showLocation(<?php echo $v->id;?>);">定位</button>
                            <?php echo $this->chge_state_btn($v,'确认','index_confirm_deliver')?>
                            <?php echo $this->chge_state_btn($v,'开始配送','index_wait_deliver')?>
                            <?php echo $this->chge_state_btn($v,'确认收货','index_delivering')?>
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

    //按键定位
    function showLocation(id){
        url = '<?php echo $this->createUrl("ShowMap");?>'
        url=url+'&oId='+id
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'showlocation',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:'定位详情',
        });
    };

</script>