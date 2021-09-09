
<div class="box">
    <div class="box-content">
        <div class="box-header">
            <button class="btn btn-blue" type="button" onclick="chooseDeliverymen();">添加送冰员</button>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

            <a style="display:none;" id="j-delete" class="btn" href="javascript:;"
               onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i
                        class="fa fa-trash-o"></i>删除</a>


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
                    <th width="5%" class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>

                    <th width="20%"><?php echo $model->getAttributeLabel('deliver_id'); ?></th>
                    <th width="20%"><?php echo $model->getAttributeLabel('name'); ?></th>
                    <th width="20%"><?php echo $model->getAttributeLabel('tel'); ?></th>
                    <th width="35%">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->deliver_id; ?></td>
                        <td style='text-align: center;'><?php echo $v->name; ?></td>
                        <td style='text-align: center;'><?php echo $v->tel; ?></td>
                        <td>
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
    var deleteUrl = '<?php echo $this->createUrl('DeliveryMen/delete', array('id' => 'ID')); ?>';
</script>
<script>
    function chooseDeliverymen(){
        url = '<?php echo $this->createUrl("OpenDialogShr");?>'
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'chooseShr',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:'选择送冰员',
            close: function () {
                if($.dialog.data('id')>0){
                    s1='<?php echo $this->createUrl('AddDeliverymen')?>'
                    s1=s1+'&shrId='+$.dialog.data('id')
                    $.ajax({
                        type: 'get',
                        url: s1,
                        dataType: 'json',
                        success: function(data){
                            alert('成功添加');
                            we.reload()
                        },
                    });
                }
            }

        });
    };
</script>