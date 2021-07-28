<div class="box">
    <div class="box-title" style="font-size: 28px;">
        <b>酒楼管理</b>
    </div>
    <div class="box-detail-tab box-detail-tab mt15">
        <ul class="c">
            <?php $action=strtolower(Yii::app()->controller->getAction()->id);?>
            <li<?php if($action=='index'){?> class="current"<?php }?>>
                <a href="<?php echo $this->createUrl('restaurant/index');?>">酒楼审核</a>
            </li>
            <li>
                <a href="<?php echo $this->createUrl('evaluation/index');?>">评价审核</a>
            </li>
        </ul>
    </div><!--box-detail-tab end-->
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
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th><?php echo $model->getAttributeLabel('r_name'); ?></th>
                    <th><?php echo $model->getAttributeLabel('r_image'); ?></th>
                    <th><?php echo $model->getAttributeLabel('r_address'); ?></th>
                    <th><?php echo $model->getAttributeLabel('r_price'); ?></th>
                    <th><?php echo $model->getAttributeLabel('r_service'); ?></th>
                    <th><?php echo $model->getAttributeLabel('r_rank'); ?></th>
                    <th><?php echo $model->getAttributeLabel('r_phone'); ?></th>
                    <th>状态</th>
                    <th>菜单</th>
                    </th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arclist as $v) {
                        $flag = 1;
                        if(($v->r_isupload || $v->r_ispass) == 1){
                    ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;width: 200px;'><?php echo $v->r_name; ?></td>
                        <td style='text-align: center;'><div align="center"><?php echo show_picture($v->r_image); ?></div></td>
                        <td style='text-align: center;'><?php echo $v->r_address; ?></td>
                        <td style='text-align: center;'><?php echo $v->r_price; ?></td>
                        <td style='text-align: center;'><?php echo $v->r_service; ?></td>
                        <td style='text-align: center;'><?php echo $v->r_rank; ?></td>
                        <td style='text-align: center;'><?php echo $v->r_phone; ?></td>
                        <td style='text-align: center;'>
                        <?php if(($v->r_ispass&&$v->r_isupload) == 1) {
                            echo '审核通过';
                        }
                        else if($v->r_ispass == 0 && $v->r_isupload == 1) {
                            $flag = 0;
                            echo '已退回';
                        }
                        else
                        {
                            echo '未审核';
                        }
                        ?>
                        </td>
                        <td style='text-align: center;'>
                            <?php  $dishes = Dish::model()->findALl(array(
                                     'select'=>array('d_rest,d_name'),
                                     'condition'=>'d_rest = :d_rest',
                                     'params'=>array(':d_rest'=>$v->r_name)));
                            foreach( $dishes as $a){?>
                                <?php echo $a->d_name;?>
                                <?php
                                }
                            ?>
                        </td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id' => $v->id)); ?>"
                               title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" onClick="return confirm('确定通过?');" href="<?php echo $this->createUrl('pass', array('id' => $v->id)); ?>"
                               title="通过"><i class="fa fa-check"></i></a>
                            <?php if($flag != 0){?>
                            <a class="rtn" title="退回" href='#' id ="<?php echo  $v->id?>" ><i class="fa fa-times"></i></a>
                            <?php }?>
                        </td>
                    </tr>
                            <div id='inputbox' class="inputbox" >
                                <b>退回原因：</b><input type="text" id="reason">
                                <button class="cfm" style="position: relative;top: 25px;" value="<?php echo  $v->id?>">确认</button>
                                <button class="ccl" style="position: relative;top: 25px;left: 30%;" >返回</button>
                            </div>
                <?php
                        }
                } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function () {
        var id;
        $(".rtn").click(function () {
            document.getElementById('inputbox').style.display = 'block';
            id =  $(this).attr('id');
        })
        $(".ccl").click(function () {
            $('.inputbox input').val('');
            document.getElementById('inputbox').style.display = 'none';
        })
        $(".cfm").click(function () {
            var reason = document.getElementById('reason').value;
            $.ajax({
                url: '<?php echo $this->createUrl('return')?>',
                data: {'reason': reason,"id":id},//传输的数据
                type: 'post',//数据传送的方式get/post
                dataType: 'text',//数据传输的格式是text
                success: function (response) {
                    $('.inputbox input').val('')
                    document.getElementById('inputbox').style.display = 'none';
                    alert("成功退回!");
                    location.reload();
                },
            })

        })
    })
</script>