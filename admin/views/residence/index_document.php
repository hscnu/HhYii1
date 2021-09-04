
<div class="box">
    <div class="box-content">
        <div class="article-list">




            <?php if(empty($arclist)){?>
                <div class="article-item flex-center" >
                    <p style="font-size:20px" class="ui-margin-10">暂无文章</p>
                </div>
            <?php } ?>
            <?php foreach ($arclist as $v){?>
                <div class="article-item">
                    <div class="article-content">


                        <div class="article-info">
                            <p>
                                <span class="muted"><i class="icon-author icon2"></i><?php echo $v->account_number;?></span>
                                <span class="muted"><i class="icon-eye-open icon2"></i><?php echo $v->apply_number;?></span>
                                <span class="muted"><span>状态：</span><?php echo $v->state;?></span>
                            </p>
                        </div>

                    </div>

                </div>
            <?php }?>
        </div>


    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';

</script>