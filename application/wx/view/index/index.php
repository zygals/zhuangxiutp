{extend name='public:base' /}
{block name='mycss'}
<link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/index.css" />
<link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/component.css" />
{/block}

{block name="title"} {$seo->title}{/block}
{block name="keywords"} {$seo->keywords}{/block}
{block name="description"} {$seo->description}{/block}

{block name='ad'}
<div class="container">
    <!-- Top Navigation -->
    <div id="boxgallery" class="boxgallery" data-effect="effect-1">
        <?php foreach($list_ad as $k=>$row_){?>
        <a <?php echo \app\common\model\Ad::urlOpen($row_->url,$row_->new_window)?>><div class="panel"> <img src="__IMGURL__{$row_->img}" alt="image not exists"/> </div></a>
        <?php }?>
    </div>
</div>
<!-- 以前轮播 -->
<!--<div class="index_banner"">

<ul class="img_list">

    <?php foreach($list_ad as $k=>$row_){?>
  <li class="slider-item">
        <a <?php /*echo \app\common\model\Ad::urlOpen($row_->url,$row_->new_window)*/?>>
            <img style="width:100%;height:100%;" src="__IMGURL__{$row_->img}" alt="">
        </a>
    </li>
    <?php }?>

</ul>--><!--
<ul class="dot_list">
    <?php foreach($list_ad as $k=>$row_){?>
    <i class="indicator-btn --><?php //if($k==0){?><!--active--><?php //}?><!--"></i>
    <?php }?>
</ul>
</div>-->
{/block}

{block name="cont"}
<!-- 企业简介 -->
<div class="wapper profile clearfix">
    <div class="wrapper_tit">
        <h3>企业简介</h3>
        <hr></hr>
        <h6>Company profile</h6>
    </div>
    <p class="main_p">
        TOPCHEF棒师傅创始于2002年<br>
        经营定位：植根优质原料产地，针对中国餐饮、烘焙专业用户需求，研发生产高品质的果蔬食品与应用解决方案。<br>
        目前旗下共有两家生产企业与一家市场运营公司：<br>
        山东棒师傅食品科技有限公司 ——  国内首家大樱桃深加工企业  中国最大的樱桃深加工企业<br>
        吉林祥裕食品有限公司 —— 国内领先的甜玉米加工企业<br>
        棒师傅（北京）食品有限公司 —— 国内市场运营服务中心
    </p>
    <ul class="profile_ul clearfix">
        <li><img src="__PUBLIC__home/images/profile1.png"></li>
        <li><img src="__PUBLIC__home/images/profile2.png"></li>
        <li><img src="__PUBLIC__home/images/profile3.png"></li>
        <li><img src="__PUBLIC__home/images/profile4.png"></li>
        <li><img src="__PUBLIC__home/images/profile5.png"></li>
    </ul>
    <a href="{:url('about/index')}" class="more">
        <span class="more_icon"></span><br>
        <div class="more_test">
            <span style="font-size: 22px;line-height:20px;">更多内容</span><br>
            <span>READ MORE</span>
        </div><br>
        <span class="more_hr"></span>
    </a>
</div>
<!-- 产品中心 -->
<div class="wapper clearfix" style="position: relative;">
    <div class="wrapper_tit">
        <h3>产品中心</h3>
        <hr></hr>
        <h6>products</h6>
    </div>
    <ul class="products_ul clearfix">
<?php foreach($list_good as $k=>$row_){?>
    <a href="{:url('good/read?good_id='.$row_->id)}">
        <li><img src="__IMGURL__{$row_->img_index}"><span style="width:201px;" class="nohuanhang">| {$row_->name} |</span></li>
<?php }?>
    </ul>
    <a href="{:url('good/index')}" class="more">
        <span class="more_icon"></span><br>
        <div class="more_test">
            <span style="font-size: 22px;line-height:20px;">更多内容</span><br>
            <span>READ MORE</span>
        </div><br>
        <span class="more_hr"></span>
    </a>
    <!-- 左箭头 -->
    <a class="products_left" href="javascript:void(0);"></a>
    <!-- 右箭头 -->
    <a class="products_right" href="javascript:void(0);"></a>
</div>

<!-- 爆品系列应用 -->
<div class="selling">
    <div class="wapper clearfix">
        <div class="wrapper_tit">
            <div style="height: 1px;"></div>
            <h3>爆品系列应用</h3>
            <hr></hr>
            <h6>Best-selling products</h6>
        </div>
        <p class="main_p">
            甜玉米种植于世界三大黄金玉米带——中国吉林；<br>
            红腰豆种植于北纬45°肥沃黑土地优质产区。<br>
            精选应季新鲜果蔬原料加工而成，不含香精、色素、防腐剂。
        </p>
        <ul class="selling_ul clearfix">
            <?php foreach($list_new as $k=>$row_){?>
                <li><a href="{:url('good_new/read?cate_id='.$row_->id)}"><img style="width:380px;height:172px;border-radius:10px;" src="__IMGURL__{$row_->img}"><span>|&nbsp;{$row_->name} &nbsp;|</span></a>></li>
           <?php }?>
        </ul>
        <a href="{:url('good_new/index')}" class="more">
            <span class="more_icon"></span><br>
            <div class="more_test">
                <span style="font-size: 22px;line-height:20px;">更多内容</span><br>
                <span>READ MORE</span>
            </div><br>
            <span class="more_hr"></span>
        </a>
    </div>
</div>

<!-- 微信动态 -->
<div class="wapper wechat clearfix">
    <div class="wrapper_tit">
        <h3>微信动态</h3>
        <hr></hr>
        <h6>WeChat</h6>
    </div>
    <ul class="wechat_ul clearfix">
        <?php foreach($list_wc as $k=>$row_){?>
        <li><a <?php echo \app\common\model\Ad::urlOpen($row_->url,$row_->new_window);?>><img src="__IMGURL__{$row_->img}">{$row_->title}  </a></li>

        <?php }?>
    </ul>
    <a <?php echo \app\common\model\Ad::urlOpen($row_->url,$row_->new_window);?>">
    <img src="__IMGURL__{$row_wc->img}" style="margin: 20px 0 5px;">
    </a>
    <a href="{:url('wx/index')}" class="more">
        <span class="more_icon"></span><br>
        <div class="more_test">
            <span style="font-size: 22px;line-height:20px;">更多内容</span><br>
            <span>READ MORE</span>
        </div><br>
        <span class="more_hr"></span>
    </a>
</div>

<!-- 合作客户 -->
<div class="customer">
    <div class="wapper clearfix">
        <div style="height: 1px;"></div>
        <div class="wrapper_tit">
            <h3>合作客户</h3>
            <hr></hr>
            <h6>Customer</h6>
        </div>
        <ul class="customer_ul clearfix">
            <?php foreach($list_friend as $k=>$row_){?>
                <li><a href="{$row_->url}" target="_blank"><img src="__IMGURL__{$row_->logo}"></a></li>
            <?php }?>
        </ul>
    </div>
</div>
<script src="__PUBLIC__home/js/classie.js"></script>
<script src="__PUBLIC__home/js/modernizr.custom.js"></script>
<script src="__PUBLIC__home/js/boxesfx.js"></script>

<script>
    new BoxesFx( document.getElementById( 'boxgallery' ) );
</script>
<!-- footer -->
{/block}