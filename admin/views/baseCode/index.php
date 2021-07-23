


<div class="box">
    <div class="box-title c">
        <h2><i class="fa fa-table"></i> 当前界面：基本数据维护》
            <span style="color:DodgerBlue">基本数据</span></h2>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create'); ?>"><i class="fa fa-plus"></i>添加</a>
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


              <?php  $allType=BaseCode::model()->getAllType();?>
                <label style="margin-right:20px;">
                    <span>列表类型：</span>
                    <select name="fType" class="singleSelect" style="width: 130px">
                        <option value="">请选择</option>
                        <?php foreach($allType as $v){?>
                            <option value="<?php echo $v->f_type;?>"><?php echo $v->f_type_CN;?></option>
                        <?php }?>
                    </select>
                </label>

<input type="hidden" id="oper" name="oper" value="1212123">
    <button class="btn btn-blue" onclick="$('#oper').val('search');" type="submit">查询</button>
    <button class="btn btn-blue" onclick="$('#oper').val('excel');" type="submit">导出</button>
    <a href='<?php echo $xls;?>' ><?php echo $xls ?"点击下载导出表" : ""; ?></a>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('f_name'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('f_group'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('f_type'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('f_type_CN'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('f_order'); ?></th>
                    <th style='text-align: center;'>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><?php echo $v->f_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->f_group; ?></td>
                        <td style='text-align: center;'><?php echo $v->f_type; ?></td>
                        <td style='text-align: center;'><?php echo $v->f_type_CN; ?></td>
                        <td style='text-align: center;'><?php echo $v->f_order; ?></td>
                        <td style='text-align: center;'>
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


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        $('.singleSelect').select2();

    });

</script>
<style>
    .singleSelect{
        width: 130px;
    }
</style>