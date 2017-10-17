{extend name='public:base' /}
{block name='mycss'}<link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/bp.css" />{/block}

{block name="title"} {$list_good_new[0]->name|default=''}{/block}
{block name='keywords'}{$list_good_new[0]->name|default=''}{/block}
{block name='description'}{$list_good_new[0]->name|default=''}{/block}
<!--main start -->
{block name='nav'}
{/block}
{block name='ad'}

<?php if ($row_ad) { ?>

<div class="xpbk-banner">
        <a href="{$row_ad->url}" target="<?php if($row_ad->new_window=='是'){?>_blank<?php }?>">
           <img src="__IMGURL__{$row_ad->img}" alt="" width="100%">
        </a>
    </div>
<?php } else { ?>
<div class="xpbk-banner">
    <h1 style='text-align: center;color:red'>请在后台添加广告图</h1>
</div>
<?php }?>
{/block}

{block name='cate'}
<a id="cont"></a>
<div class="wapper clearfix">
<!--    <a class="nav-L" href="javascript:void(0);"></a>-->
    <div class="nav-2 clearfix">
        <?php foreach($list_cate2 as $k=>$row_){?>
        <a class="<?php echo $row_->id==request()->param('cate_id')?'on':''?>" href="{:url('?cate_id='.$row_->id)}#cont">{$row_->name}</a>
        <?php }?>
    </div>
<!--    <a class="nav-R" href="javascript:void(0);"></a>-->
</div>
{/block}
{block name="cont"}
<div class="wapper">
    <div class="dqwz-box">当前位置： <a href="{:url('index/index')}">首页</a> >  <a href="{:url('good_new/index')}">新品爆款</a> > {$row_cate->name}</div>
    <?php foreach($list_good_new as $k=>$row_){?>
    <div class="bk-box">
        <h2 class="bk-box-tit">{$row_->name}</h2>
        <img class="bk-img-big" src="__IMGURL__{$row_->img_top}" alt="" width="1100">
        <div class="clearfix">
            <img class="bk-img-big" src="__IMGURL__{$row_->img_bottom}" alt="" width="1100">

        </div>
    </div>
    <?php }?>
    <script>
        $('.nav-2').hover(function () {
            this.style.height='auto';
        },function () {
            this.style.height='39px';
        });
    </script>

</div>
<!--main end -->
{/block}
