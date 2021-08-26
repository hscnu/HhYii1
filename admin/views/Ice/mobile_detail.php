<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>订单明细</h1>
        <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
    </div><!--box-title end-->
    <div class="box-detail">
        <br class="box-detail-bd">
        <div style="display:block;" class="box-detail-tab-item">
            <table>
                <tr>
                    <td>订单编号：</td>
                    <td><?php echo $order_model->order_id; ?></td>
                </tr>
                <tr>
                    <td>日期：</td>
                    <td><?php echo $order_model->order_time; ?></td>
                </tr>
                <tr>
                    <td>取冰方式：</td>
                    <td><?php echo $order_model->take_type; ?></td>
                </tr>
                <tr>
                    <td colspan="1">标题：</td>
                    <td colspan="1"><?php echo $order_model->title; ?></td>
                </tr>
                <tr>
                    <td>公司/单位：</td>
                    <td><?php echo $order_model->company; ?></td>
                </tr>
                <tr>
                    <td>联系人：</td>
                    <td><?php echo $order_model->order_name; ?></td>
                </tr>
                <tr>
                    <td>联系人电话：</td>
                    <td><?php echo $order_model->order_tel; ?></td>
                </tr>
                <tr>
                    <td>渔船名称：</td>
                    <td><?php echo $order_model->fishing_boat; ?></td>
                </tr>
                <tr>
                    <td>收货地点：</td>
                    <td colspan="1"><?php echo $order_model->order_destination; ?></td>
                </tr>
                <tr>
                    <td colspan="1">备注：</td>
                    <td colspan="1"><?php echo $order_model->order_remark; ?></td>
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
                <?php echo $order_model->deliver_name; ?>
            </ul>
            <ul style="display: inline-block;width:30%;text-align: center;">
                <span style="font-size:15px;font-weight:bold;">收货人：</span>
                <?php echo $order_model->receiver_name; ?>
            </ul>
            <ul style="display: inline-block;width:30%;text-align: right;">
                <span style="font-size:15px;font-weight:bold;">审核人：</span>
                <?php echo $order_model->checker_name; ?>
            </ul>

        </div>
        <br/>
        <br/>
    </div><!--box-detail end-->
</div><!--box end-->
