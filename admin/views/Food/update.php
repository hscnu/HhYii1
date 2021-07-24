

<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1><span class="back"><a class="btn"
                                                                                           href="javascript:;"
                                                                                           onclick="we.back();"><i
                        class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">菜品信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="2">基本信息</td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'food_name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'food_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'food_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'price'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'price', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'price', $htmlOptions = array()); ?>
                        </td>
                    </tr>


                </table>
                <div class="mt15">
                    <table style='margin-top:5px;'>
                        <tr class="table-title">
                            <td colspan="2">其他信息</td>
                        </tr>
                        <tr>
                            <td width="15%"><?php echo $form->labelEx($model, 'res_name'); ?></td>
                            <td width="85%">
                                <?php echo Select2::activeDropDownList($model, 'res_name',Chtml::listData(Restaurant::model()->getByType3(), 'res_name', 'res_name'), array('prompt'=>'请选择','style'=>'width:160px;'));?>
                                <?php echo $form->error($model, 'res_name', $htmlOptions = array());?>
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $form->labelEx($model, 'intro');?></td>
                            <td>
                                <?php echo $form->textArea($model, 'intro', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'intro', $htmlOptions = array()); ?>
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
