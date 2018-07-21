{extend name='layout:base' /}
{block name="title"}会员列表{/block}

{block name="content"}
<style>
	.pagination li.disabled>a, .pagination li.disabled>span{color:inherit;}
	.pagination li>a, .pagination li>span{color:inherit}
</style>
<div role="tabpanel" class="tab-pane" id="user" style="display:block;">
    <div class="check-div form-inline">
        <div class="row">
            <form method="get" action="{:url('index')}" id="searchForm">
                <div class="col-xs-8">
                    <input type="text" id="" name="time_from" value="{$Think.get.time_from}" class="form-control input-sm date_input" placeholder="从？如：2017-02-03">

                    <input type="text" id="" name="time_to" value="{$Think.get.time_to}" class="form-control input-sm date_input" placeholder="到?如：2017-03-03"">
                    <input type="text" name="name_" value="{$Think.get.name_}" class="form-control input-sm"
                           placeholder="输入用户名/昵称搜索">

                   <!-- <input type="text" name="mobile" value="{$Think.get.mobile}" class="form-control input-sm"
                           placeholder="输入手机搜索">-->
                </div>
                <div class=" col-xs-4" style=" padding-right: 40px;color:inherit">
                    <select class=" form-control" name="paixu">
                        <option value="">--请选择排序字段--</option>
                        <option value="create_time" {eq name="Think.get.paixu" value="create_time"
                                }selected{/eq}>添加时间</option>
                        <option value="update_time" {eq name="Think.get.paixu" value="update_time"
                                }selected{/eq}>修改时间</option>
                    </select>
                    <label class="">
                        <input type="checkbox" name="sort_type" id="" value="desc" {eq name="Think.get.sort_type" value="desc"
                               }checked{/eq}>降序</label>

                    <button class="btn btn-white btn-xs " type="submit">提交</button>
                </div>
            </form>
        </div>

    </div>
	<div class="data-div">
		<div class="row tableHeader">
            <div class="col-xs-1 ">
                编 号
            </div>
			<div class="col-xs-1 ">
				用户名
			</div>
			<div class="col-xs-2">
				昵称
			</div>
            <div class="col-xs-1">
                头像
            </div>
            <div class="col-xs-">
                注册时间
            </div>
<!--            <div class="col-xs-">-->
<!--                修改时间-->
<!--            </div>-->
			<!--<div class="col-xs-1">
				状 态
			</div>
			<div class="col-xs-6">
				操 作
			</div>-->
		</div>
		<div class="tablebody">
			<?php if(count($list)>0){?>
			<?php foreach($list as $key=>$user){?>
			<div class="row cont_nowrap">
                <div class="col-xs-1">
                    {$user->id}
                </div>
				<div class="col-xs-1 " title="{$user->username}">
					{$user->username}
				</div>
              <div class="col-xs-2" title="{$user->nickname}">
                    {$user->nickname}
                </div>
                <div class="col-xs-1">
                    <img src="{$user->vistar}" width="50" height="50" alt="没有头像">
                </div>
				<div class="col-xs-">
					{$user->create_time}
				</div>
			</div>
			<?php }?>
			<?php }else{?>
				<div class="row">
					<div class="col-xs-12 ">
						<h3 class="" align="center" style="color:red;font-size:18px">结果不存在</h3>
					</div>
				</div>
			<?php }?>

		</div>

	</div>

	<!--页码块-->
	<footer class="footer">
		{$list->render()}
	</footer>

	<!--弹出添加用户窗口-->
<!--	<div class="modal fade" id="addUser" role="dialog" aria-labelledby="gridSystemModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="gridSystemModalLabel">添加用户</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<form class="form-horizontal">
							<div class="form-group ">
								<label for="sName" class="col-xs-3 control-label">用户名：</label>
								<div class="col-xs-8 ">
									<input type="email" class="form-control input-sm duiqi" id="sName" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<label for="sLink" class="col-xs-3 control-label">真实姓名：</label>
								<div class="col-xs-8 ">
									<input type="" class="form-control input-sm duiqi" id="sLink" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<label for="sOrd" class="col-xs-3 control-label">电子邮箱：</label>
								<div class="col-xs-8">
									<input type="" class="form-control input-sm duiqi" id="sOrd" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<label for="sKnot" class="col-xs-3 control-label">电话：</label>
								<div class="col-xs-8">
									<input type="" class="form-control input-sm duiqi" id="sKnot" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<label for="sKnot" class="col-xs-3 control-label">地区：</label>
								<div class="col-xs-8">
									<select class=" form-control select-duiqi">
										<option value="">国际关系地区</option>
										<option value="">北京大学</option>
										<option value="">天津大学</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="sKnot" class="col-xs-3 control-label">权限：</label>
								<div class="col-xs-8">
									<select class=" form-control select-duiqi">
										<option value="">管理员</option>
										<option value="">普通用户</option>
										<option value="">游客</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="situation" class="col-xs-3 control-label">状态：</label>
								<div class="col-xs-8">
									<label class="control-label" for="anniu">
										<input type="radio" name="situation" id="normal">正常</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="control-label" for="meun">
										<input type="radio" name="situation" id="forbid"> 禁用</label>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-xs btn-white" data-dismiss="modal">取 消</button>
					<button type="button" class="btn btn-xs btn-green">保 存</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<!--弹出修改用户窗口-->
	<!--<div class="modal fade" id="reviseUser" role="dialog" aria-labelledby="gridSystemModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="gridSystemModalLabel">修改用户</h4>
				</div>
                <form class="form-horizontal" action="{:url('update')}" method="post" id="form_u">
				<div class="modal-body">
					<div class="container-fluid">
                            <input type="hidden" name="id" id="id_u" value="">
							<div class="form-group ">
								<label for="sName" class="col-xs-3 control-label">用户名：</label>
								<div class="col-xs-8 ">
									<input type="text" class="form-control input-sm duiqi" disabled name="name" id="name_u" placeholder="">
								</div>
							</div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label">性 别：</label>
                            <div class="col-xs-8 " id="sex_wrap_u">
                                <label  class="col-xs-3 control-label"><input type="radio" name="sex" value="1"> 男</label>
                                <label  class="col-xs-3 control-label"> <input type="radio" name="sex" value="0"> 女</label>
                            </div>
                        </div>
							<div class="form-group">
								<label for="sLink" class="col-xs-3 control-label">手 机：</label>
								<div class="col-xs-8 ">
									<input type="text" class="form-control input-sm duiqi" name="mobile" id="mobile_u" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<label for="sOrd" class="col-xs-3 control-label">地 址：</label>
								<div class="col-xs-8">
                                    <textarea name="addr" id="addr_u" cols="25" rows="3" style="font-size:inherit;margin-left: -24px;"></textarea>
								</div>
							</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-xs btn-white" data-dismiss="modal">取 消</button>
					<button type="submit" class="btn btn-xs btn-green">保 存</button>
				</div>
                </form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>-->
	<!-- /.modal -->

	<!--弹出删除用户警告窗口-->
	<div class="modal fade" id="deleteUser" role="dialog" aria-labelledby="gridSystemModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="gridSystemModalLabel">提示</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						确定要禁用该用户？
					</div>
				</div>
				<div class="modal-footer">
					<form action="{:url('delete')}" method="post" >
						<input type="hidden" name="id" value="" id="del_id">
						<button type="button" class="btn btn-xs btn-white" data-dismiss="modal">取 消</button>
						<button type="submit" class="btn  btn-xs btn-danger">确 定</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</div>
<script>
    $(function () {
        $('#form_u').bootstrapValidator({
            fields: {
                true_name: {
                    validators:
                        {
                            notEmpty: {
                                message: '姓名不能为空'
                            },
                            stringLength: {
                                min: 2,
                                max: 20,
                                message: '姓名长度必须在2到20位之间'
                            }
                        }

                },
                mobile: {
                    validators: {
                        notEmpty: {
                            message: '手机不能为空'
                        },
                        stringLength: {
                            min: 6,
                            max: 11,
                            message: '手机长度不对'
                        }

                    }
                },
                addr: {
                    validators: {
                        notEmpty: {
                            message: '地址不能为空'
                        }
                    }
                }
            }
        });

    });
	function del_(obj) {
		var id = $(obj).attr('data-id');
		$('#del_id').val(id);
    }
    function edit_(obj) {
        var id = $(obj).attr('data-id');
       $.get("{:url('edit')}",{id:id},function (data) {
           if(data.code!=0){
               alert(data.msg);
           }else{
               //
               var sex_str='';
               var sex={'男':1,"女":0};
               $('#id_u').val(data.row.id);
               $('#true_name_u').val(data.row.true_name);
               $('#mobile_u').val(data.row.mobile);

               if(data.row.sex=='男'){
                   sex_str= $('<label  class="col-xs-3 control-label"><input type="radio" name="sex" value="1" checked> 男</label>'
                       +'<label  class="col-xs-3 control-label"> <input type="radio" name="sex" value="0"> 女</label>');
               }else{
                   sex_str= $('<label  class="col-xs-3 control-label"><input type="radio" name="sex" value="1"> 男</label>'
                       +'<label  class="col-xs-3 control-label"> <input type="radio" name="sex" value="0" checked> 女</label>');
               }
                $('#sex_wrap_u').html(sex_str);
               $('#addr_u').val(data.row.addr);
           }
       });
    }
</script>

{/block}