<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1><span class="back"><a class="btn"
                                                                                           href="javascript:;"
                                                                                           onclick="we.back();"><i
                        class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="2">申请信息</td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'id'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'id', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'id', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'time', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'time', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'fisherman_name'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'fisherman_name', array('class' => 'input-text')); ?>
<!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
<!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'fisherman_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'fisherman_phonenum'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'fisherman_phonenum', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'fisherman_phonenum', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'fisherman_idnum'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'fisherman_idnum', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'fisherman_idnum', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                                        <!--                            图片上传-->
                    <td ><?php echo $form->labelEx($model, 'picture_idnum_front');
                        ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'picture_idnum_front', array('class' => 'input-text fl'));
                        ?>
                        <?php echo show_pic($model->picture_idnum_front,get_class($model).'_'.'picture_idnum_front')?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_picture_idnum_front', 'jpg');
                        </script>
                        <?php echo $form->error($model, 'picture_idnum_front', $htmlOptions = array());
                        ?>
                    </td>





                    <!--                            图片上传-->
                    <td ><?php echo $form->labelEx($model, 'picture_idnum_back');
                        ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'picture_idnum_back', array('class' => 'input-text fl'));
                        ?>
                        <?php echo show_pic($model->picture_idnum_back,get_class($model).'_'.'picture_idnum_back')?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_picture_idnum_back', 'jpg');
                        </script>
                        <?php echo $form->error($model, 'picture_idnum_back', $htmlOptions = array());
                        ?>
                    </td>


                    <tr>
                        <td><?php echo $form->labelEx($model, 'boat_name'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'boat_name', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'boat_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>






                    <!--                            图片上传-->
                    <td ><?php echo $form->labelEx($model, 'picture_of_boat');
                        ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'picture_of_boat', array('class' => 'input-text fl'));
                        ?>
                        <?php echo show_pic($model->picture_of_boat,get_class($model).'_'.'picture_of_boat')?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_picture_of_boat', 'jpg');
                        </script>
                        <?php echo $form->error($model, 'picture_of_boat', $htmlOptions = array());
                        ?>
                    </td>




                    <!--                            图片上传-->
                    <td ><?php echo $form->labelEx($model, 'picture_certificate_boat');
                        ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'picture_certificate_boat', array('class' => 'input-text fl'));
                        ?>
                        <?php echo show_pic($model->picture_certificate_boat,get_class($model).'_'.'picture_certificate_boat')?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_picture_certificate_boat', 'jpg');
                        </script>
                        <?php echo $form->error($model, 'picture_certificate_boat', $htmlOptions = array());
                        ?>
                    </td>


                    <tr>
                        <td><?php echo $form->labelEx($model, 'valid_time_boat'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'valid_time_boat', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'valid_time_boat', $htmlOptions = array()); ?>
                        </td>
                    </tr>




                    <!--                            图片上传-->
                    <td ><?php echo $form->labelEx($model, 'picture_certificate_catch');
                        ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'picture_certificate_catch', array('class' => 'input-text fl'));
                        ?>
                        <?php echo show_pic($model->picture_certificate_catch,get_class($model).'_'.'picture_certificate_catch')?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_picture_certificate_catch', 'jpg');
                        </script>
                        <?php echo $form->error($model, 'picture_certificate_catch', $htmlOptions = array());
                        ?>
                    </td>


                    <tr>
                        <td><?php echo $form->labelEx($model, 'valid_time_catch'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'valid_time_catch', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'valid_time_catch', $htmlOptions = array()); ?>
                        </td>
                    </tr>


                    <tr>
                        <td><?php echo $form->labelEx($model, 'oil'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'oil', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'oil', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'company'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'company', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'company', $htmlOptions = array()); ?>
                        </td>
                    </tr>


                    <tr>
                        <td><?php echo $form->labelEx($model, 'state'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'state', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'state', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'longitude'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'longitude', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'longitude', $htmlOptions = array()); ?>
                        </td>
                    </tr>


                    <tr>
                        <td><?php echo $form->labelEx($model, 'latitude'); ?></td>
                        <td><!--区域选择弹窗未显示-->
                            <?php echo $form->textField($model, 'latitude', array('class' => 'input-text')); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'Longitude'); ?>
                            <!--                            --><?php //echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'latitude', $htmlOptions = array()); ?>
                        </td>
                    </tr>


 
                    <tr>
                        <td><?php echo $form->labelEx($model, 'state');?></td>
                        <td><?php echo Select2::activeDropDownList($model, 'state',Chtml::listData(BaseCode::model()->getByType('pass_fail'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:160px;'));?>
                        <?php echo $form->error($model, 'state', $htmlOptions = array());?>
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



