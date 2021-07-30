<div class="box">
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create'); ?>"><i class="fa fa-plus"></i>添加单位</a>
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

                <label style="margin-right:10px;">
                    <span>操作时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>

                <?php
                $list=BaseCode::model()->getByType('pass_fail');
                {?>
                <label style="margin-right:20px;">
                    <span>是否通过审核：</span>
                    <select  class="singleSelect" style="width: 130px;" name="state">
                        <option value="">请选择</option>
                        <?php foreach($list as $v){?>
                            <option value="<?php echo $v->f_code;?>"<?php if(Yii::app()->request->getParam('state')==$v->f_code){?>selected<?php }?>><?php echo $v->f_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <?php }?>

                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>

                    <th><?php echo $model->getAttributeLabel('id'); ?></th>
                    <th><?php echo $model->getAttributeLabel('time'); ?></th>
                    <th><?php echo $model->getAttributeLabel('fisherman_name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('fisherman_phonenum'); ?></th>
                    <th><?php echo $model->getAttributeLabel('fisherman_idnum'); ?></th>
                    <th><?php echo $model->getAttributeLabel('picture_idnum_front'); ?></th>
                    <th><?php echo $model->getAttributeLabel('picture_idnum_back'); ?></th>
                    <th><?php echo $model->getAttributeLabel('boat_name'); ?></th>
                    
                    <th><?php echo $model->getAttributeLabel('picture_of_boat'); ?></th>
                    <th><?php echo $model->getAttributeLabel('picture_certificate_boat'); ?></th>
                    <th><?php echo $model->getAttributeLabel('valid_time_boat'); ?></th>
                    
                    <th><?php echo $model->getAttributeLabel('picture_certificate_catch'); ?></th>
                    <th><?php echo $model->getAttributeLabel('valid_time_catch'); ?></th>

                    <th><?php echo $model->getAttributeLabel('oil'); ?></th>
                    <th><?php echo $model->getAttributeLabel('company'); ?></th>
                    <th><?php echo $model->getAttributeLabel('state'); ?></th>
                
                    
        

                    <th><?php echo $model->getAttributeLabel('longitude'); ?></th>
                    <th><?php echo $model->getAttributeLabel('latitude'); ?></th> 




                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->id; ?></td>
                        <td style='text-align: center;'><?php echo $v->time; ?></td>
                        <td style='text-align: center;'><?php echo $v->fisherman_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->fisherman_phonenum; ?></td>
                        <td style='text-align: center;'><?php echo $v->fisherman_idnum; ?></td>
                        <td style='text-align: center;'><?php echo show_pic($v->picture_idnum_front); ?></td>
                        <td style='text-align: center;'><?php echo show_pic($v->picture_idnum_back); ?></td>
                        <td style='text-align: center;'><?php echo $v->boat_name; ?></td>
                        <td style='text-align: center;'><?php echo show_pic($v->picture_of_boat); ?></td>
                        <td style='text-align: center;'><?php echo show_pic($v->picture_certificate_boat); ?></td>
                        <td style='text-align: center;'><?php echo $v->valid_time_boat; ?></td>
                        <td style='text-align: center;'><?php echo show_pic($v->picture_certificate_catch); ?></td>
                        <td style='text-align: center;'><?php echo $v->valid_time_catch; ?></td>
                        <td style='text-align: center;'><?php echo $v->oil; ?></td>
                        <td style='text-align: center;'><?php echo $v->company; ?></td>
                        <td style='text-align: center;'><?php echo $v->state; ?></td>

                        <td style='text-align: center;'><?php echo $v->longitude; ?></td>
                        <td style='text-align: center;'><?php echo $v->latitude; ?></td>



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

        
    var $start_date=$('#start_date');
    var $end_date=$('#end_date');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });


</script>


