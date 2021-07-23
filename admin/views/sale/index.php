<div class="box">
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),' 添加'); ?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i> 刷新</a>
            <?php  if($views=='拍卖录入') echo show_command('批删除','',' 删除'); ?>
            <?php if($views=='拍卖审批') echo show_command('批上架','',' 批量上架'); ?>

        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords"
                           value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                </label>

                <?php
                $list=BaseCode::model()->getByType('yes_no');
                if ($views =='拍卖审批'){?>
                <label style="margin-right:20px;">
                    <span>是否审批：</span>
                    <select  class="singleSelect" style="width: 130px;" name="is_putout">
                        <option value="">请选择</option>
                        <?php foreach($list as $v){?>
                            <option value="<?php echo $v->f_code;?>"<?php if(Yii::app()->request->getParam('is_putout')==$v->f_code){?>selected<?php }?>>
                                <?php echo $v->f_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <?php }?>
                <input type="hidden" id="oper"  name="oper" value="888">
                <button class="btn btn-blue" type="submit">查询</button>
                <?php if($views=='拍卖审批'){ ?>
                <button class="btn btn-blue"  onclick="$('#oper').val('putOutAll');" type="submit">全部审批</button>
                <?php }?>


            </form>
        </div><!--box-search end-->
        <div class="box-table">
             <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>

                    <th><?php echo $model->getAttributeLabel('title'); ?></th>
                    <th><?php echo $model->getAttributeLabel('is_admit'); ?></th>
                    <th><?php echo $model->getAttributeLabel('saler_username'); ?></th>
                    <th><?php echo $model->getAttributeLabel('buyer_username'); ?></th>


                    <th><?php echo $model->getAttributeLabel('goods_name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('goods_weight'); ?></th>
                    <th><?php echo $model->getAttributeLabel('goods_info'); ?></th>
                    <th><?php echo $model->getAttributeLabel('start_time'); ?></th>
                    <th><?php echo $model->getAttributeLabel('end_time'); ?></th>
                    <th><?php echo $model->getAttributeLabel('start_price'); ?></th>
                    <th><?php echo $model->getAttributeLabel('this_record_time'); ?></th>
                    <th><?php echo $model->getAttributeLabel('buyer_price'); ?></th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->title; ?></td>
                        <td style='text-align: center;'><?php echo $v->is_admit; ?></td>
                        <td style='text-align: center;'><?php echo $v->saler_username; ?></td>
                        <td style='text-align: center;'><?php echo $v->buyer_username; ?></td>
                        <td><?php echo $v->goods_name; ?></td>
                        <td><?php echo $v->goods_weight; ?></td>
                        <td><?php echo $v->goods_info; ?></td>
                        <td><?php echo $v->start_time; ?></td>
                        <td><?php echo $v->end_time; ?></td>
                        <td><?php echo $v->start_price; ?></td>
                        <td><?php echo $v->this_record_time; ?></td>
                        <td><?php echo $v->buyer_price; ?></td>
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
    var putoutUrl = '<?php echo $this->createUrl('putout', array('id' => 'ID')); ?>';

</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        $('.singleSelect').select2();

    });

    var putout = function(op, url) {
        //  we.overlay('show');
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