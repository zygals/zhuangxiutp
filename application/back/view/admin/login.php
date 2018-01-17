{extend name='layout:base' /}
{block name="title"}后台登陆{/block}
{block name="menu_left"}{/block}
{block name="content"}
<style>#rightContent {
        padding-left: 0;
    }</style>
<div role="tabpanel" class="tab-pane" id="chan" style="display:block;">
    <div class="check-div">
        55+ 后台登陆
    </div>
    <div style="padding: 50px 0;margin-top: 50px;background-color: #fff; text-align: right;width: 420px;margin: 50px auto;">
        <form class="form-horizontal" action="{:Url('admin/sigin')}" method="post">
            <div class="form-group">
                <label for="name" class="col-xs-4 control-label">用户名</label>
                <div class="col-xs-5">
                    <input type="text" class="form-control input-sm duiqi" name="name" id="name" placeholder=""
                           style="margin-top: 7px;">
                </div>
            </div>
            <div class="form-group">
                <label for="pass" class="col-xs-4 control-label">密码：</label>
                <div class="col-xs-5">
                    <input type="password" class="form-control input-sm duiqi" id="pass" name="pass" placeholder=""
                           style="margin-top: 7px;">
                </div>
            </div>
            <div class="form-group">
                <label for="captcha" class="col-xs-4 control-label">验证码：</label>
                <div class="col-xs-8">
                    <input type="text" class="form-control input-sm duiqi "  name="captcha" id="captcha_input" placeholder=""
                           style="margin-top: 7px;"></div>

            </div>
            <div class="form-group">
                <div class="col-xs-8">
                    <image src="{:url('captcha')}" alt="code" class="captcha_" id="captch_img"/>
                    <button  class="captcha_" type="button">换一张</button>
                </div>
            </div>
            <div class="form-group text-right">
                <div class="col-xs-offset-4 col-xs-5" style="margin-left: 169px;">
                    <button type="reset" class="btn btn-xs btn-white">取 消</button>
                    <button type="submit" class="btn btn-xs btn-green">确 定</button>
                </div>
            </div>
        </form>
    </div>

</div>
<script>
    var src = '{:url(\'captcha\')}';
    $('.captcha_').bind('click', function () {
        $('#captch_img').attr('src', src + '?random=' + Math.random());
        $('#captcha_input').val('');

    });
</script>
{/block}
