<div class="box">
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),' 添加'); ?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i> 刷新</a>
            <?php  if($views=='快递录入') echo show_command('批删除','',' 删除'); ?>
            <?php if($views=='快递上架') echo show_command('批上架','',' 批量上架'); ?>

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
                if ($views =='快递上架'){?>
                <label style="margin-right:20px;">
                    <span>是否上架：</span>
                    <select  class="singleSelect" style="width: 130px;" name="is_putout">
                        <option value="">请选择</option>
                        <?php foreach($list as $v){?>
                            <option value="<?php echo $v->f_code;?>"<?php if(Yii::app()->request->getParam('is_putout')==$v->f_code){?>selected<?php }?>><?php echo $v->f_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <?php }?>
                <input type="hidden" id="oper"  name="oper" value="888">
                <button class="btn btn-blue" type="submit">查询</button>
                <?php if($views=='快递上架'){ ?>
                <button class="btn btn-blue"  onclick="$('#oper').val('putOutAll');" type="submit">全部上架</button>
                <?php }?>


            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th><?php echo $model->getAttributeLabel('p_name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('c_name'); ?></th>
<!--                    <th>--><?php //echo $model->getAttributeLabel('p_picture'); ?><!--</th>-->
                    <?php if($views=='快递上架'){ ?>
                    <th><?php echo $model->getAttributeLabel('is_putout'); ?></th>
                    <?php }?>
                    <?php  if($time) echo '<th>'.$model->getAttributeLabel($time).'</th>'; ?>
                     <?php if($views=='等待代领') echo
                         '<th>'.$model->getAttributeLabel('dl_id').'</th>'.
                         '<th>'.$model->getAttributeLabel('au_code').'</th>'
                     ; ?>
                    <th><?php echo $model->getAttributeLabel('c_number'); ?></th>

                    <th><?php echo $model->getAttributeLabel('dl_switch'); ?></th>
                    <th><?php echo $model->getAttributeLabel('pick_state'); ?></th>
                    <th><?php echo $model->getAttributeLabel('help_state'); ?></th>
                    <th><?php echo $model->getAttributeLabel('confirm_receipt_state'); ?></th>

                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->p_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->c_name; ?></td>
<!--                        <td>--><?php //echo show_pic($v->p_picture) ?><!--</td>-->
                        <?php if($views=='快递上架'){ ?>
                        <td style='text-align: center;'><?php echo $v->is_putout==1?'是':'否'; ?></td>
                        <?php }?>

                        <?php if($time) echo'<td>'. $v->{$time}.'</td>'; ?>
                        <?php if($views=='等待代领') echo
                            '<td>'. $v->dl_id.'</td>'.
                            '<td>'. $v->au_code.'</td>'
                        ; ?>
                        <td style='text-align: center;'><?php echo $v->c_number; ?></td>

                        <td><?php echo $v->dl_switch?'允许':'禁止'; ?></td>
                        <td><?php echo $v->pick_state?'已取件':'未取件'; ?></td>
                        <td><?php echo $v->help_state?'已代领':'未代领'; ?></td>
                        <td><?php echo $v->confirm_receipt_state?'已确认':'未确认'; ?></td>


                        <td>

                            <?php
                            if($views=='我要代领') {
                                $str = str_replace('package', 'Io_package', $this->createUrl('ApplyDl2',
                                    array('pg_id' => $v->id,'userId'=>Yii::app()->session['user_id'])));
                                echo show_command('申请代领', $str);
                            }
                            elseif ($views=='快递上架'){?>
                                <a class="btn" href="<?php echo $this->createUrl('PutKd', array('id' => $v->id)); ?>"
                                   title="上架"><i class="fa fa-plus-square"></i></a>
                            <?php
                            }
                            ?>

                            <?php echo show_command('详情',$this->createUrl('update', array('id' => $v->id))); ?>
                            <?php echo show_command('删除',"'".$v->id."'"); ?>

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