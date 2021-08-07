<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>评价</h1><span class="back"><a class="btn"
                                                                                           href="javascript:;"
                                                                                           onclick="we.back();"><i
                        class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item" >
                <table class="eval">
                    <tr>
                        <td style="border-bottom: 1px solid #ddd;font-size: 24px"><b>您对菜品满意吗？</b></td>
                    </tr>

                    <?php
                    if (isset($_SESSION['eval_rest']) == true) {
                        $flag = 1;
                        ?>
                       <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'eval_rest', array('class' => 'input-text fl','value'=>$_SESSION['eval_rest'])); ?>
                            <?php echo $form->error($model, 'eval_rest', $htmlOptions = array()); ?>
                    </td>
                    </tr><?php
                    }
                    else{?>
                        <tr>
                        <td>
                            <?php echo Select2::activeDropDownList($model, 'eval_rest',  Chtml::listData(Restaurant::model()->findAll(array(
                                'select'=> array('r_name'),
                                'order' => 'r_name DESC',
                            )),'r_name','r_name'), array('prompt'=>'请选择商家','style'=>'width:200px;','id'=>'select')); ?>
                            <?php echo $form->error($model, 'eval_rest', $htmlOptions = array()); ?>
                    </td>
                    </tr>
                        <?php
                            $flag = 0;
                        }
                    ?>

                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->textField($model, 'evaluator', array('class' => 'input-text','style'=>'width:250px;','placeholder'=>'请输入您的昵称')); ?>
                            <?php echo $form->error($model, 'evaluator', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="float:left;font-size: 16px;margin:3px;position: relative;top: 10px;">总体服务</div>
                            <ul>
                                   <li class="cleanfloat">&#9733;</li>
                                    <li class="cleanfloat">&#9733;</li>
                                    <li class="cleanfloat">&#9733;</li>
                                    <li class="cleanfloat">&#9733;</li>
                                    <li class="cleanfloat">&#9733;</li>
                                </ul>
                            <div id="show_star" style="float:left;margin:3px;font-size: 16px;position: relative;top: 10px;"></div>
                        </td>
                    </tr>
                    <?php if($flag == 1){
                    $d = Dish::model()->findAll(array(
                         'select'=>array('d_name,d_image,d_rest'),
                            'order'=>'d_name asc',
                            'condition' => 'd_rest=:d_rest',
                           'params' => array('d_rest'=>$_SESSION['eval_rest']),
                           ));
                    ?>
                        <?php
                        foreach ($d as $obj)
                            {?>
                    <tr>
                        <td>
                                <div class="eval_dish">
                                    <span class="dish" value="<?php echo $obj->d_name; ?>"><?php echo $obj->d_name; ?></span>
                                <div class="up" ><i class="fa fa-thumbs-up"></i></div>
                                <div class="down"><i class="fa fa-thumbs-down"></i></div>
                                </div>
                        </td>
                    </tr>
                            <?php }
                            }
                        ?>
                    <tr>
                        <td>
                            <?php echo $form->textArea($model, 'eval_content', array('class' => 'input-text','style'=>'resize: none;height:150px;','placeholder'=>'请输入评价内容')); ?>
                            <?php echo $form->error($model, 'eval_content', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo show_pic($model->eval_image,get_class($model).'_'.'eval_image')?>
                            <?php echo $form->hiddenField($model, 'eval_image', array('class' => 'input-text fl')); ?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_eval_image', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'eval_image', $htmlOptions = array()); ?>
                            <div style="float: left;color: grey">注:图片大小应不超过1MB</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div><!--box-detail-tab-item end   style="display:block;"-->

    </div><!--box-detail-bd end-->

    <div class="box-detail-submit">
        <button onclick="submitType='baocun'"class="btn btn-blue" type="submit" id = 'submit'>保存</button>
        <button class="btn" type="button" onclick="we.back();">取消</button>
    </div>

    <?php $this->endWidget(); ?>
</div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function () {
        var star;
        var nice = 1;
        var dishes = new Array();
        var evals = new Array();
        $("#select").click(function () {
            var option=$("#select option:selected");
            var opt = option.text();
            $.ajax({
                url: '<?php echo $this->createUrl('SaveRest')?>',//目的php文件
                data: {'opt': opt},//传输的数据
                type: 'post',//数据传送的方式get/post
                dataType: 'text',//数据传输的格式是text
                success: function (response) {
                    location.reload();
                },
            })
        })
        $("ul li").hover(function () {
            $(this).addClass('hs');
            $(this).prevAll().addClass('hs');
            star = $(this).prevAll().length + 1;
        }, function () {
            $(this).removeClass('hs');
            $(this).prevAll().removeClass('hs');
            star = $(this).prevAll().length + 1;
        })
        $("ul li").click(function () {
            $(this).addClass('cs');
            $(this).prevAll().addClass('cs');
            $(this).nextAll().removeClass('cs');
            star = $(this).prevAll().length + 1;
            var s = 0;
            switch (star){
                case 1:s='非常差';break;
                case 2:s='差';break;
                case 3:s='一般';break;
                case 4:s='满意';break;
                case 5:s='非常满意';break;
            }
            document.getElementById("show_star").innerHTML = s;
            $.ajax({
                url: '<?php echo $this->createUrl('SaveStar')?>',//目的php文件
                data: {'star': star},//传输的数据
                type: 'post',//数据传送的方式get/post
                dataType: 'text',//数据传输的格式是text
                success: function (response) {
                },
            })
        })

        $(".up").click(function () {
            dish = $(this).prev().text();
            $(this).toggleClass('up');
            $(this).toggleClass('up-clicked');
            if($(this).hasClass('up-clicked')){
                nice = 1;
                if(dishes.indexOf(dish)==-1){
                    dishes.push(dish);
                    evals.push(nice);
                }
                else
                {
                    var i = dishes.indexOf(dish);
                    evals[i] = nice;
                }
            }
            if($(this).next().hasClass('down-clicked')){
                $(this).next().toggleClass('down');
                $(this).next().toggleClass('down-clicked');
            }
        })
        $(".down").click(function () {
            dish = $(this).prev().prev().text();
            $(this).toggleClass('down');
            $(this).toggleClass('down-clicked');
            if($(this).prev().hasClass('up-clicked')) {
                $(this).prev().toggleClass('up');
                $(this).prev().toggleClass('up-clicked');
            }
            if($(this).hasClass('down-clicked')){
                nice = 0;
                if(dishes.indexOf(dish)==-1){
                    dishes.push(dish);
                    evals.push(nice);
                }
                else
                {
                    var i = dishes.indexOf(dish);
                    evals[i] = nice;
                }
            }
        })
        $("#submit").click(function () {
            $.ajax({
                url: '<?php echo $this->createUrl('SaveNice')?>',//目的php文件
                data: {
                    'dish': dishes,
                    'eval': evals
                },
                type: 'post',//数据传送的方式post
                dataType: 'text',
                success: function (response) {
                },
            })
        })
        $(".btn,.btn btn-blue").click(function () {
            $.ajax({
                url: '<?php echo $this->createUrl('Cancel')?>',//目的php文件
                data: {},
                type: 'post',//数据传送的方式post
                success: function (response) {
                },
            })
        })
    })
</script>


