{extend name='layout:base' /}
{block name="title"}管理员{/block}
{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
</style>
	<!--弹出添加用户窗口--><form class="form-horizontal" action="{:url('update_')}" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="admin_id" value="{$row_admin->id}">
    <input type="hidden" name="referer" value="{$referer}">
		<div class="row" >
			<div class="col-xs-8">
				<div class="text-center">
					<h4 class="modal-title" id="gridSystemModalLabel">改商户管理员</h4>
				</div>
				<div class="">
					<div class="container-fluid">
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>姓名：</label>
                            <div class="col-xs-8 ">
                                <label for="">
                                    {$row_shop->truename}
                                </label>
                               <!-- <input type="text" class="form-control input-sm duiqi" name='truename' value="{$row_shop->truename}" id=""  readonly>-->
                            </div>
                        </div>
							<div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>账号：</label>
								<div class="col-xs-8 ">
                                    <label for="">
                                        {$row_admin->name}
                                    </label>
								</div>
							</div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>密码：</label>
                            <div class="col-xs-8 ">
                                <input type="password"  class="form-control input-sm duiqi" name='pass' value="" id="" placeholder="留空表示不改">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>重复密码：</label>
                            <div class="col-xs-8 ">
                                <input type="password"  class="form-control input-sm duiqi" name='repass'
                                       value="" id="" placeholder="留空表示不改">
                            </div>
                        </div>
<?php if(session('admin_zhx')->type=='超级'){?>
                        <div class="form-group">
                            <label for="situation" class="col-xs-3 control-label">状态：</label>
                            <div class="col-xs-8">
                                <label class="control-label" >
                                    <input type="radio" name="st" id="" value="1" <?php echo $row_admin->st=='正常'?'checked':''?>>正常</label> &nbsp;
                                <label class="control-label">
                                    <input type="radio" name="st" id="" value="2" <?php echo $row_admin->st=='禁用'?'checked':''?>> 禁用</label>
                            </div>
                        </div><?php }?>


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
        /*        name: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }


                    }
                },*/



            }
        });

    });

</script>

{/block}
