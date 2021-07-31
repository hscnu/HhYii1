<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>订单明细</h1>
        <a class="btn btn-blue" href="javascript:;" onclick="examine()">审核通过</a>
    </div><!--box-title end-->
        <div class="box-detail">
                <table>
                    <tr class="table-title">
                        <td colspan="6">信息</td>
                    </tr>
                    <tr>
                        <td>联系人姓名</td>
                        <td>
                            <?php echo $name; ?>
                        </td>
                        <td>联系人电话</td>
                        <td><?php echo $tel;?></td>
                        <td>收货时间</td>
                        <td><?php echo $date;?></td>
                    </tr>
                    <tr class="table-title">
                        <td colspan="6">商品</td>
                    </tr>
                </table>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    function examine(){
        url = '<?php echo $this->createUrl("ChangeState",array('id'=>$id,'Now_state'=>'审核通过'));?>'
        $.ajax(
            {
                url:url,
                type:'post',
                success:function (data){
                    we.close();
                },
            }
        )
    }
</script>
