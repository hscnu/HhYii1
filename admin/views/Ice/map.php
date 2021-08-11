<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>添加点标记</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <style>
        body,
        html,
        #container {
            overflow: hidden;
            width: 100%;
            height: 100%;
            margin: 0;
            font-family: "微软雅黑";
        }
    </style>
    <script src="//api.map.baidu.com/api?type=webgl&v=1.0&ak=GzZOnHTfDPIqhLHTijaeTkadjBFGNzHR"></script>
</head>
<body>
<div id="container"></div>
</body>
</html>
<script>

    var map = new BMapGL.Map('container');
    var longtitude=<?php echo $longitude ?>;
    var latitude=<?php echo $latitude ?>;
    map.centerAndZoom(new BMapGL.Point(longtitude, latitude), 15);
    // 创建定位控件
    var locationControl = new BMapGL.LocationControl({
        // 控件的停靠位置（可选，默认左上角）
        anchor: BMAP_ANCHOR_TOP_RIGHT,
        // 控件基于停靠位置的偏移量（可选）
        offset: new BMapGL.Size(0, 0)
    });
    var desitination=new BMapGL.Point(longtitude, latitude);
    //创建文本框
    var label = new BMapGL.Label('送货位置',{
        position: desitination, // 指定文本标注所在的地理位置
        offset: new BMapGL.Size(0, 0) // 设置文本偏移量
    });

    //订单送货位置点
    var marker = new BMapGL.Marker(new BMapGL.Point(longtitude, latitude));
    map.addControl(locationControl);
    map.enableScrollWheelZoom(true);
    map.addOverlay(marker);
    map.addOverlay(label);
    dingwei();

    //当前位置的获取
    function dingwei() {
        var geolocation = new BMapGL.Geolocation();
        geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                var mk = new BMapGL.Marker(r.point);
                //创建文本框
                var label2 = new BMapGL.Label('当前位置',{
                    position: r.point, // 指定文本标注所在的地理位置
                    offset: new BMapGL.Size(0, 0) // 设置文本偏移量
                });
                map.addOverlay(mk);
                map.addOverlay(label2);
                var p1 = [r.point.lng, r.point.lat];
                var p2 = [desitination.lng, desitination.lat];
                var distance=calMeter(p1,p2);
                var label3 = new BMapGL.Label(distance,{
                    position: r.point, // 指定文本标注所在的地理位置
                    offset: new BMapGL.Size(0, 20) // 设置文本偏移量
                });
                map.addOverlay(label3);
            }
            else {
                console.log('获取失败');
            }
        });
    }

    function calMeter(p1, p2) {
        var myP1 = new BMapGL.Point(p1[0], p1[1]);    //起点
        var myP2 = new BMapGL.Point(p2[0], p2[1]);    //终点
        return('两点之间的距离：' + (map.getDistance(myP1, myP2)).toFixed(2) + '米');
    }

</script>