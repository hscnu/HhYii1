<div class="box">
    <div class="box-content">
        <div class="box-header">

            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th><?php echo $model->getAttributeLabel('img'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr  data-img="<?php echo $v->img;?>"  >
                        <!--                        <td class="check check-item"><input class="input-check" type="checkbox" value="--><?php //echo CHtml::encode($v->userId); ?><!--"></td>-->
                        <td style='text-align: center;'><?php echo show_pic($model->img); echo $model->img;?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
<!--        <div class="box-page c">--><?php //$this->page($pages); ?><!--</div>-->
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
            if($(this).attr('data-img')){
                $.dialog.data('img',$(this).attr('data-img'));
                $.dialog.close();
            }
        });
    });
</script>



