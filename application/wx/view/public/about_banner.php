<div class="about-banner">
    <?php if($row_banner){?>
        <a <?php echo \app\common\model\Ad::urlOpen($row_banner->url,$row_banner->new_window)?>><img src="__IMGURL__{$row_banner->img}" alt="" width="100%"></a>
    <?php }else{?>

        <h1 style='text-align: center;color:red'>请在后台添加广告图</h1>
    <?php }?>
</div>