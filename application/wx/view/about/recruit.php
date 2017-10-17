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
<div class="wapper clearfix">
    <div class="left aside">
        <div class="aside-box">
            <h2>招贤纳士</h2>
            <div class="aside-menu">
                <?php foreach($list_recruit as $k=>$row_){?>
                <a href="{:url('recruit?id='.$row_->id)}#cont" <?php echo (request()->param('id')==$row_->id || (request()->param('id')==null && $k==0))?"class='on'":''?>>{$row_->name}</a>
               <?php }?>
            </div>
        </div>
        <div class="aside-box">
            <h2>联系我们</h2>
            <div class="aside-bd">
               {:session('setting')->contact}
            </div>
        </div>
    </div>
    <div class="right con-side">
        <div class="clearfix">
            <div class="left zw-tit">{$row_recruit->name}</div>
            <div class="right gx-time">更新时间：{$row_recruit->update_time}</div>
        </div>
        <div class="con-side-box">
            <h3>岗位职责：</h3>
            <div class="con-side-edit">
               <?php if($row_recruit->duty){?>
                   {$row_recruit->duty}
                <?php }else{?>
                   <h1 style='text-align: center;color:red'>请在后台添加招聘岗位职责</h1>
                <?php }?>
            </div>
            <div style="height: 2px; background: #9acc84; margin: 35px auto;"></div>
            <h3>任职资格：</h3>
            <div class="con-side-edit">
                <?php if($row_recruit->zige){?>
                    {$row_recruit->zige}
                <?php }else{?>
                    <h1 style='text-align: center;color:red'>请在后台添加招聘任职资格</h1>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<!--main end -->

{/block}
