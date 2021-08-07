<div class="box">
    <div class="box-title" style="font-size: 28px;">
        <b>商家</b>
    </div>
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create'); ?>"><i class="fa fa-plus"></i>添加单位</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

            <a style="display:none;" id="j-delete" class="btn" href="javascript:;"
               onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i
                    class="fa fa-trash-o"></i>删除</a>

        </div><!--box-header end-->
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
                <?php foreach ($arclist as $v) {?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox"
                                                            value="<?php echo CHtml::encode($v->id); ?>"></td>

                        <td style='text-align: center;width: 200px;'><?php echo $v->r_name; ?></td>
                        <td><div align="center"><?php echo show_picture($v->r_image); ?></div></td>
                        <td style='text-align: center;'><?php echo $v->r_address; ?></td>
                        <td style='text-align: center;'><?php echo $v->r_price; ?></td>
                        <td style='text-align: center;'><?php echo $v->r_service; ?></td>
                        <td style='text-align: center;'><?php echo $v->r_rank; ?></td>
                        <td style='text-align: center;'><?php echo $v->r_phone; ?></td>
<!--
                             isupload    ispass
                未上传            0          0
                上传中            0          1
                退回              1          0
                审核通过           1          1
 -->
                        <td>
                        <?php  if($v->r_isupload==0 && $v->r_ispass==1) {
                            echo '上传中';
                                    }
                                else if($v->r_isupload==1&&$v->r_ispass==1)
                                    {
                                        echo '已通过';
                                    }
                                else if($v->r_isupload==0&&$v->r_ispass==0)
                                {
                                    echo '未上传';
                                }
                                else
                                    {
                                        echo "被退回";
                                        ?>
                                        <br>
                                        <?php echo '退回原因:';
                                        if($v->r_reason==null) {
                                            echo '无';
                                        }
                                        else{
                                            echo $v->r_reason;
                                        }
                                    }
                                ?>
                        </td>
                        <td style='text-align: center;'>
                            <?php  $dishes = Dish::model()->findALl(array(
                                'select'=>array('d_rest,d_name'),
                                'condition'=>'d_rest = :d_rest',
                                'params'=>array(':d_rest'=>$v->r_name)));
                            foreach( $dishes as $a){?>
                                <a href="<?php echo $this->createUrl('station', array('rest'=>$v->r_name)); ?>"
                                   title=<?php echo $a->d_name?>><?php echo $a->d_name;?>, </a>
                                <?php
                            }
                            if($dishes == null)
                            {?>
                                <a href="<?php echo $this->createUrl('station', array('rest'=>$v->r_name)); ?>">无</a>
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('change', array('id' => $v->id)); ?>"
                               title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" onClick="return confirm('确定上传?');" href="<?php echo $this->createUrl('upload', array('id' => $v->id)); ?>"
                               title="上传"><i class="fa fa-cloud-upload"></i></a>
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
