<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1><span class="back"><a class="btn"
                                                                                           href="javascript:;"
                                                                                           onclick="we.back();"><i
                        class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">评论信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="2">菜品相关信息</td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'food_name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'food_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'food_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'res_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'res_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'res_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>


                </table>
                <div class="mt15">
                    <table style='margin-top:5px;'>
                        <tr class="table-title">
                            <td colspan="2">评论相关信息</td>
                        </tr>
                        <tr>
                            <td width="15%"><?php echo $form->labelEx($model, 'user_name'); ?></td>
                            <td width="85%">
                                <?php echo $form->textField($model, 'user_name', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'user_name', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'comment'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'comment', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'comment', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <!--
                        <tr>
                            <td><?php echo $form->labelEx($model, 'time_stamp'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'time_stamp', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'time_stamp', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        -->
                        <tr>
                            <td><?php echo $form->labelEx($model, 'comment_star'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'comment_star', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'comment_star', $htmlOptions = array()); ?>
                            </td>
                        </tr>

                    </table>
                </div>

            </div><!--box-detail-tab-item end   style="display:block;"-->

        </div><!--box-detail-bd end-->

        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
