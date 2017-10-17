{extend name='public:base' /}
{block name='mycss'}
<link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/c-w.css"/>{/block}

{block name="title"} {$seo->title}{/block}
{block name="keywords"} {$seo->keywords}{/block}
{block name="description"} {$seo->description}{/block}
<!--main start -->
{block name='ad'}
<?php if ($row_ad) { ?>
    <div class="product-banner"><a href="{$row_ad->url}"
                                   target="<?php if ($row_ad->new_window == '是') { ?>_blank<?php } ?>"><img
                    src="__IMGURL__{$row_ad->img}" alt="" width="100%"> </a></div>
<?php } else { ?>
    <h1 style='text-align: center;color:red;height:300px;line-height:300px;'>请在后台添加广告图</h1>
<?php } ?>
{/block}

{block name="cont"}
<div class="wapper">
    <p class="wx-fgx"></p>
    <?php foreach($list_ad as $k=>$row_){?>
    <a href="{$row_->url}" target="<?php if ($row_ad->new_window == '是') { ?>_blank<?php } ?>"  class="wx-img-n"><img src="__IMGURL__{$row_->img}" alt=""
                                                        width="1100" height="380"></a>
<?php }?>
</div>

{/block}
