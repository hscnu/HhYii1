
<div class="box">
    <div class="box-content">
        <div class="article-list">

            <div class="flex-center">
            <img class="headpic" src="/Hhyii/static/admin/img/pdf_icon.jpg" alt="error"/>
            </div>
            <div class="flex-center">
            <span><?php echo get_session('TCNAME')?></span>
            </div>
            <div class="item-bar">
                <a class="text" href="<?php echo $this->createUrl('addInfoRz');?>"><h1>入驻申请
                        <span>></span>
                    </h1></a>
            </div>
            <div class="item-bar">
                <a class="text" href="<?php echo $this->createUrl('updateMyInfo');?>"><h1>我的信息
                        <span>></span>
                    </h1></a>
            </div>


        </div>


        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';

</script>
<style>
.item-bar{
    border-bottom: 1px solid grey;
    padding: 10px;
}

.item-bar a h1{
    font-size: 20px;
    font-weight: normal;;
    color: black;

}

.item-bar a h1 span{
    float: right;
    color: grey;
}

.headpic{
    width: 100px;
    height: 100px;
    border-radius: 50%;
}

.flex-center{
    display: flex;
    justify-content: center;
}
</style>