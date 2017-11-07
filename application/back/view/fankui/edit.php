{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
</style>

<!--弹出添加用户窗口--><form class="form-horizontal" action="{:url($act)}" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="id" value="{$row_->id}">
    <input type="hidden" name="referer" value="{$referer}">
    <div class="row" >
        <div class="col-xs-8">
            <div class="text-center">
                <!---->
                <h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
            </div>
            <div class="">
                <div class="container-fluid">

                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>内容：</label>
                        <div class="col-xs-8 ">
                            <textarea name="cont" id="desc_textarea" style="width:700px;height:300px;">{$row_->cont}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>评价：</label>
                        <label for="sName" class="col-xs-1 control-label"><input type="radio" name="star" value="1" <?php echo $row_->star=='好评'?'checked':'' ?>>好评</label>
                        <label for="sName" class="col-xs-1 control-label"><input type="radio" name="star" value="2" <?php echo $row_->star=='中评'?'checked':'' ?>>中评</label>
                        <label for="sName" class="col-xs-1 control-label"><input type="radio" name="star" value="3" <?php echo $row_->star=='差评'?'checked':'' ?>>差评</label>
                    </div>
                    <div class="form-group">
                        <label for="situation" class="col-xs-3 control-label">状态：</label>
                        <div class="col-xs-8">
                            <label class="control-label" >
                                <input type="radio" name="st" id="" value="1" <?php echo $row_->st=='正常'?'checked':''?>>正常</label> &nbsp;
                            <label class="control-label">
                                <input type="radio" name="st" id="" value="2" <?php echo $row_->st=='不显示'?'checked':''?>> 不显示</label>
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
            img: {
                validators: {
                    notEmpty: {
                        message: '请添加广告图'
                    }
                }
            }

        }
    });

    });

</script>

{/block}
