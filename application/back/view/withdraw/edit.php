{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label {
        padding-right: 10px;
    }
</style>

<!--弹出添加用户窗口-->
<form class="form-horizontal" action="{:url($act)}" method="post" >

    <div class="row">
        <div class="col-xs-8">
            <div class="text-center">
                <!---->
                <h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
            </div>
            <div class="">
                <div class="container-fluid">
                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>我的收益：</label>
                        <div class="col-xs-8 ">
                            <label>{$benefit} 元 </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>提现金额：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm "  name='cash' value="" id=""
                                   placeholder="已申请{$remain['already_apply']}">
                            <span>
                                申请成功后，总平台管理员将通过线下为您转账
                            </span>
                        </div>
                    </div>


                </div>
            </div>
            <div class="text-center">
                <a href="javascript:history.back()">
                    <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回</button>
                </a>
                <button type="submit" class="btn btn-xs btn-green">申请</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function () {
        $('form').bootstrapValidator({
            fields: {
                cash: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        },

                    }

                }
            }
        });

    });

</script>

{/block}
