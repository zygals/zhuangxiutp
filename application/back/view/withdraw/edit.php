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
    <?php if($act=='update'){?>
        <input type="hidden" name="admin_id" value="{$admin_id}">
        <input type="hidden" name="referer" value="{$referer}">
        <input type="hidden" name="benefit" value="{$benefit}">
    <?php }?>
    <div class="row">
        <div class="col-xs-8">
            <div class="text-center">
                <!---->
                <h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
            </div>
            <div class="">
                <div class="container-fluid">
                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>我的金额：</label>
                        <div class="col-xs-8 ">
                            <label>{$benefit} 元</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>提现金额：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='cash' value="" id=""
                                   placeholder="0.00">
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
        var maxBenefit = '{$benefit}';
        var minBenefit = '{$minBenefit}';
        $('form').bootstrapValidator({

            fields: {
                cash: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        },
                        between:{
                            min:minBenefit,
                            max:maxBenefit,
                            message:'提现最低金额为'+minBenefit+'元,且不得超出账户余额!'
                        }
                    }

                }
            }
        });

    });

</script>

{/block}
