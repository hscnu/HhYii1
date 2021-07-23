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
    var longitude1=<?php echo $longitude; ?>;
    var latitude1=<?php echo $latitude; ?>;
    map.centerAndZoom(new BMapGL.Point(longitude1, latitude1), 15);
    map.enableScrollWheelZoom(true);
    // 创建点标记
    var marker1 = new BMapGL.Marker(new BMapGL.Point(longitude1, latitude1));
    // 在地图上添加点标记
    map.addOverlay(marker1);
</script>