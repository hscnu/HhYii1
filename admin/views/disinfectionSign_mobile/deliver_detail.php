<div class="box">
    <div class="box-content">

        <div class="box-header">
            <a style="display:none;" class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

            <a style="display:none;" id="j-delete" class="btn" href="javascript:;"
               onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i
                        class="fa fa-trash-o"></i>删除</a>
            <h1><?php echo $order_model->title?>明细</h1>
            <h1><?php echo $order_model->notes?></h1>
        </div><!--box-header end-->

        <!--  导航栏end-->

        <div><span>
            </span></div>
        <?php foreach ($arclist as $v){?>
            <div class="article-item">
                <div class="article-content">
                    <h4 class="article-title">
                        <?php echo $v->tableware_name;?>
                    </h4>

                    <div class="article-note">
                        <p><?php echo $v->tableware_code;?></p>
                    </div>

                    <div class="article-info">
                        <p>
                            <span class="muted"><i class="icon-author icon2"></i><?php echo $v->id;?></span>
                        </p>
                    </div>

                </div>
            </div>
        <?php }?>
        <div style="text-align: center">
            <a id="sign" class="btn btn-green" href="javascript:;" style="display: none">配送</a>
            <a class="btn btn-blue" type="button" onclick="we.back();">返回</a>
        </div>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
</script>
<!--日期搜索-->
<script>
    $(document).ready(function (){
        console.log('<?php echo $order_model->state==16 ||$order_model->state==17 ;?>');
        var $stateIsWait_to_sign='<?php echo $order_model->state==16 ||$order_model->state==17 ;?>'
        if($stateIsWait_to_sign){
            $('#sign').show();
        }
        else{
            $('#sign').hide();
        }
        $('#sign').on('click',function (){
            var url= '<?php echo $this->createUrl('delivering',array('id'=>$order_model->id));?>';
            let res= confirm('确认配送？')
            if(res){
                $.get(url,function (data){
                    alert('订单已在配送中，请尽快送达');
                    //we.back();
                    $('#sign').hide();
                })
            }
        });
    });
</script>

<!--日期搜索end-->
