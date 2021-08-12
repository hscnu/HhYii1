<div class="box">
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a class="btn" href="<?php echo $this->createUrl('restaurant/user');?>"><i class="fa fa-undo"></i>返回</a>
        </div><!--box-header end-->
        <?php $a = Restaurant::model()->find(array(
            'select'=>array('r_image,r_name,r_address,r_phone,r_service,r_rank,r_like'),
            'condition' => 'r_name=:r_name',
            'params' => array('r_name'=>$_SESSION['rest']),
        ));
        ?>
        <div class="box-table">
            <table class="list2" >
                <tbody>
                <tr>
                    <td style='text-align:center' rowspan="5" class="image"><?php echo show_picture($a->r_image); ?></td>
                    <td style='text-align:left;font-size: x-large' colspan="3" ><b><?php echo $a->r_name; ?></b>
                        <?php if($a->r_like==0){ ?>
                        <p class="like">&#10084;</p></td>
                        <?php }
                        else{?>
                        <p class="yes">&#10084;</p>
                    <?php } ?>
                </tr>
                <tr>
                    <td style='text-align: left;font-size: large' colspan="3">地址：<?php echo $a->r_address; ?></td>
                </tr>
                <tr>
                    <td style='text-align: left;font-size: large' colspan="3" >联系方式：<?php echo $a->r_phone; ?></td>

                </tr>
                <tr>
                    <td style='text-align: left;font-size: medium;width: 100px;'>&#9733;<?php echo $a->r_service; ?></td>
                    <td style='text-align: left;font-size: medium;width: 100px;' >地区排名：<?php echo $a->r_rank; ?>/<?php echo Restaurant::model()->count();?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="box-detail-tab box-detail-tab mt15">
            <ul class="c">
                <?php $action=strtolower(Yii::app()->controller->getAction()->id);?>
                <li<?php if($action=='user'){?> class="current"<?php }?>>
                    <a href="<?php echo $this->createUrl('dish/user');?>" class="navigator">菜品</a>
                </li>
                <li>
                    <a href="<?php echo $this->createUrl('evaluation/user');?>" class="navigator">评价</a>
                </li>
            </ul>
        </div><!--box-detail-tab end-->

        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords"
                           value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php
        foreach ($arclist as $v) {
                if($v->d_rest == $_SESSION['rest']){?>
            <div class="box-table">
                <table class="list2">
                    <tbody>
                    <tr>
                        <td style='text-align:right' rowspan="3" class="image"><?php echo show_picture($v->d_image); ?></td>
                        <td style='text-align:left;font-size: x-large' colspan="2" ><b><?php echo $v->d_name; ?></b>
                    </tr>
                    <tr>
                        <td style='text-align: left;font-size: medium;width: 100px' ><?php echo $v->d_rate; ?>%好评</td>
                        <td style='text-align: left;font-size: medium;width: 200px'><?php echo $v->d_introduce; ?></td>
                        <td style='text-align: left;font-size: large;'><button style="color: #FFFFFF;font-size:large;border-radius:5px;background: orange;width: 80px;height: 50px;">购买</button></td>
                    </tr>
                    <tr>
                        <td style='text-align: left;font-size: large;color: #F00;'>￥<?php echo $v->d_price; ?></td>
                    </tr>
                    </tbody>
                </table>
            </div><!--box-table end-->
        <?php }
        } ?>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
</script>
<script typet="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(function () {
        var isLike = 0;
        $(".like").click(function () {
            $(this).toggleClass('yes');
            $(this).toggleClass('like');
            isLike =  $(this).hasClass('yes');
            isLike  = + isLike;
            $.ajax({
                url: '<?php echo $this->createUrl('savelike')?>',
                data: {'isLike': isLike},//传输的数据
                type: 'post',//数据传送的方式get/post
                dataType: 'text',//数据传输的格式是text
                success: function (response) {
                },
            })
        })
        $(".yes").click(function () {
            $(this).toggleClass('yes');
            $(this).toggleClass('like');
            isLike =  $(this).hasClass('yes');
            isLike  = + isLike;
            $.ajax({
                url: '<?php echo $this->createUrl('savelike')?>',
                data: {'isLike': isLike},//传输的数据
                type: 'post',//数据传送的方式get/post
                dataType: 'text',//数据传输的格式是text
                success: function (response) {
                },
            })
        })
    })
</script>