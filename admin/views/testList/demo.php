<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>样例</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i
                    class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list());
        ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">组件样例</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="mt15">
            <table style='margin-top:5px;'>
                <tr class="table-title">
                    <td colspan="2">组件区域</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'drop_down');
                        ?></td>
                    <td>
                        <!--                            --><?php //echo $form->dropDownList($model, 'drop_down', Chtml::listData(BaseCode::model()->getByType('yes_or_no'),'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                        <?php echo Select2::activeDropDownList($model, 'drop_down', Chtml::listData(BaseCode::model()->getByType('yes_no'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:160px;'));
                        ?>
                        <?php echo $form->error($model, 'drop_down', $htmlOptions = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'radio_button');
                        ?></td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'radio_button', Chtml::listData(BaseCode::model()->getByType('state_name'), 'f_name', 'f_name'), array('template' => '<li style="display:inline-block;">{input} {label}</li>','separator' => ' '));
                        ?>
                        <?php echo $form->error($model, 'radio_button', $htmlOptions = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td ><?php echo $form->labelEx($model, 'date');
                        ?></td>
                    <td >
                        <?php echo $form->textField($model, 'date', array('class' => 'Wdate','style'=>'width:180px;'));
                        ?>
                        <?php echo $form->error($model, 'date', $htmlOptions = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td ><?php echo $form->labelEx($model, 'check_button');
                        ?></td>
                    <td >
                        <?php echo $form->checkBoxList($model, 'check_button', Chtml::listData(BaseCode::model()->getByType('LEVEL'), 'f_name', 'f_name'), array('prompt'=>'请选择'));
                        ?>
                        <?php echo $form->error($model, 'check_button', $htmlOptions = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'text_area');
                        ?></td>
                    <td >
                        <?php echo $form->textArea($model, 'text_area', array('class' => 'input-text', 'style'=>'width:97%;height:100px','maxlength' => '2000','placeholder'=>"本栏目限填2000字"));
                        ?>
                        <?php echo $form->error($model, 'text_area', $htmlOptions = array());
                        ?>
                    </td>
                </tr>
                <!--                            附件上传-->
                <td ><?php echo $form->labelEx($model, 'img');
                    ?></td>
                <td>
                    <?php echo $form->hiddenField($model, 'img', array('class' => 'input-text fl'));
                    ?>
                    <?php echo show_pic($model->img,get_class($model).'_'.'img')?>
                    <script>we.uploadpic('<?php echo get_class($model);?>_img', 'jpg');
                    </script>
                    <?php echo $form->error($model, 'img', $htmlOptions = array());
                    ?>
                </td>
            </table>
        </div>

    </div>
</div><!--box-detail-tab-item end   style="display:block;"-->
</div><!--box-detail-bd end-->

<?php $this->endWidget();
?>
</div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function() {
            var $date=$('#<?php echo get_class($model);?>_date');
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

<?php highlight_file(__FILE__)?>