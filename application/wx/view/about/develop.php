{extend name='public:base' /}
{block name='mycss'}<link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/about.css" />{/block}
{block name="title"} {$seo->title}{/block}
{block name="keywords"} {$seo->keywords}{/block}
{block name="description"} {$seo->description}{/block}
<!--main start -->
{block name='ad'}
{include file="public/about_banner" /}
{/block}

{block name='cate'}
<a id="cont"></a>
{include file="public/about_nav" /}

{/block}

{block name="cont"}

<div class="wapper">
    <p class="about-fgx"></p>
    <p class="fzlc-p">企业发展历程</p>
    <p class="fzlc-p">DEVELOPMENT HISTORY</p>

    <?php if($row_ad){?>
        <p><img src="__IMGURL__{$row_ad->img}" alt="" width="1114"></p>
    <?php }else{?>

        <h1 style='text-align: center;color:red'>请在后台添加发展历程广告图</h1>
    <?php }?>


</div>
{/block}
