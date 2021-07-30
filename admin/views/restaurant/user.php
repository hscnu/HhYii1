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
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php foreach ($arclist as $v) { ?>
        <div class="box-table" onclick="window.location.href='<?php echo $this->createUrl('station1', array('rest' => $v->r_name)); ?>'">
            <table class="list1" >
                <tbody>
                    <tr>
                        <td style='text-align:center' rowspan="5" class="image"><?php echo show_picture($v->r_image); ?></td>
                        <td style='text-align:left;font-size: x-large' colspan="3" ><b><?php echo $v->r_name; ?></b>
                    </tr>
                    <tr>
                        <td style='text-align: left;font-size: large' colspan="3">地址：<?php echo $v->r_address; ?></td>
                    </tr>
                    <tr>
                        <td style='text-align: left;font-size: large' colspan="3" >联系方式：<?php echo $v->r_phone; ?></td>

                    </tr>
                    <tr>
                        <td style='text-align: left;font-size: medium;width: 100px;'>&#9733;<?php echo $v->r_service; ?></td>
                        <td style='text-align: left;font-size: medium;width: 100px;' >地区排名：<?php echo $v->r_rank; ?>/<?php echo Restaurant::model()->count();?></td>
                        <td style='text-align: left;font-size: medium;width: 100px;'>人均价格：￥<?php echo $v->r_price; ?></td>
                    </tr>
                    <td style='text-align: left;color: #F00;font-size:medium' colspan="3"><b>热卖:
                        <?php  $dishes = Dish::model()->findALl(array(
                            'select'=>array('d_rest,d_name'),
                            'condition'=>'d_rest = :d_rest',
                            'params'=>array(':d_rest'=>$v->r_name)));
                        if ($dishes == null)
                        {
                            echo '暂无菜品';
                        }
                        foreach( $dishes as $a){
                             echo $a->d_name.' ';
                        }
                        ?>
                        </b></td>
                </tbody>
            </table>
        </div><!--box-table end-->
        <?php } ?>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
</script>
