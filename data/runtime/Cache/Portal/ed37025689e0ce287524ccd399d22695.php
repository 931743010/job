<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
        body, html {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
        #allmap{width: 600px;
            height: 600px;;}
    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=pOjKwgwxn0nlutaU2ppwIk8p"></script>
    <title>修改公交换乘的起终点图标</title>
</head>
<body>
<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    map.centerAndZoom(new BMap.Point(116.404, 39.915), 12);
    map.enableScrollWheelZoom();
    var start = "魏公村" ,end = "百度大厦";
    var transit = new BMap.TransitRoute(map, {
        renderOptions: {map: map}
    });
    transit.search(start,end);
    var myIcon = new BMap.Icon("http://developer.baidu.com/map/jsdemo/img/location.gif", new BMap.Size(14,23));
    //设置起终点图标
    transit.setMarkersSetCallback(function(result){
        result[0].marker.setIcon(myIcon);
        result[1].marker.setIcon(myIcon);
    })
</script>