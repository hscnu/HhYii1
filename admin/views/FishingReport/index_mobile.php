<style>
    .btn-trash{
        float: right;
    }

    .btn-trash img{
        height: 20px;
        width: 20px;
    }

    .flex-row
    {
        display: flex;
        flex-direction: row;
    }

    .bd-grey{
        border-bottom: solid rgba(128, 128, 128, 0.08) 1px;
        margin-bottom: 5px;
        padding-bottom: 5px;
    }
    .flex-container
    {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .flex-container-button{
        display:flex;
        flex-direction: row;
        justify-content: space-between;

    }
    .text-container{
        padding-left: 10px;
        font-size: 11px;
    }
    .img{
        height:25px;
        width:20px;
    }

    .article-content{
        display: flex;
        flex-direction: column;
        margin: 2px;
    }
</style>

<div class="box">
    <div class="box-content">
        <div class="box-header">
            <a style="display:none;" class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a class="btn" href="<?php echo $this->createUrl('create'); ?>"><i class="fa fa-plus"></i>捕鱼上报</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;"
               onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i
                    class="fa fa-trash-o"></i>删除</a>
        </div>

        <div class="box-search" style="text-align: center">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
            </form>
        </div><!--box-search end-->
        <div><span>
            </span></div>

        <?php foreach ($arclist as $v){?>
            <div class="article-item" data-id="<?php echo $v->id?>">
                <div class="article-content" >
                 <div class="bd-grey">
                    <div class="flex-container">
                    <div class="flex-row">
                        <div class="disabled"><?php echo show_pic($v->image,'','139','130','0') ;?></div>
                            <div>
                                <div class="text-container">
                                <p style="font-weight: bold"> <?php echo $v->title;?></p>
                                <p>上报单号：<?php echo $v->report_id;?></p>
                                <p>船号：<?php echo $v->boat_id;?></p>
                                <p><?php echo $v->count;?>笔</p>
                                <p><?php echo $v->reporttime;?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="flex-container-button">

                            <a class="btn-trash" href="javascript:;" onclick="we.dele('<?php echo $v->id; ?>', deleteUrl);"
                               title="删除"><img class="img" src="static/admin/img/trash.png"></a>
                            <button class="btn btn-green"  type="button" onclick="AuditDetail(<?php echo $v->id;?>);">提交</button>

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
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
    function AuditDetail(id=0){
        url = '<?php echo $this->createUrl("UpdateVerify");?>'
        url +='&id='+id
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'updateDetail',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'100%',
            title:"捕鱼上报提交确认界面",
            close: function () {
                redirect = '<?php echo str_replace('create','update',Yii::app()->request->getUrl())?>'
                redirect+='&id='+'<?php echo $model->id;?>'
                window.location.href = redirect;
            }
        });
    };
</script>
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
    function AuditDetail3(id=0){
        url = '<?php echo $this->createUrl("UpdateVerify3");?>'
        url +='&id='+id
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'updateDetail',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'100%',
            title:"捕鱼上报查看",
            close: function () {
                redirect = '<?php echo str_replace('create','update',Yii::app()->request->getUrl())?>'
                redirect+='&id='+'<?php echo $model->id;?>'
                window.location.href = redirect;
            }
        });
    };

    $('.article-item').on('click',function (e) {
        if(e.target.localName!=='button'){
            if (e.target.className!=='img'){
                redirect='<?php echo $this->createUrl('update')?>'+'&id='+$(this).data('id')
                window.location.href = redirect;
            }

        }
    })


</script>

