{extend name='public:base' /}
{block name='mycss'}
<link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/explosion.css"/>{/block}


{block name="title"} {$seo->title}{/block}
{block name="keywords"} {$seo->keywords}{/block}
{block name="description"} {$seo->description}{/block}
<!--main start -->
{block name='ad'}

<?php if ($row_ad) { ?>
    <div class="product-banner">

        <a href="{$row_ad->url}" target="<?php if($row_ad->new_window=='是'){?>_blank<?php }?>">

            <img src="__IMGURL__{$row_ad->img}" alt="" width="100%">
        </a>
    </div>
<?php } else { ?>
    <div class="product-banner">
        <h1 style='text-align: center;color:red;height:300px;line-height:300px;'>请在后台添加广告图</h1>
    </div>
<?php } ?>
{/block}

{block name='cate'}
<div class="nav-2 clearfix" id="cate2">

    <?php if (count($list_cate2) > 0) { ?>
        <?php foreach ($list_cate2 as $k => $cate) { ?>
            <a href="#cate{$cate->id}" <?php echo $k == 0 ? "class='on'" : ''; ?> >{$cate->name}</a>
        <?php } ?>
    <?php } else { ?>
        <h1 style='text-align: center;color:red'>请在后台添加分类 </h1>
    <?php } ?>

</div>
{/block}
{block name="cont"}
<div class="wapper">
    <p class="about-fgx"></p>
    <?php if (count($list_cate2) > 0) { ?>
        <?php foreach ($list_cate2 as $k => $cate) { ?>
            <a id="cate{$cate->id}"></a>
            <a target="_blank" href="{:url('read?cate_id='.$cate->id)}">

                <img src="__IMGURL__{$cate->img}" alt="" height="380" width="100%">


                <div class="explosion_test">
                    <h3>{$cate->name}</h3>
                    {$cate->desc}
                </div>
            </a>
        <?php } ?>
    <?php } else { ?>
        <h1 style='text-align: center;color:red'>请在后台添加分类 </h1>
    <?php } ?>


</div>
<!--main end -->
<script>
    $('#cate2 a').click(function () {
        //alert()
        $(this).siblings().removeClass('on');
        $(this).addClass('on');
    });
    $('.nav-2').hover(function () {
        this.style.height='auto';
    },function () {
        this.style.height='39px';
    });
</script>
{/block}
