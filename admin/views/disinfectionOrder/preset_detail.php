<div class="box">
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <input style="width:200px;" class="input-text" type="text" id="number" placeholder="请输入餐具数量">
            <a style="display:none;" class="btn btn-green" id="j-delete" class="btn" href="javascript:;"
               onclick="presetDetails(we.checkval('.check-item input:checked'));"><i
                    class="fa fa-plus"></i>添加</a>

        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>

                    <th><?php echo $model->getAttributeLabel('code'); ?></th>
                    <th><?php echo $model->getAttributeLabel('type'); ?></th>
                    <th><?php echo $model->getAttributeLabel('name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('unit'); ?></th>
                    <th><?php echo $model->getAttributeLabel('cost'); ?></th>

                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><?php echo $v->code; ?></td>
                        <td style='text-align: center;'><?php echo $v->type; ?></td>
                        <td style='text-align: center;'><?php echo $v->name; ?></td>
                        <td style='text-align: center;'><?php echo $v->unit; ?></td>
                        <td style='text-align: center;'><?php echo $v->cost; ?></td>

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
   function presetDetails(tablewareIds){
       var number=$('#number').val();
       var url='<?php echo $this->createUrl("SavePreset",array('order_id'=>$order_id));?>'
       url += '&tablewareIds='+tablewareIds;
       url += '&number='+number;
       $.dialog.confirm('确定生成预设？', function () {
           $.ajax({
               type: 'get',
               url: url,
               dataType: 'json',
               success: function(data){
                   alert('生成成功！');
                   let api = $.dialog.open.api;
                   api.close();
               },
           });
       }, function () {
       });
   }
</script>
<script>
    $(function(){
        let api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        api.button(
            {
                name: '取消'
            }
        );
    });
</script>
