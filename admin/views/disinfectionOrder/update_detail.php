<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1><span class="back"></span></div><!--box-title end-->
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
                        <td><?php echo $form->labelEx($model, 'order_id'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'order_id', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'tableware_type'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'tableware_type', Chtml::listData(TableWareType::model()->getAllType(),'type', 'type'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'tableware_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'tableware_name'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'tableware_name', Chtml::listData(TableWareType::model()->getAllType(),'type', 'type'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'tableware_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'unit'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'unit', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'unit', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'number', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'number', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                </table>
            </div>
        </div><!--box-detail-tab-item end   style="display:block;"-->

    </div><!--box-detail-bd end-->



    <div class="box-detail-submit">
        <button onclick="save()" class="btn btn-blue" type="submit">保存</button>
    </div>

    <?php $this->endWidget(); ?>
</div><!--box-detail end-->
</div><!--box end-->

<script>
    if('<?php echo $isClose==1?>'){
        $.dialog.data('detailId','<?php echo $model->id;?>')
        $.dialog.close();
    }


    $(function(){
        let api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        api.button(
            {
                name: '取消'
            }
        );


    });
</script>

<script>
    <?php
    $JSON=tableWare::model()->findAll();//选项表
    $JSON=toIoArray($JSON,'type,code,name');//封装方法，选定字段构造数组，准备输出Json数据
    ?>
    var jsonData= <?php echo json_encode($JSON)?>;//输出json数据
    var selectType='<?php echo $model->tableware_type; ?>';//种类
    var Name='<?php echo $model->tableware_name; ?>';//名称
    var ptype=$('#<?php echo get_class($model)?>_tableware_type');
    ptype.on('change',function (){
        select(this)
    })

    select(ptype);
    function select(obj){
        var show_id=$(obj).val();//选中的种类
        if (show_id===undefined){//初始进入页面的默认设置
            show_id=Name;
        }
        var c1,c2;//c1判断是否选中，c2用来判断种类
        var p_html ='<option value="">请选择</option>';
        for (j = 0; j < jsonData.length; j++) {
            if(jsonData[j]['type']===show_id) {//遍历选项种类，如果等于选中种类，构造HTML下拉框
                c2 = we.trim(jsonData[j]['name'], ' ');
                c1=''
                if (c2 === Name) {//初始进入页面的默认设置
                    c1 = 'selected';
                }
                p_html = p_html + '<option value="' + c2 + '"' + c1 + '>' + c2 + '</option>';
            }
        }
        $("#<?php echo get_class($model)?>_tableware_name").html(p_html);//写入html

    }
</script>


