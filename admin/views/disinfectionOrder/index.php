<div class="box">
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create'); ?>"><i class="fa fa-plus"></i>申请订单</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

            <a style="display:none;" id="j-delete" class="btn" href="javascript:;"
               onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i
                        class="fa fa-trash-o"></i>删除</a>

        </div><!--box-header end-->
        <!--  导航栏-->


        <!--  导航栏end-->
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
                           name="start_date" value="<?php echo $start_date_search?$start_date_search:''//Date('Y-m-d') ?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>

                    <th><?php echo $model->getAttributeLabel('restaurant_name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('disinfection_name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('date'); ?></th>

                    <th><?php echo $model->getAttributeLabel('state'); ?></th>
                    <th><?php echo $model->getAttributeLabel('complete_time'); ?></th>


                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;'><?php echo $v->restaurant_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->disinfection_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->date; ?></td>

                        <td style='text-align: center;'><?php echo $model->getCHName($v->state); ?></td>
                        <td style='text-align: center;'><?php echo $v->complete_time; ?></td>

                        <td>
                            <?php {?>
                                <button class="btn" type="button" onclick="chooseShr(<?php echo $v->id;?>);">查看细则</button>
                            <?php }?>

                            <!--                            <a class="btn btn-blue" href="--><?php //echo $this->createUrl('ChangeState', array('id' => $v->id)); ?><!--"-->
                            <!--  状态改变                             >提交</a>-->
                            <?php echo $this->chge_state_btn($v,'提交','Index_appoint')?>
                            <?php echo $this->chge_state_btn($v,'审核通过','index_appoint_finish')?>
                            <?php echo $this->chge_state_btn($v,'签收','Index_wait_sign')?>
                            <!-- 状态改变end                           -->
                            <!--                            <a class="btn" href="--><?php //echo $this->createUrl('update', array('id' => $v->id)); ?><!--"-->
                            <!--                               title="编辑"><i class="fa fa-edit"></i></a>-->
                            <?php echo $this->edit_btn($v)?>
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
<!--日期搜索-->
<script>
    var $start_date=$('#start_date');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});})
</script>

<!--日期搜索end-->
<!--查看明细-->
<script>
    function chooseShr(id){
        var url = '<?php echo $this->createUrl("OpenDialogOrder");?>&Id='+id;
        //url=url+'&Id='+id;
        //console.log(url);
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'chooseShr',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:'查看细则',
            close: function () {
                if($.dialog.data('id')>0){
                    s1='<?php echo $this->createUrl('GetOrderDetails')?>'
                    s1=s1+'&shrId='+$.dialog.data('id')+'&oId='+id
                    $.ajax({
                        type: 'get',
                        url: s1,
                        dataType: 'json',
                        success: function(data){
                            we.reload()
                        },

                    });
                }
            }

        });
    };
</script>
<!--查看明细end-->
