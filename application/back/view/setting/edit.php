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
<form class="form-horizontal" action="{:url('update')}" method="post">
    <input type="hidden" name="id" value="{$row_->id}">
    <div class="row">
        <div class="col-xs-8">
            <div class="text-center">
                <h4 class="modal-title" id="gridSystemModalLabel">网站设置</h4>
            </div>
            <div class="">
                <div class="container-fluid">

                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">pc产品中心每个分类显示产品数：</label>
                        <div class="col-xs-7 ">
                            <input type="number" class="form-control input-sm duiqi" name='nums_pro' value="{$row_->nums_pro}" ><span style="color:red">0 表示不限定</span></div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">pc产品中心详情页每个分类推荐产品数：</label>
                        <div class="col-xs-7 ">
                            <input type="number" class="form-control input-sm duiqi" name='nums_pro_detail' value="{$row_->nums_pro_detail}" ><span style="color:red">0 表示不限定</span>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">pc新品列表页每页显示产品数：</label>
                        <div class="col-xs-7 ">
                            <input type="number" class="form-control input-sm duiqi" name='nums_new' value="{$row_->nums_new}" ><span style="color:red">0 表示不限定</span>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">网站名称：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm" name='sitename' value="{$row_->sitename}" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">400联系电话：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='phone400' value="{$row_->phone400}" >
                        </div>
                    </div><div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">版权：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm" name='cropyright' value="{$row_->cropyright}" >
                        </div>
                    </div><div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">备案：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm" name='beian' value="{$row_->beian}" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">设计人：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='designer' value="{$row_->designer}" >
                        </div>
                    </div> <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">总部销售咨询电话：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='consult_phone' value="{$row_->consult_phone}" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">传真：</label>
                        <div class="col-xs-7 ">
                            <input type="text" class="form-control input-sm duiqi" name='fax' value="{$row_->fax}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="situation" class="col-xs-5 control-label">隐藏分享到新浪，qq等：</label>
                        <div class="col-xs-7">
                            <label class="control-label" >
                                <input type="radio" name="hide_share" id="" value="1" <?php echo $row_->hide_share=='1'?'checked':''?>>是</label> &nbsp;
                            <label class="control-label">
                                <input type="radio" name="hide_share" id="" value="0" <?php echo $row_->hide_share=='0'?'checked':''?>> 否</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="situation" class="col-xs-5 control-label">是否隐藏免费服务热线：</label>
                        <div class="col-xs-7">
                            <label class="control-label" >
                                <input type="radio" name="hide_online" id="" value="1" <?php echo $row_->hide_online=='1'?'checked':''?>>是</label> &nbsp;
                            <label class="control-label">
                                <input type="radio" name="hide_online" id="" value="0" <?php echo $row_->hide_online=='0'?'checked':''?>> 否</label>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">联系我们文字：</label>
                        <div class="col-xs-7 ">
                            <textarea name="contact" id="contact_area" style="width:450px;height:400px;">{$row_->contact}</textarea>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-5 control-label">架车路线：</label>
                        <div class="col-xs-7 ">
                            <textarea name="bus" id="bus" style="width:450px;height:400px;">{$row_->bus}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="text-center">
        <button type="reset" class="btn btn-xs btn-white" data-dismiss="modal">取消</button>
        <button type="submit" cla="btn btn-xs btn-green">保 存</button>
    </div>
</form>

<script>

</script>

{/block}
