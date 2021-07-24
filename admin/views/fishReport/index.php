<div class="box">
        <div class="box-title c">
        <h2><i class="fa fa-table"></i> 当前界面：捕鱼》<span style="color:DodgerBlue">捕鱼上报</span></h2>
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


    <label style="margin-right:10px;">
    <span>操作时间：</span>
    <?php $start_date_search= Yii::app()->request->getParam('start_date');?>
    <input style="width:120px;" class="input-text" type="text" id="start_date"
       name="start_date" value="<?php echo $start_date_search?$start_date_search:Date('Y-m-d') ?>">
    </label>

                <?php
                $list=BaseCode::model()->getByType('check');
                   {?>
                <label style="margin-right:20px;">
                    <span>是否审核：</span>
                    <select  class="singleSelect" style="width: 130px;" name="state">
                        <option value="">请选择</option>
                        <?php
                         $state=Yii::app()->request->getParam('state');
                         $state=$state?$state:'2';
                         foreach($list as $v){?>
                            <option value="<?php echo $v->f_code;?>"<?php if($state==$v->f_code){?>selected<?php }?>><?php echo $v->f_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <?php }?>
                
              <input type="hidden" id="oper"  name="oper" value="888">
              <button class="btn btn-blue" type="submit">查询</button>
                <?php { ?>
                <button class="btn btn-blue"  onclick="$('#oper').val('checkall');" type="submit">全部审核</button>
                <?php }?>
             
            </form>   
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>

                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('number'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('company'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('name'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('telephone'); ?></th>

                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('fishingtime'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('reporttime'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('count'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('state'); ?></th>
                    <th style='text-align: center;'><?php echo $model->getAttributeLabel('reason'); ?></th>
            
                    <th style='text-align: center;'>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->number; ?></td>
                        <td style='text-align: center;'><?php echo $v->company; ?></td>
                        <td style='text-align: center;'><?php echo $v->name; ?></td>
                        <td style='text-align: center;'><?php echo $v->telephone; ?></td>
   
                        <td style='text-align: center;'><?php echo $v->fishingtime; ?></td>
                        <td style='text-align: center;'><?php echo $v->reporttime; ?></td>
                        <td style='text-align: center;'><?php echo $v->count; ?></td>

                        <td style='text-align: center;'><?php echo $v->state==1?'已审核':'待审核'; ?></td>

                        <td style='text-align: center;'><?php echo $v->reason; ?></td>
                        

                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id' => $v->id)); ?>"
                               title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id; ?>', deleteUrl);"
                               title="删除"><i class="fa fa-trash-o"></i></a>
                            <a class="btn" href="<?php echo $this->createUrl('shenhe',array('id' => $v->id)); ?>"
                               title="审核"><i class="fa fa-plus-square"></i></a>
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
    $start_date.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>





