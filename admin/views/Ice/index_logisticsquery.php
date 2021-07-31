
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
                    <li<?php if($action=='logisticsquery_fishery_examined'){?> class="current"<?php }?>>
                        <a href="<?php echo $this->createUrl('Ice/logisticsquery_fishery_examined');?>">待审核<?php echo '('.$examine_finishCount.')'?></a>
                    </li>
                    <li<?php if($action=='logisticsquery_logistics_examined'){?> class="current"<?php }?>>
                        <a href="<?php echo $this->createUrl('Ice/logisticsquery_logistics_examined');?>">已审核<?php echo '('.$examine_logisticsCount.')'?></a>
                    </li>
                    <li<?php if($action=='logisticsquery_assigned'){?> class="current"<?php }?>>
                        <a href="<?php echo $this->createUrl('Ice/logisticsquery_assigned');?>">已指派<?php echo '('.$wait_deliver_Count.')'?></a>
                    </li>
                    <li<?php if($action=='logisticsquery_confirmed'){?> class="current"<?php }?>>
                        <a href="<?php echo $this->createUrl('Ice/logisticsquery_confirmed');?>">派送中<?php echo '('.$delivering_Count.')'?></a>
                    </li>
                    <li<?php if($action=='logisticsquery_received'){?> class="current"<?php }?>>
                        <a href="<?php echo $this->createUrl('Ice/logisticsquery_received');?>">已完成<?php echo '('.$finishCount.')'?></a>
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
                    <th width="6%"><?php echo $model->getAttributeLabel('order_name'); ?></th>
                    <th width="8%"><?php echo $model->getAttributeLabel('order_tel'); ?></th>
                    <th width="22%"><?php echo $model->getAttributeLabel('order_destination'); ?></th>
                    <th width="11%"><?php echo $model->getAttributeLabel('order_time'); ?></th>
                    <th width="25%"><?php echo $model->getAttributeLabel('order_remark'); ?></th>
                    <th width="5%"><?php echo $model->getAttributeLabel('order_state'); ?></th>
                    <th width="17%">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->order_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->order_tel; ?></td>
                        <td style='text-align: center;'><?php echo $v->order_destination; ?></td>
                        <td style='text-align: center;'><?php echo $v->order_time; ?></td>
                        <td style='text-align: center;'><?php echo $v->order_remark; ?></td>
                        <td style='text-align: center;'><?php echo $v->order_state; ?></td>
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