<div class="box">
    <div class="box-content">
        <div class="box-header">
            <?php if($views=='捕鱼上报'){ ?>
                <a class="btn" href="<?php echo $this->createUrl('create'); ?>"><i class="fa fa-plus"></i>添加</a>
            <?php }?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <?php  if($views=='待审核')echo show_command('批审核','',' 批量审核'); ?>
            <?php if($views=='捕鱼上报')echo show_command('批删除','',' 删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords"
                           value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                </label>

                <label style="margin-right:10px;">
                    <span>上报时间：</span>
                    <?php $end_date_search= Yii::app()->request->getParam('end_date');?>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date"
                           name="end_date" value="<?php echo $end_date_search?$end_date_search:Date('Y-m-d') ?>">
                </label>

                <?php
                $list=BaseCodefish::model()->getByType('check');
                {?>
                    <label style="margin-right:20px;">
                        <span>是否审核：</span>
                        <select  class="singleSelect" style="width: 130px;" name="state">
                            <option value="">请选择</option>
                            <?php foreach($list as $v){?>
                                <option value="<?php echo $v->f_code;?>"<?php if(Yii::app()->request->getParam('state')==$v->f_code){?>selected<?php }?>><?php echo $v->f_name;?></option>
                            <?php }?>
                        </select>
                    </label>
                <?php }?>

                <input type="hidden" id="oper"  name="oper" value="888">
                <button class="btn btn-blue" type="submit">查询</button>
                <br>
                <?php if($views=='待审核'){ ?>
                    <button class="btn btn-blue"  onclick="$('#oper').val('checkall');" type="submit">全部审核通过</button>
                <?php }?>
            </form>
            </form>
            </form>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th style='text-align: center;'>序号</th>

                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('id'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('name'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('company'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('boatname'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('reporttime'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('fishingtime'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('remark'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('state'); ?></th>
                    <th style='text-align: center;'>操作</th>
                </tr>
                </thead>
                <?php $index=1; ?>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>

                        <td style='text-align: center;'><?php echo $index++; ?></td>

                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><?php echo $v->id; ?></td>
                        <td style='text-align: center;'><?php echo $v->name; ?></td>
                        <td style='text-align: center;'><?php echo $v->company; ?> </td>
                        <td style='text-align: center;'><?php echo $v->boatname; ?></td>
                        <td style='text-align: center;'><?php echo $v->reporttime; ?></td>
                        <td style='text-align: center;'><?php echo $v->fishingtime; ?></td>
                        <td style='text-align: center;'><?php echo $v->remark; ?></td>
                        <td style='text-align: center;'><?php echo $model->getStateName($v->state); ?></td>


                        <td style='text-align: center;'>

                            <a class="btn" href="<?php echo $this->createUrl('update', array('id' => $v->id)); ?>"
                               title="编辑"><i class="fa fa-edit"></i>编辑</a>

                            <?php if($views=='待审核'){ ?>
                                <a class="btn" onClick="return confirm('确定通过?');" href="<?php echo $this->createUrl('shenhe',array('id' => $v->id)); ?>"
                                   title="审核通过"><i class="fa fa-plus-square"></i>通过</a>
                            <?php }?>

                            <?php if($views=='待审核'){ ?>
                                <a class="btn" onClick="return confirm('确定退回?');" href="<?php echo $this->createUrl('shenhen',array('id' => $v->id)); ?>"
                                   title="审核不通过"><i class="fa fa-trash-o"></i>不通过</a>
                            <?php }?>

                            <?php if($views=='捕鱼上报'){ ?>
                                <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id; ?>', deleteUrl);"
                                   title="删除"><i class="fa fa-trash-o"></i>删除</a>
                            <?php }?>

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
    var plshUrl = '<?php echo $this->createUrl('plsh', array('id' => 'ID')); ?>';
</script>
<script>
    var $start_date=$('#start_date');
    var $end_date=$('#end_date');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        $('.singleSelect').select2();

    });

    var plsh = function(op, url) {
        console.log(123)
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








