{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label {
        padding-right: 10px;
    }
    .form-group .action-type{
        margin-top: 5px;
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
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>申请用户：</label>
                        <div class="col-xs-8 ">
                            <label>{$row_['admin_truename']}</label>
                            <input type="hidden" name="id" value="{$row_['id']}">
                            <input type="hidden" name="referer" value="{$referer}">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>该用户账户余额：</label>
                        <div class="col-xs-8 ">
                            <label>{$benefit} 元</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>提现金额：</label>
                        <div class="col-xs-8 ">
                            <label>{$row_['cash']}元</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>提现申请状态：</label>
                        <div class="col-xs-8 action-type">
                            <label><input type="radio" name="st" value="1" <?php echo $row_['st']=='待审核'?'checked':''?>>待审核</label>　
                            <label><input type="radio" name="st" value="2" <?php echo $row_['st']=='通过'?'checked':'' ?>>通过</label>　
                            <label><input type="radio" name="st" value="3" <?php echo $row_['st']=='未通过'?'checked':'' ?>>未通过</label>　
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>资金状态：</label>
                        <div class="col-xs-8 action-type">
                            <label><input type="radio" name="cash_st" value="0" <?php echo $row_['cash_st']=='待转账'?'checked':'' ?>>待转账</label>　
                            <label><input type="radio" name="cash_st" value="1" <?php echo $row_['cash_st']=='转账成功'?'checked':'' ?>>转账成功</label>　
                            <label><input type="radio" name="cash_st" value="2" <?php echo $row_['cash_st']=='转账失败'?'checked':'' ?>>转账失败</label>　
                        </div>
                    </div>
                    <div class="form-group action-type">
                        <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>申请时间：</label>
                        <div class="col-xs-8 ">
                            <label>{$row_['create_time']}</label>
                        </div>
                    </div>


                </div>
            </div>
            <div class="text-center">
                <a href="javascript:history.back()">
                    <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回</button>
                </a>
                <button type="submit" class="btn btn-xs btn-green">修改</button>
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
