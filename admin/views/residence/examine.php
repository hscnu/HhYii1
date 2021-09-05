<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>单位信息</h1>
        <span class="back"><a class="btn"zhref="javascript:;"onclick="we.back();">
            <i class="fa fa-reply">
            </i>返回</a></span>
    </div><!--box-title end-->

    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">单位基本信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>


                    <tr class="table-title">
                        <td colspan="4">单位基本信息</td>
                    </tr>



                    <tr>

                        <td><?php echo $form->labelEx($model, 'residence_type'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'residence_type', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'residence_type', $htmlOptions = array()); ?>

                        <td><?php echo $form->labelEx($model, 'account_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'account_number', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'account_number', $htmlOptions = array()); ?>
                        </td><!--单位管理账号-->
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'apply_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'apply_number', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'apply_number', $htmlOptions = array()); ?>
                        </td><!--申请人账号-->

                        <td><?php echo $form->labelEx($model, 'contact_person'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'contact_person', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'contact_person', $htmlOptions = array()); ?>
                        </td><!--联系人-->
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'contact_number', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'contact_number', $htmlOptions = array()); ?>
                        </td><!--联系电话-->

                        <td><?php echo $form->labelEx($model, 'email'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'email', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                        </td><!--Email-->
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'ID_card_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'ID_card_number', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'ID_card_number', $htmlOptions = array()); ?>
                        </td><!--身份证账号-->
                        <td><?php echo $form->labelEx($model, 'location'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'location', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'location', $htmlOptions = array()); ?>
                        </td><!--单位所在地-->
                    </tr>


                    <tr>
                        <td><?php echo $form->labelEx($model, 'account_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'account_number', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'account_number', $htmlOptions = array()); ?>
                        </td><!--单位管理账号-->

                        <td><?php echo $form->labelEx($model, 'unit_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'unit_name', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'unit_name', $htmlOptions = array()); ?>
                        </td><!--单位名称-->
                    </tr>


                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'IDcard_photo_front');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'IDcard_photo_front', array('class' => 'input-text fl','readonly'=>'readonly'));?>
                            <?php echo show_pic($model->IDcard_photo_front,get_class($model).'_'.'IDcard_photo_front')?>
                            <?php echo $form->error($model, 'IDcard_photo_front', $htmlOptions = array());?>
                        </td>
                    </tr><!--身份证照正面-->



                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'IDcard_photo_back'); ?></td>
                        <td colspan="3">
                            <?php echo show_pic($model->IDcard_photo_back,get_class($model).'_'.'IDcard_photo_back')?>
                            <?php echo $form->error($model, 'IDcard_photo_back', $htmlOptions = array()); ?>
                        </td>
                    </tr><!--身份证照反面-->




                    <tr>
                        <td><?php echo $form->labelEx($model, 'job'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'job', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'job', $htmlOptions = array()); ?>
                        </td>
                    </tr><!--职业-->



                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'business_license');?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'business_license', array('class' => 'input-text fl','readonly'=>'readonly'));?>
                            <?php echo show_pic($model->business_license,get_class($model).'_'.'business_license')?>
                            <?php echo $form->error($model, 'business_license', $htmlOptions = array());?>
                        </td>
                    </tr><!--营业执照-->
                    <tr>
                        <td><?php echo $form->labelEx($model, 'examine_person'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'examine_person', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'examine_person', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'examine_time');?></td>
                        <td>
                            <?php echo $form->textField($model, 'examine_time', array('class' => 'Wdate','style'=>'width:180px;'));?>
                            <?php echo $form->error($model, 'examine_time', $htmlOptions = array());?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'examine_explain');?></td>
                        <td colspan="3"> <?php echo $form->textArea($model, 'examine_explain',
                                array('class' => 'input-text', 'style'=>'width:97%;height:100px','maxlength' => '2000','placeholder'=>"本栏目限填2000字"));?>
                            <?php echo $form->error($model, 'examine_explain', $htmlOptions = array());?>
                        </td>
                    </tr>
                </table>

            </div><!--box-detail-tab-item end   style="display:block;"-->
            <div class="box-detail-submit">
                <button onclick="submitType='shenhetongguo'" class="btn btn-blue" style="z-index:99999" type="submit">审核通过</button>
                <button onclick="submitType='shenheweitongguo'" class="btn btn-blue" style="z-index:99999" type="submit">审核未通过</button>
                <button class="btn" type="button" onclick="we.back();">取消</button>
            </div>
            <?php $this->endWidget(); ?>
        </div><!--box-detail end-->
    </div><!--box end-->
    <script>
        $(function() {
                var $date=$('#<?php echo get_class($model);?>_examine_time');
                $date.on('click', function() {
                        WdatePicker( {
                                startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'
                            }
                        );
                    }
                );
            }
        );
    </script>

