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
                        <label for="sName" class="col-xs-3 control-label">姓名：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='truename' value="{$row_->truename}" id="" placeholder="" readonly>
                        </div>
                    </div>
					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">手机：</label>
						<div class="col-xs-8 ">
							<input type="text" class="form-control input-sm duiqi" name='mobile' value="{$row_->mobile}" id="" placeholder="" readonly>
						</div>
					</div>
					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">地址：</label>
						<div class="col-xs-8 ">
							<input type="text" class="form-control input-sm duiqi" name='address' value="{$row_->address}" id="" placeholder="" readonly>
						</div>
					</div>
					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">验房时间：</label>
						<div class="col-xs-8 ">
							<input type="text" class="form-control input-sm duiqi" name='time_to' value="<?= date('Y-m-d H:i:s',$row_->time_to);?>" id="" placeholder="" readonly>
						</div>
					</div>

                    <div class="form-group">
                        <label for="situation" class="col-xs-3 control-label">状态：</label>
                        <div class="col-xs-8">
                            <label class="control-label" >
                                <input type="radio" name="st" id="" value="1" <?php echo $row_->st=='没验房'?'checked':''?>>没验房</label> &nbsp;
                            <label class="control-label">
                                <input type="radio" name="st" id="" value="2" <?php echo $row_->st=='已验房'?'checked':''?>> 已验房</label>
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
