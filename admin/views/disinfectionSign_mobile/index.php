<div class="box">
    <div class="box-content">

        <div class="box-header">
            <a style="display:none;" class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

            <a style="display:none;" id="j-delete" class="btn" href="javascript:;"
               onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i
                        class="fa fa-trash-o"></i>删除</a>

        </div><!--box-header end-->
        <!--  导航栏-->
        <?php
        $navData[]=array('Index_wait_sign','待签收','('.$waitSignCount.')');
        $navData[]=array('Index_signed','已签收','('.$signedCount.')');
        $navData[]=array('index','全部','('.$AllSignCount.')');
        echo $this->getNav($navData);
        ;?>

        <!--  导航栏end-->
        <div class="box-search" style="text-align: center">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <input id="keywords" style="width:200px;" class="input-text" type="text" name="keywords"
                           value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                    <button id="keywords_btn" class="btn btn-blue" type="button">关键字查询</button>
                </label>
                <label style="margin-right:10px;">
                    <?php $start_date_search= Yii::app()->request->getParam('start_date');?>
                    <input style="width:120px;" class="input-text" type="text" id="start_date"
                           name="start_date" value="<?php echo $start_date_search?$start_date_search:''//Date('Y-m-d') ?>">
                    <button id="date_btn" class="btn btn-blue" type="button">日期查询</button>
                </label>
                <button id="submit" class="btn btn-blue" type="submit">查询</button>
                <button id="cancel" class="btn btn-blue" type="submit">取消</button>
            </form>
        </div><!--box-search end-->
        <div><span>
            </span></div>
        <?php foreach ($arclist as $v){?>
            <div class="article-item">
                <div class="article-content">
                    <h2 class="article-title">
                        <a class="text" href="<?php echo $this->createUrl('detail',array('id'=>$v->id));?>"><?php echo $v->title;?></a>
                    </h2>

                    <div class="article-note">
                        <p>状态：<?php echo $model->getCHName($v->state);?></p>
                        <p>消毒中心：<?php echo $v->disinfection_name;?></p>
                        <p>餐具种类数：<?php echo $v->detail_number;?></p>
                    </div>

                    <div class="article-info">
                        <p>
                            <span class="muted">备注：<?php echo $v->notes;?></span>
                        </p>
                    </div>

                </div>
            </div>
        <?php }?>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
</script>
<!--日期搜索-->
<script>
    var $start_date=$('#start_date');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});})
</script>

<!--日期搜索end-->

<script>
    //关键字查询
    $(document).ready(function(){
        $("#keywords").hide();
        $("#submit").hide();
        $("#start_date").hide();
        $("#cancel").hide();
        $("#keywords_btn").click(function(){
            $("#keywords").show();
            $("#submit").show();
            $("#cancel").show();
            $("#keywords_btn").hide();
            $("#date_btn").hide();
        });
        $("#date_btn").click(function(){
            $("#start_date").show();
            $("#submit").show();
            $("#cancel").show();
            $("#keywords_btn").hide();
            $("#date_btn").hide();
        });
        //取消
        $("#cancel").click(function (){
            $("#keywords").val("");
            $("#start_date").val("");
        })
    });
</script>
<style>
    .item{
        width: 100%;
        height: 100%;
    }
    hr.s1 {
        border: 0;
        height: 0;
        box-shadow: 0 0 10px 1px black;
    }

</style>