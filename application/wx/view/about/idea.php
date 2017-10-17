{extend name='public:base' /}
{block name='mycss'}<link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/about.css" />{/block}
{block name="title"} {$seo->title}{/block}
{block name="keywords"} {$seo->keywords}{/block}
{block name="description"} {$seo->description}{/block}
<!--main start -->
{block name='ad'}
<div class="about-banner"><img src="__PUBLIC__home/images/about-banner.jpg" alt="" width="100%"></div>
{/block}

{block name='cate'}
<a id="cont"></a>
{include file="public/about_nav" /}

{/block}

{block name="cont"}
<div class="wapper">
    <p class="about-fgx"></p>
    <p class="jj-p">企业理念</p>
    <p class="about-fgx"></p>
    <h3 class="ln-t"><span>企业使命</span></h3>
    <p class="jj-p">为专业用户提供畅销的产品与解决方案，<br>为直接用户提供<br>安全、健康、快乐的美好食品</p>
    <h3 class="ln-t"><span>企业愿景</span></h3>
    <p class="jj-p">成为果蔬食品领先企业</p>
    <h3 class="ln-t"><span>核心理念</span></h3>
    <p class="jj-p">实干兴业，共创美好生活</p>
</div>
<?php if ($row_ad) { ?>
    <div class="about-con-img"> <a <?php echo \app\common\model\Ad::urlOpen($row_ad->url,$row_ad->new_window);?>><img src="__IMGURL__{$row_ad->img}" alt="" width="100%">    </a></div>

<?php } else { ?>
    <h1 style='text-align: center;color:red;height:300px;line-height:300px;'>请在后台添加广告图</h1>
<?php } ?>

{/block}
