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
    <input type="hidden" name="id" value="{$row_->id}">
    <input type="hidden" name="referer" value="{$referer}">
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
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>类型：</label>
                        <div class="col-xs-8 ">
                            <?php if($act=='save'){?>
                            <label class="control-label" >
                                <input type="radio" name="type" id="" value="1" checked >行业</label> &nbsp;
                            <label class="control-label">
                                <input type="radio" name="type" id="" value="2" >百科</label>
                            <?php }else{?>
                                <label class="control-label" >
                                    <input type="radio" name="type" id="" value="1" <?php echo $row_->type=='行业'?'checked':''?> >行业</label> &nbsp;
                                <label class="control-label">
                                    <input type="radio" name="type" id="" value="2" <?php echo $row_->type=='百科'?'checked':''?>>百科</label>
                            <?php }?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>名称：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='name' value="{$row_->name|default=''}" id=""
                                   placeholder="">
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
                title: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }
                    }

                },
                type: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }
                    }

                }
            }
        });

    });

</script>

{/block}
