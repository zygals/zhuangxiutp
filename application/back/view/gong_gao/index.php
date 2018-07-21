{extend name='layout:base' /}
{block name="title"}公告管理{/block}
{block name="content"}
<style>

</style>
<div role="tabpanel" class="tab-pane" id="user" style="display:block;">
	<div class="check-div form-inline row">
        <div class="col-xs-2">
            <a href="/zhuangxiutp/public/back/gong_gao/add.html">
                <button class="btn btn-yellow btn-xs" data-toggle="modal" data-target="#addUser" id="create">添加公告
                </button>
            </a>
        </div>


    </div>


	<div class="data-div">
		<div class="row tableHeader">
            <div class="col-xs-1 ">
                编 号
            </div>
			<div class="col-xs-1">
                排序
			</div>
			<div class="col-xs-1">
                公告内容
			</div>
			<div class="col-xs-2">
                添加时间
			</div>

            <div class="col-xs-1">
                操作
            </div>

		</div>
		<div class="tablebody">
			<?php if(count($list_)>0){?>
			<?php foreach($list_ as $key=>$row_){?>
			<div class="row cont_nowrap">
                <div class="col-xs-1 ">
                    {$row_.id}
                </div>
                <div class="col-xs-1 ">
                    {$row_.sort}
                </div>
				<div class="col-xs-1 " title="{$row_.content}">
					{$row_.content}
				</div>
                <div class="col-xs-2" title="{$row_.addtime}">
                    {:date('Y-m-d H:i',$row_.addtime)}
                </div>
                <div class="col-xs-1">
                    <a href="{:url('edit')}?id={$row_.id}">
                        <button class="btn btn-success btn-xs edit_">修改</button>
                    </a>
                    <button class="btn btn-danger btn-xs del_cate" data-toggle="modal" data-target="#deleteSource" data-id="{$row_.id}" onclick="del_(this)"> 删除
                    </button>

                </div>

			</div>
			<?php }?>
			<?php }else{?>
				<div class="row">
					<div class="col-xs-12 ">
						<h3 class="" align="center" style="color:red;font-size:18px">暂未添加公告数据</h3>
					</div>
				</div>
			<?php }?>

		</div>

	</div>

	<div class="modal fade" id="deleteSource" role="dialog" aria-labelledby="gridSystemModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="gridSystemModalLabel">提示</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						确定删除数据吗？
					</div>
				</div>
				<div class="modal-footer">
					<form action="{:url('delete')}" method="post" >
						<input type="hidden" name="id" value="" id="del_id">
                        <input type="hidden" name="url" value="{$url}" id="url">
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
	function del_(obj) {
		var id = $(obj).attr('data-id');
		$('#del_id').val(id);
    }

</script>

{/block}