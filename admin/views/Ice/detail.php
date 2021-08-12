<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>订单明细</h1>
        <?php if($condition==1){?>
            <a class="btn btn-blue" href="javascript:;" onclick="fishery_examine()">审核通过</a>
        <?php } ?>
        <?php if($condition==1){?>
            <a class="btn btn-blue" href="javascript:;" onclick="fishery_examine_back()">退回订单</a>
        <?php } ?>
        <?php if($take_type=='配送'&&$condition==2){?>
            <button class="btn" type="button" onclick="chooseShr(<?php echo $id;?>);">选择送冰员</button>
        <?php } ?>
        <?php if(($take_type=='配送'&&$deliver_name!=NULL)&&$condition==2){?>
            <a class="btn btn-blue" href="javascript:;" onclick="logistics_examine(1)">审核通过</a>
        <?php } ?>
        <?php if($take_type=='自取'&&$condition==2){?>
            <a class="btn btn-blue" href="javascript:;" onclick="logistics_examine(2)">审核通过</a>
        <?php } ?>
        <?php if($condition==2){?>
            <a class="btn btn-blue" href="javascript:;" onclick="logistics_examine_back()">退回订单</a>
        <?php } ?>
    </div><!--box-title end-->
    <div class="box-detail">
        <br class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr>
                        <td>订单编号：</td>
                        <td><?php echo $order_id; ?></td>
                        <td>日期：</td>
                        <td><?php echo $date; ?></td>
                        <td>取冰方式：</td>
                        <td><?php echo $take_type; ?></td>
                    </tr>
                    <tr>
                        <td colspan="1">标题：</td>
                        <td colspan="5"><?php echo $title; ?></td>
                    </tr>
                    <tr>
                        <td>公司/单位：</td>
                        <td><?php echo $company; ?></td>
                        <td>联系人：</td>
                        <td><?php echo $name; ?></td>
                        <td>联系人电话：</td>
                        <td><?php echo $tel; ?></td>
                    </tr>
                    <tr>
                        <td>渔船名称：</td>
                        <td><?php echo $fishing_boat; ?></td>
                        <td>收货地点：</td>
                        <td colspan="3"><?php echo $order_destination; ?></td>
                    </tr>
                    <tr>
                        <td colspan="1">备注：</td>
                        <td colspan="5"><?php echo $order_remark; ?></td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end   style="display:block;"-->

            <div class="box-table">
                <table class="list">
                    <thead>
                    <tr>
                        <!--                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>-->
                        <?php $model2 = IceDetail::model();?>
                        <?php
                        $str='ice_number,ice_type,specification,unit_price';
                        echo $model2->gridHead($str); ?>
                        <th>数量</th>
                        <th>备注</th>
                        <th>总额</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(isset($ice_detail)){
                        $index1=0;
                        $index2=0;
                        foreach ($ice_detail as $v) { ?>
                            <tr>
                                <?php echo $v->gridRow($str); ?>
                                <td>
                                    <?php echo $v->amount; ?>
                                </td>
                                <td>
                                    <?php echo $v->remark; ?>
                                </td>
                                <td>
                                    <?php echo $v->total_price; ?>
                                </td>
                            </tr>
                        <?php } }?>

                    </tbody>
                </table>
            </div><!--box-table end-->
            <br/>
            <div>
                <ul style="display: inline-block;width:30%;text-align: left;">
                    <span style="font-size:15px;font-weight:bold;">配送人：</span>
                    <?php echo $deliver_name; ?>
                </ul>
                <ul style="display: inline-block;width:30%;text-align: center;">
                    <span style="font-size:15px;font-weight:bold;">收货人：</span>
                    <?php echo $receiver_name; ?>
                </ul>
                <ul style="display: inline-block;width:30%;text-align: right;">
                    <span style="font-size:15px;font-weight:bold;">审核人：</span>
                    <?php echo $checker_name; ?>
                </ul>

            </div>
        </div><!--box-detail-bd end-->

    </div><!--box-detail end-->
</div><!--box end-->
<script>
    function fishery_examine(){
        url = '<?php echo $this->createUrl("ChangeState",array('id'=>$id,'Now_state'=>'渔业审核通过'));?>'
        $.ajax(
            {
                url:url,
                type:'post',
                success:function (data){
                    alert('审核通过');
                    we.reload();
                },
            }
        )
    }
    function fishery_examine_back(){
        url = '<?php echo $this->createUrl("ChangeState",array('id'=>$id,'Now_state'=>'渔业退回订单'));?>'
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
    function logistics_examine(condition){
        if(condition==1){
            url = '<?php echo $this->createUrl("ChangeState",array('id'=>$id,'Now_state'=>'物流配送审核通过'));?>'
        }
        if(condition==2){
            url = '<?php echo $this->createUrl("ChangeState",array('id'=>$id,'Now_state'=>'物流自取审核通过'));?>'
        }
        $.ajax(
            {
                url:url,
                type:'post',
                success:function (data){
                    alert('审核通过');
                    we.reload();
                },
            }
        )
    }
    function logistics_examine_back(){
        url = '<?php echo $this->createUrl("ChangeState",array('id'=>$id,'Now_state'=>'物流退回订单'));?>'
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
<script>
    function chooseShr(id){
        url = '<?php echo $this->createUrl("OpenDialogShr");?>'
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'chooseShr',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:'选择送冰员',
            close: function () {
                if($.dialog.data('id')>0){
                    s1='<?php echo $this->createUrl('SetShrIdAndName')?>'
                    s1=s1+'&shrId='+$.dialog.data('id')+'&oId='+id
                    $.ajax({
                        type: 'get',
                        url: s1,
                        dataType: 'json',
                        success: function(data){
                            alert('成功指派');
                            we.reload()
                        },

                    });
                }
            }

        });
    };
</script>
