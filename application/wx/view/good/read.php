{extend name='public:base' /}
{block name='mycss'}
<link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/products.css"/>
{/block}
{block name="title"} {$row_good->name}{/block}
{block name='keywords'}{$row_good->name}{/block}
{block name='description'}{$row_good->name}{/block}
<!--main start -->
{block name='nav'}
{/block}
{block name='ad'}
<?php if ($row_ad) { ?>
    <a <?php echo \app\common\model\Ad::urlOpen($row_ad->url,$row_ad->new_window)?> >
        <img style="max-height:218px;width:100%;" src="__IMGURL__{$row_ad->img}">
    </a>
<?php } else { ?>
    <h1 style='text-align: center;color:red;height:300px;line-height:300px;'>请在后台添加广告图</h1>
<?php } ?>


{/block}

{block name='cate'}

{/block}
{block name="cont"}
<a id="cont"></a>
<div class="wapper clearfix" style="margin: 50px auto;">
    <div class="main_left">
        <div class="product_center">
            <h3>产品中心</h3>
            <ul class="clearfix">
                <?php foreach ($list_cate1 as $k => $row_cate) { ?>
                    <a href="{:url('?cate_id='.$row_cate->id)}#cont">
                        <li title="{$row_cate->name}"  class="nohuanhang <?php if ($row_good->cate_id == $row_cate->id) { ?>product-on<?php } ?>">
                            {$row_cate->name}
                        </li>
                    </a>
                <?php } ?>
            </ul>
        </div>
        <div class="product_center">
            <h3>联系我们</h3>
            <div class="aside-bd">
                {:session('setting')->contact}
            </div>
        </div>
    </div>

    <div class="main_center clearfix">

        <div class="main_tit">
            <h3>{$row_good->cate_name}</h3>
            <div class="h3_tit">当前位置： <a href="{:url('index/index')}">首页</a> &gt; <a
                        href="{:url('good/index')}">产品中心</a> &gt; {$row_good->cate_name}
            </div>
        </div>
        <div class="product_cen">
            <img class="product_img" src="__IMGURL__{$row_good->pic}">
            <h4>{$row_good->name}</h4>
            <div class="product_introduce">
                    <?php foreach ($row_good->attr as $k => $row_) { ?>
                        {$row_->attr_name}：{$row_->value}<br>
                    <?php } ?>
                <hr style="height:2px;background: #9acc84;margin: 30px 0;">
                产品特点：<br>
                {$row_good->desc}
            </div>
        </div>

        <div class="product_recommend">
            <h3>产品推荐</h3>
            <div class="wrap-content">
                <div class="product_views">
                    <ul id="product_ul12">
                        <?php foreach ($list_recomment as $k => $row_) { ?>
                        <a href="{:url('?good_id='.$row_->id)}#cont">
                        <li class="<?php if ($row_good->id == $row_->id) { ?>product_viewson<?php } ?>"><img src="__IMGURL__{$row_->img}"></li>
                        </a>
                        <?php } ?>
                    </ul>
                </div>
                <?php if(count($list_recomment)>4){?>
                <span id="bk_top" class="bk_top"></span>
                <span id="bk_bottom" class="bk_bottom"></span>
                <?php }?>
            </div>

        </div>
    </div>
</div>
{/block}
