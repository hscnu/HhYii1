
<div class="box">

    <div class="box-content">
        <a class="btn" href="<?php echo $this->createUrl('create'); ?>"><i class="fa fa-plus"></i>添加</a>
        <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        <div class="box-header">
            <div class="box-detail-tab box-detail-tab mt15">
                <ul class="c">
                    <?php $action=strtolower(Yii::app()->controller->getAction()->id);?>
                    <li<?php if($action=='index_appoint'){?> class="current"<?php }?>>
                        <a href="<?php echo $this->createUrl('Ice/index_appoint');?>">
                            已保存<?php echo '('.$savedCount.')'?>
                        </a>
                    </li>
                    <li<?php if($action=='index_appoint_wait'){?> class="current"<?php }?>>
                        <a href="<?php echo $this->createUrl('Ice/index_appoint_wait');?>">已提交<?php echo '('.$waitCount.')'?></a>
                    </li>
                </ul>
            </div>
        </div><!--box-header end-->
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
        <div class="box-table">
            <?php if(empty($arclist)){?>
                <div class="article-item flex-center" >
                    <p style="font-size:20px" class="ui-margin-10">暂无订单</p>
                </div>
            <?php } ?>
            <?php foreach ($arclist as $v){?>
                <div class="article-item">
                    <div class="article-content">
                        <h2 class="article-title">
                            <a class="text" href="<?php echo $this->createUrl('update', array('id' => $v->id));?>">
                                <?php echo $v->title;?>
                                <?php if($v->title==null||$v->title==' '){?>
                                    无标题
                                <?php }?>
                            </a>
                        </h2>

                        <div class="article-note">
                            <p><?php echo $v->order_remark;?></p>
                        </div>

                        <div class="article-info">
                            <p>
                                <span class="muted">订单编号：<?php echo $v->order_id;?></span>
                                <span class="muted"><i class="icon-author icon2"></i><?php echo $v->order_name;?></span>
                                <span class="muted"><i class="icon-time icon2"></i><?php echo $v->create_time;?></span>
                            </p>
                            <?php echo $this->chge_state_btn($v,'提交订单','Index_appoint')?>
                        </div>

                    </div>

                </div>
            <?php }?>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
</script>