<!doctype html>
<html lang="ch">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="花卉管理">
    <meta name="keywords" content="花卉管理 花卉管理 花卉管理 ">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>{block name='title'}分类管理{/block}</title>
    <link rel="stylesheet" href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/slide.css"/>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="__PUBLIC__/css/bootstrapValidator.min.css"/>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/flat-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/jquery.nouislider.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/bootstrapValidator.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="__PUBLIC__/js/respond.min.js"></script>
    <script>
        jQuery(function ($) {
            $.datepicker.regional['zh-CN'] = {
                closeText: '关闭',
                prevText: '<上月',
                nextText: '下月>',
                currentText: '今天',
                monthNames: ['一月', '二月', '三月', '四月', '五月', '六月',
                    '七月', '八月', '九月', '十月', '十一月', '十二月'],
                monthNamesShort: ['一', '二', '三', '四', '五', '六',
                    '七', '八', '九', '十', '十一', '十二'],
                dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
                dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
                dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
                weekHeader: '周',
                dateFormat: 'y-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: true,
                yearSuffix: '年'
            };
            $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
            $(".date_input").datepicker();
        });
    </script>
    <style>
        .pagination li.disabled>a, .pagination li.disabled>span{color:inherit;}
        .pagination li>a, .pagination li>span{color:inherit}
    </style>
</head>

<body>
<div id="wrap" style="padding-bottom: 50px;height:15000px;">
    <!-- 左侧菜单栏目块 -->
    {block name="menu_left"}
    <div class="leftMeun" id="leftMeun">
        <div id="logoDiv">
            欢迎使用55+后台
            <p id="logoP">
                <a href="{:url('index/clear_cache')}">
                    <button class="alert btn-xs">清理服务器缓存</button>
                </a>
            </p>
        </div>
        <div id="personInfor">
            <p id="userName">{php} if(session('admin_zhx'))echo session('admin_zhx')->name{/php} <a
                        href="{:Url('admin/logout')}">&nbsp;&nbsp;&nbsp;&nbsp;退出登录</a></p>
<!--            <p><a href="{:Url('gshpc/index/index')}" target="_blank">前台</a></p>-->
			<?php /*if(\app\back\model\Admin::isAdmin()){*/?><!--
            <p><a href="{:Url('menu_admin/index')}">管理菜单</a></p>
--><?php /*}*/?>
            <p><a href="{:Url('index/index')}">登录日志</a></p>
            <?php if(\app\back\model\Admin::isAdmin()){?>
            <p> <a href="__PUBLIC__/bake.php">备份数据库</a></p>
<?php }?>
            <?php if(\app\back\model\Admin::isShopAdmin()){ ?>
                <p>我的收益:　<?php echo(\app\back\model\Dingdan::getConfirmOrderSum(session('admin_zhx')->id) )?>元</p>
                <p>成功提现:　<?php echo(\app\back\model\Admin::getwithdrawok()) ?>元</p>
                <p>可提现:　<?php echo(\app\back\model\Admin::getketixian()) ?>元</p>
                <?php if(($lock_income = \app\back\model\Admin::getBenefitLock()) >0 ){?>
                    <p>冻结总额:　<?php echo $lock_income ;?>元</p>
                <?php }?>
                <p><a href="{:Url('withdraw/edit')}">申请提现</a></p>
            <?php }?>

        </div>
        <?php if(\app\back\model\Admin::isGeneral()){  $list_menu = \app\back\model\MenuAdmin::getListNormal();?>
            <div class="meun-title">我的管理</div>
            <?php foreach ($list_menu as $k2 => $row_menu) { ?>
                <div class="meun-item <?php
                if (request()->controller() == $row_menu->controller && request()->action() == $row_menu->action )echo 'meun-item-active ';
                ?>">
                    <a href="<?php echo Url($row_menu->controller . '/' . $row_menu->action, $row_menu->param) ?>"><img
                                src="__PUBLIC__/images/icon_user_grey.png">{$row_menu->name}</a></div>
            <?php } ?>
        <?php }else{ $list_first_menu = \app\back\model\MenuAdmin::getList() ;?>
            <?php foreach ($list_first_menu as $k => $row_first_menu) { ?>
                <div class="meun-title">{$row_first_menu->name}</div>
                <?php foreach ($row_first_menu['childs'] as $k2 => $row_menu) { ?>
                    <div class="meun-item <?php
                    if (request()->controller() == $row_menu->controller && request()->action() == $row_menu->action )echo 'meun-item-active ';
                    ?>">
                        <a href="<?php echo Url($row_menu->controller . '/' . $row_menu->action, $row_menu->param) ?>"><img
                                    src="__PUBLIC__/images/icon_user_grey.png">{$row_menu->name}</a></div>
                <?php } ?>
            <?php } ?>
        <?php }?>

        <p style="color:white;margin-top:30px;text-align:left;">@weilaihexun</p>

    </div>
    {/block}
    <!-- 右侧具体内容栏目 -->
    <div id="rightContent" style="/*height:1200px;*/">

        <a class="toggle-btn" id="nimei">
            <i class="glyphicon glyphicon-align-justify"></i>
        </a>
        <!-- Tab panes -->
        <div class="tab-content">
            <!--变化的内容-->
            {block name="content"}右侧内容块{/block}
        </div>
    </div>

    <script src="__PUBLIC__/js/jquery.nouislider.js"></script>


</body>
</html>