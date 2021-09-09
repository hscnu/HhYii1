
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>信息</h1><span class="back"><a class="btn"
                                                                                           href="javascript:;"
                                                                                           onclick="we.back();"><i
                        class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
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
                        <td colspan="4">申请信息</td>
                    </tr>

                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'title'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_time');?></td>
                        <td colspan="3">
                            <p>年月日:
                            <?php echo $form->textField($model, 'order_time', array('class' => 'Wdate','style'=>'width:100px;','value'=>Date('Y-m-d')));?>
                            <?php echo $form->error($model, 'order_time', $htmlOptions = array());?>
                            </p>
                            时间段:
                            <?php echo $form->textField($model, 'former_time', array('class' => 'Wdate','style'=>'width:80px;','value'=>Date('H:m:s')));?>
                            <?php echo $form->error($model, 'former_time', $htmlOptions = array());?>
                            ~
                            <?php echo $form->textField($model, 'latter_time', array('class' => 'Wdate','style'=>'width:80px;','value'=>Date('H:m:s')));?>
                            <?php echo $form->error($model, 'latter_time', $htmlOptions = array());?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'take_type');?></td>
                        <td colspan="3"><?php echo $form->radioButtonList($model, 'take_type', Chtml::listData(BaseCodeIce::model()->getByType('yes_no'), 'f_name', 'f_name'), array('template' => '<li style="display:inline-block;">{input} {label}</li>','separator' => ' '));?>
                            <?php echo $form->error($model, 'take_type', $htmlOptions = array());?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'order_name'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'order_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'order_tel'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'order_tel', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_tel', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'company'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'company', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'company', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'fishing_boat'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'fishing_boat', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'fishing_boat', $htmlOptions = array()); ?>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'order_destination'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'order_destination', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_destination', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'order_remark'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'order_remark', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_remark', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'longitude'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'longitude', array('class' => 'input-text','id'=>'txtlongitude'));?>
                            <?php echo $form->error($model, 'longitude', $htmlOptions = array());?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"><?php echo $form->labelEx($model, 'latitude'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'latitude', array('class' => 'input-text','id'=>'txtlatitude'));?>
                            <?php echo $form->error($model, 'latitude', $htmlOptions = array());?>
                        </td>
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
                        $str='ice_id,ice_type,specification,unit_price';
                        echo $model2->gridHead($str); ?>
                        <th>数量</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(isset($detailList)){
                        $index1=0;
                        //加载商品种类
                        $typeList = IceType::model()->findAll();
                        $tm=new IceDetail();
                        foreach ($typeList as $v) {
                            $r=0;
                            $w1='order_id='.$model->id.' and ice_id='.$v->id;
                            $tmp=IceDetail::model()->find($w1);
                            if(!empty($tmp)) $r=$tmp->amount;
                            $tm->amount=$r;
                            ?>
                            <tr>
                                <?php echo $v->gridRow($str); ?>
                                <td>
                                    <?php echo $form->textField($tm, 'amount', array('class' => 'input-text','style'=>'width:30px','name'=>'amount_'.$index1++)); ?>
                                    <?php echo $form->error($tm, 'amount', $htmlOptions = array()); ?>
                                </td>
                            </tr>
                        <?php } }?>

                    </tbody>
                </table>
            </div><!--box-table end-->


        <div style="display:block;" class="box-detail-tab-item">
            <tr>
                <td colspan="4">
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title>Title</title>
                        <script src="//api.map.baidu.com/api?type=webgl&v=1.0&ak=GzZOnHTfDPIqhLHTijaeTkadjBFGNzHR"></script>
                    </head>
                    <body>
                    <br/>
        <div style="width:98%;height:340px;border:1px solid gray" id="container"></div>
                    </body>
                    </html>
                </td>
            </tr>
        </div>
        </div>




        </div><!--box-detail-bd end-->

        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->


<script>
    $(function() {
            var $date=$('#<?php echo get_class($model);?>_order_time');
            $date.on('click', function() {
                    WdatePicker( {
                            startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'
                        }
                    );
                }
            );
        }
    );
    $(function() {
            var $date=$('#<?php echo get_class($model);?>_former_time');
            $date.on('click', function() {
                    WdatePicker( {
                            startDate:'%H:%m:%s',dateFmt:'H:m:s'
                        }
                    );
                }
            );
        }
    );
    $(function() {
            var $date=$('#<?php echo get_class($model);?>_latter_time');
            $date.on('click', function() {
                    WdatePicker( {
                            startDate:'%H:%m:%s',dateFmt:'H:m:s'
                        }
                    );
                }
            );
        }
    );
</script>


<script>
    var deleteUrl = '<?php echo $this->createUrl('IceDetail/delete', array('id' => 'ID')); ?>';
    function updateDetail(id=0){
        saveFormDate()
        url = '<?php echo $this->createUrl("OpenDialog");?>'
        url += '&order_id=<?php echo $model->id;?>'//订单的id
        url +='&detail_id='+id//明细的id
        tl= id===0?'添加明细':'修改明细'
        $.dialog.data('id',0)
        $.dialog.open(url,{
            id: 'updateDetail',
            lock:true,opacity:0.3,
            width:'1000px',
            height:'80%',
            title:tl,
            close: function () {
                redirect = '<?php echo str_replace('create','update',Yii::app()->request->getUrl())?>'
                redirect+='&id='+'<?php echo $model->id;?>'
                window.location.href = redirect;
            }
        });
    };

    //打开弹窗前先保存订单一次
    function saveFormDate() {
        let form=$('#active-form').serialize();
        let s1='<?php echo $this->createUrl('SaveFormDate');?>'
        s1=s1+'&'+form+'&id='+'<?php echo $model->id;?>'
        $.ajax({
            url: s1,
            type: 'get',
            dataType: 'json',
        })
    }
</script>

<script>
    var is_empty =0
    lng = 111.988489;
    lat = 21.86434;
    var map = new BMapGL.Map("container");//在指定的容器内创建地图实例
    map.setDefaultCursor("crosshair");//设置地图默认的鼠标指针样式
    map.enableScrollWheelZoom();//启用滚轮放大缩小，默认禁用。
    var locationControl = new BMapGL.LocationControl({
        // 控件的停靠位置（可选，默认右上角）
        anchor: BMAP_ANCHOR_TOP_RIGHT,
        // 控件基于停靠位置的偏移量（可选）
        offset: new BMapGL.Size(10, 10)
    });
    map.addControl(locationControl);

    var point =new BMapGL.Point(lng,lat)
    map.centerAndZoom(point, 15);
    map.addControl(new BMapGL.NavigationControl());
    var marker = new BMapGL.Marker(point);        // 创建标注
    this.map.addOverlay(marker);


    map.addEventListener("click", function(e){//地图单击事件
        map.clearOverlays();
        // 创建点标记
        var marker = new BMapGL.Marker(new BMapGL.Point(e.latlng.lng, e.latlng.lat));
        // 在地图上添加点标记
        map.addOverlay(marker);
        document.getElementById("txtlongitude").value = e.latlng.lng;
        document.getElementById("txtlatitude").value = e.latlng.lat;
    });




</script>

