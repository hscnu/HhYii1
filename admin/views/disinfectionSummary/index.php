<div class="box">
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
                    <input style="width:200px;" class="input-text" type="text" name="keywords"
                           value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                </label>
                <label style="margin-right:10px;">
                    <span>选择汇总时间段：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                    <span>选择消毒中心</span>
                    <select name="disinfect_center" id="disinfect_center">
                        <option value="" selected></option>
                        <?php foreach (DisinfectionCenter::model()->getAllName() as $v ){?>
                        <option value="<?php echo $v->name?>"><?php echo $v->name?></option>
                        <?php }?>
                    </select>

                    <a class="btn btn-green" href="javascript:;" onclick="createSummary();">生成</a>
                </label>

            </form>

        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <?php
                    $str='start_date,end_date,restaurant_name,disinfection_center_name,total_price';
                    echo $model->gridHead($str); ?>
                    <td>操作</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr>

                        <?php echo $v->gridRow($str); ?>
                        <td>
                            <button class="btn" type="button" onclick="openDetail(<?php echo $v->id;?>);">查看明细</button>
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

    function createSummary(){
        var $sd=$('#start_date').val();
        var $ed=$('#end_date').val();
        var $dc=$('#disinfect_center').val();
        //console.log($sd);
        if ($sd==''||$ed==''||$dc=='') {
            alert('请选择完整时间段和消毒中心');
            return;
        }
        var url = '<?php echo $this->createUrl('CreateSummary', array()); ?>'+'&start_date='+$sd+'&end_date='+$ed+'&disinfect_center='+$dc;
        $.ajax({
            url:url,
            type:'post',
            success: function(data){
                //console.log(data);
                var obj = JSON.parse(data);
                //console.log(obj.data);
                if(obj.data===true){
                    alert('没有记录');
                    we.reload();
                }
                else{
                    alert('生成成功！');
                    we.reload();
                }
            },
        })
    }

    function openDetail(order_id=0){
        url = '<?php echo $this->createUrl("OpenSummaryDetail");?>'
        url += '&order_id='+order_id;
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'openDetail',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:'汇总明细',
            close: function () {
                //redirect = '<?php //echo str_replace('create','update',Yii::app()->request->getUrl())?>//'
                //redirect+='&id='+'<?php //echo $model->id;?>//'
                //window.location.href = redirect;
            }
        });
    };
</script>
