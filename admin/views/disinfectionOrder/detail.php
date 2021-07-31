<div class="box">
    <div class="box-content">
        <div class="box-header">
            <!--            <a class="btn" href="--><?php //echo $this->createUrl('create'); ?><!--"><i class="fa fa-plus"></i>添加用户</a>-->
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a id = "csbt" class="btn btn-blue" href="javascript:;" onclick="changStatebtn();"><i class="fa fa-check-square"></i>通过审核</a>

        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <!-- <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords"
                           value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>-->
            </form>
        </div><!--box-search end-->

        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <?php
                    $str='title,restaurant_name,disinfection_name,complete_time,notes';
                    echo $order_model->gridHead($str); ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php echo $order_model->gridRow($str); ?>
                </tr>
                </tbody>
            </table>
        </div><!--box-table end-->

        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th><?php echo $model->getAttributeLabel('tableware_type'); ?></th>
                    <th><?php echo $model->getAttributeLabel('tableware_name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('unit'); ?></th>
                    <th><?php echo $model->getAttributeLabel('cost'); ?></th>
                    <th><?php echo $model->getAttributeLabel('number'); ?></th>
                    <th><?php echo $model->getAttributeLabel('total_cost'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) { ?>
                    <tr  data-id="<?php echo $v->id;?>"  >
                        <td style='text-align: center;'><?php echo $v->tableware_type; ?></td>
                        <td style='text-align: center;'><?php echo $v->tableware_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->unit; ?></td>
                        <td style='text-align: center;'><?php echo $v->cost; ?></td>
                        <td style='text-align: center;'><?php echo $v->number; ?></td>
                        <td style='text-align: center;'><?php echo $v->total_cost; ?></td>
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
    $(function(){
        let api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        api.button(
            {
                name: '取消'
            }
        );
        $('.box-table tbody tr').on('click', function(){
            console.log($(this).attr('data-id'))
            if($(this).attr('data-id')){
                $.dialog.data('id',$(this).attr('data-id'));
                $.dialog.close();
            }
        });
    });
</script>
<script>
    var nowView = '<?php echo $nowView;?>';
    var examineType = '<?php echo $examineType?>';
    var op=true;
    $(document).ready(function(){
        if(nowView!=='index_examine'){
            $("#csbt").hide();
        }
        if(nowView==='index_examine'){
            $("a.btn").click(function(){
                if(op){
                    alert('审核已通过');
                    $("#csbt").hide(100,"linear",function() {
                    });
                }
            });
        }
    });
    function changStatebtn(){
        var url1 = '<?php echo $this->createUrl("ChangeState",array('id' => $order_model->id,'Now_state'=>'内部审核通过'));?>';
        var url2 = '<?php echo $this->createUrl("ChangeState",array('id' => $order_model->id,'Now_state'=>'外部审核通过'));?>';
        var url='';
        if(examineType==='I_examine'){
            url=url1;
        }
        else if(examineType==='F_examine'){
            url=url2;
        }
        else{
            alert('操作失败！');
            op=false;
        }
        //var url = examineType==='I_examine'?url1:url2;
        if(nowView==='index_examine'){
            $.ajax({
                url:url,
                type:'post',
                success: function(data){
                    we.close();
                },
            })
        }
    }
</script>
<script>
    $(document).ready(function(){
        $("a").load(function(){
            if(nowView!=='index_examine'){
                $("#csbt").hide();
            }
        });
    });
</script>


