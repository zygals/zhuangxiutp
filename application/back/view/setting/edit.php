{extend name='layout:base' /}
{block name="title"}网站设置{/block}

{block name="content"}
<style>
    .control-label {
        padding-right: 10px;
    }
</style>

<script src="__EDITOR__/kindeditor.js"></script>
<script src="__EDITOR__/lang/zh_CN.js"></script>
<script>
    KindEditor.ready(function (K) {
        // var editor = K.create('#desc_textarea');
        var editor = K.create('textarea[name="contact"]',{
            themeType: 'simple',
            resizeType: 1,
            uploadJson: '__EDITOR__/php/upload_json.php',
            fileManagerJson: '__EDITOR__/php/file_manager_json.php',
            allowFileManager: true,
            //下面这行代码就是关键的所在，当失去焦点时执行 this.sync();
            afterBlur: function(){this.sync();}
        });
        var editor2 = K.create('textarea[name="bus"]',{
            themeType: 'simple',
            resizeType: 1,
            uploadJson: '__EDITOR__/php/upload_json.php',
            fileManagerJson: '__EDITOR__/php/file_manager_json.php',
            allowFileManager: true,
            //下面这行代码就是关键的所在，当失去焦点时执行 this.sync();
            afterBlur: function(){this.sync();}
        });

    });

</script>
<!--弹出添加用户窗口-->
<form class="form-horizontal" action="{:url($act)}" method="post" enctype="multipart/form-data">
<?php if(count($list)>0){ ?>

    <div class="row">
        <div class="col-xs-8">
            <div class="text-center">
                <h4 class="modal-title" id="gridSystemModalLabel">平台设置</h4>
            </div>
            <div class="">
                <div class="container-fluid">
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">商户申请最低提现金额：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='withdraw_limit' value="{$list->withdraw_limit}" placeholder="0.00元" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">平台联系人：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='contact' value="{$list->contact}" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">公司地址：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='address' value="{$list->address}" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">平台电话：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='mobile' value="{$list->mobile}" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">客服电话：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='telephone' value="{$list->telephone}" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">平台列表图片：</label>
                        <div class="col-xs-7 ">
                            <img src="__IMGURL__{$list->img}" alt="没有上传图片" width="188"/>
                            <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img" placeholder=""><span style="color:red">尺寸要求（750*350），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>

                        </div>
                    </div>

                    <div class="text-center">
                        <button type="reset" class="btn btn-xs btn-white" data-dismiss="modal">取消</button>
                        <button type="submit" cla="btn btn-xs btn-green">修  改</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php }else{ ?>
    <div class="row">
        <div class="col-xs-8">
            <div class="text-center">
                <h4 class="modal-title" id="gridSystemModalLabel">平台设置</h4>
            </div>
            <div class="">
                <div class="container-fluid">
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">商户申请最低提现金额：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='withdraw_limit' value="" placeholder="0.00元" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">平台联系人：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='contact' value="" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">公司地址：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='address' value="" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">平台电话：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='mobile' value="" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">客服电话：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='telephone' value="" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">平台列表图片：</label>
                        <div class="col-xs-7 ">
                            <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img" placeholder=""><span style="color:red">尺寸要求（750*350），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="reset" class="btn btn-xs btn-white" data-dismiss="modal">取消</button>
                        <button type="submit" cla="btn btn-xs btn-green">保 存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

</form>

<script>

</script>

{/block}
