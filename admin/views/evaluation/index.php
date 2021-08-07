<div class="box">
    <div class="box-title" style="font-size: 28px;">
        <b>评价管理</b>
    </div>
    <div class="box-detail-tab box-detail-tab mt15">
        <ul class="c">
            <?php $action=strtolower(Yii::app()->controller->getAction()->id);?>
            <li>
                <a href="<?php echo $this->createUrl('restaurant/index');?>">酒楼审核</a>
            </li>
            <li<?php if($action=='index'){?> class="current"<?php }?>>
                <a href="<?php echo $this->createUrl('evaluation/index');?>">评价审核</a>
            </li>
        </ul>
    </div><!--box-detail-tab end-->
    <div class="box-content">
        <div class="box-header">
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
                    <input style="width:200px;height: 20px;line-height: 20px" type="text" name="keywords" list ="typelist" placeholder="请选择"
                           value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                    <datalist id="typelist">
                        <?php $a = Restaurant::model()->findAll(array(
                        'select'=> array('r_name'),
                        'order' => 'r_name DESC',));
                        foreach($a as $obj){ ?>
                        <option  style="width:120px;height:22px;overflow:auto;line-height:22px;" name="keywords">
                            <?php echo $obj->attributes['r_name'] ?>
                        </option>
                        <?php } ?>
                    </datalist>

                <span style="position: relative;top:0px;">操作时间：</span>
                <input style="width:120px;position: relative;top:0px;" class="input-text" type="text" id="eval_time" autocomplete="off"
                       name="eval_time" value="<?php echo Yii::app()->request->getParam('eval_time');?>" >
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>

                    <th><?php echo $model->getAttributeLabel('eval_rest'); ?></th>
                    <th><?php echo $model->getAttributeLabel('eval_time'); ?></th>
                    <th><?php echo $model->getAttributeLabel('eval_star'); ?></th>
                    <th><?php echo $model->getAttributeLabel('eval_image'); ?></th>
                    <th><?php echo $model->getAttributeLabel('eval_content'); ?></th>
                    <th><?php echo $model->getAttributeLabel('evaluator'); ?></th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) {
                    ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><?php echo $v->eval_rest; ?></td>
                        <td style='text-align: center;'><?php echo $v->eval_time; ?></td>
                        <td style='text-align: center;'><?php echo $v->eval_star; ?></td>
                        <td style='text-align: center;width: 200px;'><?php echo show_picture($v->eval_image); ?></td>
                        <td style='text-align: center;'><?php echo $v->eval_content; ?></td>
                        <td style='text-align: center;'><?php echo $v->evaluator; ?></td>
                        <?php if ($v->eval_ispass == 1){?>
                        <td>通过</td>
                            <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id' => $v->id)); ?>"
                               title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" onClick="return confirm('确定退回?');" href="<?php echo $this->createUrl('return', array('id' => $v->id)); ?>"
                               title="退回"><i class="fa fa-times"></i></a>
                            </td>
                        <?php }
                        else{?>
                        <td>未通过</td>
                            <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id' => $v->id)); ?>"
                               title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" onClick="return confirm('确定通过?');" href="<?php echo $this->createUrl('pass', array('id' => $v->id)); ?>"
                               title="通过"><i class="fa fa-check"></i></a>
                            <a class="btn" onClick="return confirm('确定退回?');" href="<?php echo $this->createUrl('return', array('id' => $v->id)); ?>"
                               title="退回"><i class="fa fa-times"></i></a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php
                        } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
</script>
<script>
    var $eval_time=$('#eval_time');
    $eval_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'})
    });
</script>
