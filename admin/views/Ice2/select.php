<div class="box">
    <div class="box-content">
        <div class="box-header">
<!--            <a class="btn" href="--><?php //echo $this->createUrl('create'); ?><!--"><i class="fa fa-plus"></i>添加用户</a>-->
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

<!--            <a style="display:none;" id="j-delete" class="btn" href="javascript:;"-->
<!--               onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i-->
<!--                        class="fa fa-trash-o"></i>删除</a>-->

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
<!--                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>-->
                    <th><?php echo $model->getAttributeLabel('userId'); ?></th>
                    <th><?php echo $model->getAttributeLabel('TCNAME'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr  data-id="<?php echo $v->userId;?>"  >
<!--                        <td class="check check-item"><input class="input-check" type="checkbox" value="--><?php //echo CHtml::encode($v->userId); ?><!--"></td>-->
                        <td style='text-align: center;'><?php echo $v->userId; ?></td>
                        <td style='text-align: center;'><?php echo $v->TCNAME; ?></td>
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
    $(function(){
        let api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        api.button(
            {
                name: '取消'
            }
        );
        $('.box-table tbody tr').on('click', function(){
            console.log($(this).attr('data-id'))
            if($(this).attr('data-id')){
                $.dialog.data('id',$(this).attr('data-id'));
                $.dialog.close();
            }
        });
    });
</script>

