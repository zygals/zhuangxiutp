{extend name='public:base' /}
{block name='mycss'}
<link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/products.css"/>{/block}

{block name="title"} {$seo->title}{/block}
{block name="keywords"} {$seo->keywords}{/block}
{block name="description"} {$seo->description}{/block}
<!--main start -->
{block name='ad'}
<?php if ($row_ad) { ?>
    <div class="product-banner">

        <a <?php echo \app\common\model\Ad::urlOpen($row_ad->url, $row_ad->new_window) ?>>

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
<div class="nav-2 clearfix" id="cate1">
    <?php if (count($list_cate1) > 0) { ?>
        <?php foreach ($list_cate1 as $k => $cate) { ?>
            <a href="#good{$cate->id}" <?php echo $k == 0 ? "class='on'" : ''; ?> >{$cate->name}</a>
        <?php } ?>
    <?php } else { ?>
        <h1 style='text-align: center;color:red'>请在后台添加分类 </h1>
    <?php } ?>
</div>
{/block}
{block name="cont"}
<!-- 系列 -->
<?php if (count($list_cate1) > 0) { ?>
    <?php foreach ($list_cate1 as $k => $cate) { ?>
        <a id="good{$cate->id}"></a>
        <div class="<?php echo $k % 2 == 0 ? 'bk_fff' : 'gr_fff' ?>">

            <div class="wapper clearfix">
                <div class="bk_tit">
                    <h4>{$cate->name}</h4>
                    <h3>|&nbsp;{$cate->slogan} &nbsp;|</h3>
                    {$cate->desc}
                </div>
            </div>
            <?php if (count($cate['goods']) < 5) { ?>
                <div class="wapper less4">
                    <ul class="product_ul first_bk clearfix">
                        <?php foreach ($cate['goods'] as $k2 => $good) { ?>
                            <li><a href="{:url('good/read')}?good_id={$good->id}" ><img src="__IMGURL__{$good->img}"></a><span title="{$good->name}" class="nohuanhang" style="width:100%">{$good->name}</span></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } else { ?>
                <div class="wapper position_bk">
                    <div class="swipe-content">
                        <ul id='product_ul{$cate->id}' class="product_ul two_bk">
            <?php foreach ($cate['goods'] as $k2 => $good) { ?>
                <li><a target="_blank" href="{:url('good/read')}?good_id={$good->id}"><img src="__IMGURL__{$good->img}"></a><span>{$good->name}</span></li>
            <?php } ?>
                        </ul>
                    </div>
                    <span id="bk_left{$cate->id}" class="bk_left"></span>
                    <span id="bk_right{$cate->id}" class="bk_right"></span>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
<?php } else { ?>
    <h1 style='text-align: center;color:red'>请在后台添加分类 </h1>
<?php } ?>
<!-- 零售果干系列 -->

<script>
    // 产品横向列表滚动
    function picScroll(list,bkLeft,bkRight) {
        var $list=$(list);
        var wid = 960+'px';
        var len = $list.find('li').length;
        var page= 1;
        var i = 4;
        var page_count =Math.ceil(len/i);

        $(bkLeft).hide();

        $(bkLeft).on('click',function () {
            $(bkRight).show();
            if(!$list.is(":animated")){
                $list.animate({left:"+="+wid},300);
                page--;
                if(page<=1) {
                    $(bkLeft).hide();
                    $(bkRight).show();
                }
            }
        })
        $(bkRight).on('click',function () {
            $(bkLeft).show();
            if(!$list.is(":animated")){
                $list.animate({left:"-="+wid},300);
                page++;
                if(page >= page_count){
                    $(bkRight).hide();
                }
            }
        })

    };
    <?php foreach($list_cate1 as $k=>$row_){?>

    picScroll('#product_ul{$row_->id}','#bk_left{$row_->id}','#bk_right{$row_->id}');

    <?php }?>

    $('#cate1 a').click(function () {
        //alert()
        $(this).siblings().removeClass('on');
        $(this).addClass('on');
    });
    $('.nav-2').hover(function () {
        this.style.height='auto';
    },function () {
        this.style.height='76px';
    });
</script>
{/block}
