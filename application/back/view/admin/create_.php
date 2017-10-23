{extend name='layout:base' /}
{block name="title"}添加管理员{/block}
{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
</style>
	<!--弹出添加用户窗口--><form class="form-horizontal" action="{:url('save_')}" method="post" enctype="multipart/form-data" >
		<div class="row" >
			<div class="col-xs-8">
				<div class="text-center">
					<h4 class="modal-title" id="gridSystemModalLabel">添加一般管理员</h4>
				</div>
				<div class="">
					<div class="container-fluid">
							<div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>账号：</label>
								<div class="col-xs-8 ">
									<input type="text" class="form-control input-sm duiqi" name='name' value="" id="" placeholder="">
								</div>
							</div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>密码：</label>
                            <div class="col-xs-8 ">
                                <input type="password" required class="form-control input-sm duiqi" name='pass' value="" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>重复密码：</label>
                            <div class="col-xs-8 ">
                                <input type="password" required class="form-control input-sm duiqi" name='repass'
                                       value="" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label">姓名：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='truename' value="" id="" placeholder="">
                            </div>
                        </div>
                            <div class="form-group">
                                <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>权限：</label>
                                <div class="col-xs-8">

                                        <?php foreach ($list_power as $k=>$row_p){?>
                                            <label class="control-label" >
                                                <input type="checkbox" name="privilege[]" value="{$row_p->id}" >{$row_p->name}</label> &nbsp;
<?php }?>


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
                            message: '不能为空'
                        }


                    }
                },
                pass: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }


                    }
                }, repass: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }


                    }
                },
                privilege: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }


                    }
                },


            }
        });

    });

</script>

{/block}
