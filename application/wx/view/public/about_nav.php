
<div class="nav-2 clearfix">
    <a <?php echo request()->controller()=='About' && request()->action()=='index'?"class='on'":''?> href="{:url('about/index')}#cont">企业简介</a>
    <a <?php echo request()->controller()=='About' && request()->action()=='idea'?"class='on'":''?> href="{:url('about/idea')}#cont">企业理念</a>
    <a <?php echo request()->controller()=='About' && request()->action()=='develop'?"class='on'":''?> href="{:url('about/develop')}#cont">发展历程</a>
    <a <?php echo request()->controller()=='About' && request()->action()=='recruit'?"class='on'":''?> href="{:url('about/recruit')}#cont">招贤纳士</a>
</div>