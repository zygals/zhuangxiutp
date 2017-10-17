{extend name='layout:base' /}
{block name="title"}添加菜单{/block}
{block name="content"}
<style>
    .control-label {
        padding-right: 10px;
    }
</style>
<!--弹出添加用户窗口-->
<form class="form-horizontal" action="{:url('save')}" method="post" >
    <div class="row">
        <div class="col-xs-8">
            <div class="text-center">
                <!---->
                <h4 class="modal-title" id="gridSystemModalLabel">添加菜单</h4>
            </div>
            <div class="">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>上级：</label>
                        <div class="col-xs-8">
                            <select class=" form-control select-duiqi" name="pid" id="a_cate_id">
                                <option value="0">-- 一级 --</option>
                                <?php foreach ($list_menu as $k => $row_) { ?>
                                    <option value="{$row_->id}">{$row_->name}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>名称：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='name' value="" id=""
                                   placeholder="">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label">控制器：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='controller' value="" id=""
                                   placeholder="">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label">方法：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='action' value="index" id=""
                                   placeholder="">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label">参数：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='param' value="" id=""
                                   placeholder="格式：a=1&b=2&...">
                        </div>
                    </div>

                    <div class="form-group" id="diliver_fee_wrap" style=";">
                        <label for="situation" class="col-xs-3 control-label">排序：</label>
                        <div class="col-xs-8">
                            <label class="control-label">
                                <input type="number" name="sort" class="form-control input-sm duiqi" id=""
                                       value="0"></label> &nbsp;

                        </div>
                    </div>

                </div>
            </div>
            <div class="text-center">
                <a href="javascript:history.back()">
                    <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回</button>
                </a>
                <button type="submit" class="btn btn-xs btn-green">保 存</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function () {
        $('form').bootstrapValidator({
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: '名称不能为空'
                        }
                    }

                }
            }
        });

    });

</script>

{/block}
