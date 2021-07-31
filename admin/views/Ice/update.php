
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
                        <td colspan="2">申请信息</td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'order_name'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'order_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_tel'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'order_tel', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_tel', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_time');?></td>
                        <td>
                            <?php echo $form->textField($model, 'order_time', array('class' => 'Wdate','style'=>'width:180px;'));?>
                            <?php echo $form->error($model, 'order_time', $htmlOptions = array());?>
                        </td>
                    </tr>



                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_destination'); ?></td>
                        <td>
                            <html>
                            <head>
                                <title>attestation</title>
                                <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
                                <!--百度地图获取地址-->
                            </head>
                            <body>
                            <div class="container_address" id="container_address_man"></div>
                            <div class="container_address_right">
                                <a id="curCityText" href="javascript:void(0)" onClick="curCityText()"></strong></a>

                                <div>
                                    <strong>纬度：</strong>
                                    <br/>
                                    <?php echo $form->textField($model, 'latitude', array('class' => 'input-text','id'=>'txtlatitude'));?>
                                    <?php echo $form->error($model, 'latitude', $htmlOptions = array());?>
                                </div>
                                <div>
                                    <strong>经度：</strong>
                                    <br/>
                                    <?php echo $form->textField($model, 'longitude', array('class' => 'input-text','id'=>'txtLongitude'));?>
                                    <?php echo $form->error($model, 'longitude', $htmlOptions = array());?>
                                </div>
                                <div>
                                    <strong>标注点所在区域：</strong>
                                    <br/>
                                    <?php echo $form->textField($model, 'order_destination', array('class' => 'input-text','id'=>'txtAreaCode'));?>
                                    <?php echo $form->error($model, 'order_destination', $htmlOptions = array());?>
                                </div>

                                <!--div class="sel_container">
                                  <strong id="curCity" class="curCity">北京市</strong>
                                  <button id="curCityText" href="javascript:void(0)" class="container_address_right_change">更换成市</button>
                                </div-->
                                <div class="map_popup" id="cityList" style="display: none;">
                                    <div class="popup_main">

                                        <div class="cityList" id="citylist_container"></div>
                                        <button id="popup_close"> </button>
                                    </div>
                                </div>
                            </body>
                            <style>
                                .container_address{width: 420px; height: 340px; border: 1px solid gray; float: left;z-index:200;}
                                .container_address_right{float:left;margin-left:15px;width:350px;height:340px;}
                                .container_address_right input{width:340px;height:30px;line-height:30px;border:1px solid #ccc;text-indent:5px;border-radius:2px;}
                                .curCity{border-radius:2px;border:1px solid #ccc;width:80px;height:33px;line-height:33px;top:5px;float:left;text-indent:5px;}
                                .container_address_right_seek{width:60px;height:35px;line-height:35px;border:1px solid #ccc;float:right;}
                                .container_address_right_change{width:80px;float:left;margin-left:5px;height:30px;}
                                .container_address_right div{margin:5px;}
                                .container_address_right div strong{height:30px;line-height:30px;}
                                .map_popup{background:#FFF;margin-top:50px;border:1px solid #ccc;float:left;COLOR:#000;height:300px;overflow-x:hidden;overflow-y:scroll;width:340px;}
                                .popup_main_title{width:100%;font-weight:bold;font-size:16px/20px 黑体;border-bottom:1px solid #f60;line-height:40px;}

                            </style>
                            </html>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_remark'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'order_remark', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'order_remark', $htmlOptions = array()); ?>
                        </td>

                    </tr>
                </table>

                <table>
                    <tr class="table-title">
                        <td colspan="4">冰的类型</td>
                    <tr>
                        <td><?php echo $form->labelEx($model2, 'strip_ice_amount'); ?></td>
                        <td>
                            <?php echo $form->textField($model2, 'strip_ice_amount', array('class' => 'input-text')); ?>条
                            <?php echo $form->error($model2, 'strip_ice_amount', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model2, 'crushed_ice_amount'); ?></td>
                        <td>
                            <?php echo $form->textField($model2, 'crushed_ice_amount', array('class' => 'input-text')); ?>块
                            <?php echo $form->error($model2, 'crushed_ice_amount', $htmlOptions = array()); ?>
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

<script>
    $(function() {
            var $date=$('#<?php echo get_class($model);?>_order_time');
            $date.on('click', function() {
                    WdatePicker( {
                            startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd HH:mm:ss'
                        }
                    );
                }
            );
        }
    );
</script>

<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script> <!--百度地图的文件 -->
<script type="text/javascript" src="http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script> <!--城市选择的-->

<script>
    var map = new BMap.Map("container_address_man");
    map.centerAndZoom(new BMap.Point(111.988489, 21.86434), 15);
    map.addControl(new BMap.NavigationControl());


    map.addEventListener("click", function (e) {
        document.getElementById("txtlatitude").value = e.point.lat;
        document.getElementById("txtLongitude").value = e.point.lng;
        map.clearOverlays();
        var pointMarker = new BMap.Point(e.point.lng, e.point.lat); // 创建标注的坐标
        addMarker(pointMarker);
        geocodeSearch(pointMarker);
    });

    function addMarker(point) {
        var myIcon = new BMap.Icon("mk_icon2.png", new BMap.Size(21, 25),
            { offset: new BMap.Size(21, 21),
                imageOffset: new BMap.Size(0, -21)
            });
        var marker = new BMap.Marker(point, { icon: myIcon });
        map.addOverlay(marker);
    }
    function geocodeSearch(pt) {
        var myGeo = new BMap.Geocoder();
        myGeo.getLocation(pt, function (rs) {
            var addComp = rs.addressComponents;
            document.getElementById("txtAreaCode").value = addComp.province + ", " + addComp.city + ", " + addComp.district+ ", " + addComp.street + ", " + addComp.streetNumber;
        });
    }

    ///Luchec 2015-9-22
    function get_point(){
        var get_lngitude=document.getElementById("txtLongitude").value; //经
        var get_latitude =document.getElementById("txtlatitude").value;//纬
        //alert(get_latitude+","+get_lngitude);
        return get_latitude+","+get_lngitude;

    }
    function get_point_address(){
        var get_address=document.getElementById("txtAreaCode").value; //

        return get_address;

    }
</script>




