{extend name='layout:base' /}
{block name="title"}网站设置{/block}

{block name="content"}
<style>
    .control-label {
        padding-right: 10px;
    }
</style>

<!--弹出添加用户窗口-->
<form class="form-horizontal" action="{:url($act)}" method="post" enctype="multipart/form-data">


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
                            <input type="text" class="form-control input-sm duiqi" name='withdraw_limit' value="{$list->withdraw_limit|default=''}" placeholder="0.00元" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">平台联系人：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='contact' value="{$list->contact|default=''}" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">公司地址：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='address' value="{$list->address|default=''}" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">平台电话：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='mobile' value="{$list->mobile|default=''}" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">客服电话：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='telephone' value="{$list->telephone|default=''}" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">关于我们图：</label>
                        <div class="col-xs-7 ">
                            <img src="__IMGURL__{$list->img|default=''}" alt="没有上传图片" width="188"/>
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


</form>

<script>

</script>

{/block}
