
<div class="box">

    <div class="box-content">
        <div class="article-list">

            <div class="article-item">
                <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                    <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                    <label style="margin-right:10px;">
                        <span>搜一下：</span>
                        <input style="width:150px;" class="input-text" type="text" name="keywords" placeholder="请输入搜索内容"
                               value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                    </label>

                    <button class="btn btn-light-green" type="submit">查询</button>
                </form>
            </div><!--box-search end-->



            <?php if(empty($arclist)){?>
                <div class="article-item flex-center" >
                    <p style="font-size:20px" class="ui-margin-10">暂无订单</p>
                </div>
            <?php } ?>
            <?php foreach ($arclist as $v){?>
                <div class="article-item">
                    <div class="article-content">
                        <h2 class="article-title">
                            <a class="text" href="<?php echo $this->createUrl('ShowDetail_mobile',array('oId'=>$v->id,'condition'=>0));?>">
                                <?php echo $v->title;?></a>
                        </h2>

                        <div class="article-note">
                            <p><?php echo $v->order_remark;?></p>
                        </div>

                        <div class="article-info">
                            <p>
                                <span class="muted"><i class="icon-author icon2"></i><?php echo $v->order_name;?></span>
                                <span class="muted"><i class="icon-time icon2"></i><?php echo $v->create_time;?></span>
                            </p>
                            <?php echo $this->chge_state_btn($v,'确认收货','index_myconfirm_receipt')?>
                        </div>

                    </div>
                </div>
            <?php }?>
        </div>

        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';

</script>