<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{block name='title'}index title{/block}</title>
    <meta name="keywords" content="{block name='keywords'}{/block}">
    <meta name="description" content="{block name='description'}{/block}">
    <link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/global.css" />
    <link type="text/css" rel="stylesheet" href="__PUBLIC__home/css/common.css" />
    <script type="text/javascript" src="__PUBLIC__home/js/jquery1.10.2.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__home/js/base.js"></script>
    {block name='mycss'}{/block}
    <style>
        {block name='contact'}{/block}
        #ckepop  .button, #ckepop .jiathis_txt{
            font-size:inherit !important;
        }
        #ckepop  .jtico{
            margin: 0 4px;
        }
    </style>
    <script>
        var jiathis_config = {
            url: "http://bangshifu12138.gotoip11.com/index.php",
            title: "棒师傅(北京)食品有限公司\n",
            summary:"安全、健康、快乐的 美好食品"
        }
        //分享到qq空间
       /* function shareToQq(title,url,picurl){
            //alert()

            var shareqqzonestring='http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?title='+title+'&url='+url+'&pics='+picurl+'&summary=安全、健康、快乐的 美好食品';
            window.open(shareqqzonestring,'newwindow','height=100,width=600,top=200,left=200');
        }*/
        function addGuoShuSite(title, url) {

            try {

                window.external.addFavorite(url, title);

            }

            catch (e) {

                try {

                    window.sidebar.addPanel(title, url, "");

                }

                catch (e) {

                    alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");

                }

            }

        }
    </script>
</head>
<body>
<!-- top欢迎访问 -->
<div class="Top">
    <div class="wapper clearfix">
        <div class="left">&nbsp;&nbsp;&nbsp;欢迎您访问&nbsp;{:session('setting')->sitename}&nbsp;官网</div>
        <div class="right">
            <a href="javascript:void(0);" onclick="addGuoShuSite('棒师傅',location.href)">收藏本站</a>
            <a href="{:url('contact/index')}">联系我们</a>
        </div>
    </div>
</div>


<!-- logo -->
<div class="logo_bk">
    <div class="wapper clearfix">
    <a href="<?php if(empty($row_logo->url)){echo url('index/index');}?>" >
    <img class="left logo" src="__IMGURL__{$row_logo->img}" />
    </a>
        <div class="right hotline">
            全国服务热线<br>{:session('setting')->phone400}
        </div>
    </div>
    {block name='nav'}
    <ul class="nav clearfix">
        <li class="<?php echo request()->controller()=='Index'?"nav_active":''?>"><a href="{:url('index/index')}">首页</a></li>
        <li class="<?php echo request()->controller()=='About'?"nav_active":''?>"><a href="{:url('about/index')}">关于我们</a></li>
        <li class="<?php echo request()->controller()=='Good'?"nav_active":''?>"><a href="{:url('good/index')}">产品中心</a></li>
        <li class="<?php echo request()->controller()=='GoodNew'?"nav_active":''?>"><a href="{:url('good_new/index')}">新品爆品</a></li>
        <li class="<?php echo request()->controller()=='Wx'?"nav_active":''?>"><a href="{:url('wx/index')}">微信动态</a></li>
        <li class="<?php echo request()->controller()=='Contact'&&request()->action()=='index'?"nav_active":''?>"><a href="{:url('contact/index')}">联系我们</a></li>
    </ul>
    {/block}
</div>

{block name='ad'}

{/block}
{block name='cate'}

{/block}
{block name='cont'}
content...
{/block}


<div class="footer">
    <div class="footer_share">
        <div class="wapper clearfix">
            <div class="footer_left">
                为专业用户提供畅销的产品与解决方案<br>
                为直接用户提供<br>
                安全、健康、快乐的 <em style="font-size: 38px;">美好食品</em>
            </div>
            <div class="footer_right">
                <div class="share_div">
                    <?php if(session('setting')->hide_share==0){?>
                 <!--分享到
                    <span class="share_icon weixin_icon" ></span>

                    <span class="share_icon qq_icon" onclick="shareToQq('棒师傅(北京)食品有限公司','http://bangshifu12138.gotoip11.com/index.php','http://bangshifu12138.gotoip11.com/public/static/home/images/logo.png')"></span>

                        <a href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=jkl',u=z||d.location,p=['&url=',e(u),'&title=',e(t||d.title),'&source=',e(r),'&sourceUrl=',e(l),'&content=',c||'gb2312','&pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','http://bangshifu12138.gotoip11.com/public/static/home/images/logo.png','棒师傅(北京)食品有限公司','','utf-8'));"><span class="share_icon weibo_icon"></span></a>-->
                        <!-- JiaThis Button BEGIN -->
                        <div id="ckepop">

                            <a class="jiathis_button_weixin"></a>
                            <a class="jiathis_button_qzone"></a>
                            <a class="jiathis_button_tsina"></a>
                            <a href="http://www.jiathis.com/share/" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                        </div>
                        <script type="text/javascript" src="http://v2.jiathis.com/code/jia.js" charset="utf-8"></script>
                        <!-- JiaThis Button END -->

                    <?php }?><br>
                    免费服务热线：<br>

                <font style="font-size:26px;">{:session('setting')->phone400}</font>
                </div>
                <div class="erweima">
                    <img src="__IMGURL__{$row_qr->img}">
                    <p>欢迎关注微信公众平台</p>
                </div>
            </div>
        </div>
    </div>
    {block name='footer'}
  <a class="top" href="#" title="返回上部"></a>
    <div class="footer_bottom">
        <div class="wapper clearfix">
            <p class="left lineh24">{:session('setting')->cropyright}&nbsp;&nbsp;&nbsp;{:session('setting')->beian}&nbsp;&nbsp;&nbsp;{:session('setting')->designer}</p>
            <div class="left weibo_w">
                <?php if(session('setting')->hide_online==0){?>
                    <a href="javascript:void(0);">
                        <img class=" footer_qq" src="__PUBLIC__home/images/bk_footer_qq.png"/>
                    </a>
                <?php }?>
                <a target="_blank" href="http://weibo.com/topchef2003?topnav=1&wvr=6&topsug=1&is_all=1">
                    <img class=" footer_weibo"  src="__PUBLIC__home/images/bk_footer_weibo.png"/>
                </a>

            </div>

        </div>
    </div>
</div>
</body>

</html>
{/block}
