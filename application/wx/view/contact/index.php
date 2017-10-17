{extend name='public:base' /}
{block name='mycss'}<link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/c-w.css" />{/block}

{block name="title"} {$seo->title}{/block}
{block name="keywords"} {$seo->keywords}{/block}
{block name="description"} {$seo->description}{/block}
{block name='contact'}
.logo_bk{
height: 325px;
}
.nav{
bottom:100px;
}
{/block}

{block name="cont"}
<style type="text/css">
    html,body{margin:0;padding:0;}
    .iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
    .iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
<div class="wapper">
    <h2 class="contact-tit">联系我们</h2>
    <div class="contact-box">
        <h3>公司信息</h3>
        <p class="contact-p-1">以大樱桃为主的高品质水果生产企业</p>
        <p class="contact-p-2">山东棒师傅食品科技有限公司</p>
        <p class="contact-p-3">Shandong TOPCHEF FOOD Science and Technology Co.,Ltd</p>
        <p class="contact-p-1">以甜玉米为主的高品质蔬菜、谷物生产企业</p>
        <p class="contact-p-2">吉林祥裕食品有限公司</p>
        <p class="contact-p-3">Jilin XIANGYU Foods Co.,Ltd</p>
        <p class="contact-p-1">棒师傅国内市场运营服务中心</p>
        <p class="contact-p-2">棒师傅(北京)食品有限公司</p>
        <p class="contact-p-3">TOPCHEF (Beijing) Food Co.,Ltd</p>
        <p style="height: 1px; background: #34881a; width: 740px; margin: 25px 0;"></p>
        <p class="contact-p-3">地址：北京市丰台区角门18号未来假日花园一区7-03号</p>
        <p class="contact-p-3">客户服务热线：400-668-2078</p>
        <div class="contact-edit">
            <p style="font-size: 34px; color: #34881a; margin-bottom: 40px;">棒师傅运营中心公交驾车路线说明</p>
           {:session('setting')->bus}
        </div>
        <div style="width:1018px;height:506px;border:#ccc solid 1px;" id="dituContent"></div>
<!--        <p><img class="map-img" src="__PUBLIC__home/images/lx-img-1.png" alt="" width="1018"></p>-->
      <a class="map-a" href="http://ditu.baidu.com/" target="_blank">点击查询路线</a>
    </div>
    <div class="contact-box">
        <h3>销售咨询信息</h3>
        <p class="font-contact">总部销售咨询电话：{:session('setting')->consult_phone}</p>
        <p class="font-contact" style="text-indent: 6em;">传真：{:session('setting')->fax}</p>
<?php foreach($list_seller as $k=>$row_){?>
        <div class="clearfix" style="margin-top: 35px;">
            <img class="lx-img-2" src="__IMGURL__{$row_->img}" alt="" width="260">
            <p class="font-contact lx-img-p"><span>{$row_->name}</span><span>手机：{$row_->mobile}</span></p>
        </div>
        <?php }?>

    </div>
</div>
<script type="text/javascript">
    //创建和初始化地图函数：
    function initMap(){
        createMap();//创建地图
        setMapEvent();//设置地图事件
        addMapControl();//向地图添加控件
        addMarker();//向地图中添加marker
    }

    //创建地图函数：
    function createMap(){
        var map = new BMap.Map("dituContent");//在百度地图容器中创建一个地图
        var point = new BMap.Point(116.381695,39.840992);//定义一个中心点坐标
        map.centerAndZoom(point,18);//设定地图的中心点和坐标并将地图显示在地图容器中
        window.map = map;//将map变量存储在全局
    }

    //地图事件设置函数：
    function setMapEvent(){
        map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
        map.enableScrollWheelZoom();//启用地图滚轮放大缩小
        map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
        map.enableKeyboard();//启用键盘上下左右键移动地图
    }

    //地图控件添加函数：
    function addMapControl(){
        //向地图中添加缩放控件
        var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
        map.addControl(ctrl_nav);
        //向地图中添加缩略图控件
        var ctrl_ove = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:1});
        map.addControl(ctrl_ove);
        //向地图中添加比例尺控件
        var ctrl_sca = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
        map.addControl(ctrl_sca);
    }

    //标注点数组
    var markerArr = [{title:"棒师傅",content:"北京市丰台区角门18号未来假日花园一区7-03号",point:"116.381465|39.841359",isOpen:1,icon:{w:21,h:21,l:0,t:0,x:6,lb:5}}
    ];
    //创建marker
    function addMarker(){
        for(var i=0;i<markerArr.length;i++){
            var json = markerArr[i];
            var p0 = json.point.split("|")[0];
            var p1 = json.point.split("|")[1];
            var point = new BMap.Point(p0,p1);
            var iconImg = createIcon(json.icon);
            var marker = new BMap.Marker(point,{icon:iconImg});
            var iw = createInfoWindow(i);
            var label = new BMap.Label(json.title,{"offset":new BMap.Size(json.icon.lb-json.icon.x+10,-20)});
            marker.setLabel(label);
            map.addOverlay(marker);
            label.setStyle({
                borderColor:"#808080",
                color:"#333",
                cursor:"pointer"
            });

            (function(){
                var index = i;
                var _iw = createInfoWindow(i);
                var _marker = marker;
                _marker.addEventListener("click",function(){
                    this.openInfoWindow(_iw);
                });
                _iw.addEventListener("open",function(){
                    _marker.getLabel().hide();
                })
                _iw.addEventListener("close",function(){
                    _marker.getLabel().show();
                })
                label.addEventListener("click",function(){
                    _marker.openInfoWindow(_iw);
                })
                if(!!json.isOpen){
                    label.hide();
                    _marker.openInfoWindow(_iw);
                }
            })()
        }
    }
    //创建InfoWindow
    function createInfoWindow(i){
        var json = markerArr[i];
        var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>"+json.content+"</div>");
        return iw;
    }
    //创建一个Icon
    function createIcon(json){
        var icon = new BMap.Icon("http://app.baidu.com/map/images/us_mk_icon.png", new BMap.Size(json.w,json.h),{imageOffset: new BMap.Size(-json.l,-json.t),infoWindowOffset:new BMap.Size(json.lb+5,1),offset:new BMap.Size(json.x,json.h)})
        return icon;
    }

    initMap();//创建和初始化地图
</script>
<!--main end -->

{/block}
