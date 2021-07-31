<div class="box">
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

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
                    <th><?php echo $model->getAttributeLabel('product_name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('price'); ?></th>
                    <th><?php echo $model->getAttributeLabel('number'); ?></th>
                    <th><?php echo $model->getAttributeLabel('number_unit'); ?></th>
                    <th><?php echo $model->getAttributeLabel('supplier'); ?></th>
                    <th><?php echo $model->getAttributeLabel('trade_means'); ?></th>
                    <th><?php echo $model->getAttributeLabel('contact_details'); ?></th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->product_name; ?></td>
                        <td><?php echo $v->price; ?></td>
                        <td><?php echo $v->number; ?></td>
                        <td><?php echo $v->number_unit; ?></td>
                        <td><?php echo $v->supplier; ?></td>
                        <td><?php echo $v->trade_means; ?></td>
                        <td><?php echo $v->contact_details; ?></td>
                        <td>
<!--                            <a class="btn" href="--><?php //echo $this->createUrl('update', array('id' => $v->id)); ?><!--"-->
<!--                               title="编辑"><i class="fa fa-edit"></i></a>-->
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


