{extend name='layout:base' /}
{block name="title"}{$model_name}{/block}
{block name="content"}
<style>
	.pagination li.disabled > a, .pagination li.disabled > span {
		color: inherit;
	}

	.pagination li > a, .pagination li > span {
		color: inherit
	}
</style>
<div role="tabpanel" class="tab-pane" id="user" style="display:block;">
	<div class="check-div form-inline row">
		<!--<div class="col-xs-2">
			<a href="{:url('create')}"><button class="btn btn-yellow btn-xs" data-toggle="modal" data-target="#addUser" id="create">添加{$model_name}</button></a>
</div>-->
		<div class="col-xs-10">
			<form method="get" action="{:url('index')}" id="searchForm">
				<div class="col-xs-7">
					<input type="text" name="name_" value="{$Think.get.name_}" class="form-control input-sm"
						   placeholder="输入姓名或手机进行搜索">
				</div>
				<div class=" col-xs-5" style=" padding-right: 40px;color:inherit">
					<select class=" form-control" name="paixu">
						<option value="">--请选择排序字段--</option>
				<!--		<option value="sort" {eq name="Think.get.paixu" value="sort"
								}selected{
						/eq}>排序</option>-->
						<option value="create_time" {eq name="Think.get.paixu" value="create_time"
								}selected{
						/eq}>添加时间</option>
						<option value="update_time" {eq name="Think.get.paixu" value="update_time"
								}selected{
						/eq}>修改时间</option>
					</select>
					<label class="">
						<input type="checkbox" name="sort_type" id="" value="desc" {eq name="Think.get.sort_type"
							   value="desc"
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
			<div class="col-xs-1">
				姓名
			</div>

			<div class="col-xs-2">
				手机
			</div>
			<div class="col-xs-1">
				地址
			</div>
			<div class="col-xs-2">
				验房时间
			</div>
			<div class="col-xs-2">
				添加时间
			</div>

			<div class="col-xs-1">
				状 态
			</div>
			<div class="col-xs-">
				操 作
			</div>
		</div>
		<div class="tablebody">
			<?php if ( count( $list_ ) > 0 ) { ?>
				<?php foreach ( $list_ as $key => $row_ ) { ?>
					<div class="row cont_nowrap">
						<div class="col-xs-1 ">
							{$row_->id}
						</div>

						<div class="col-xs-1 " title="{$row_->truename}">
							{$row_->truename}
						</div>
						<div class="col-xs-2 " title="{$row_->mobile}">
							{$row_->mobile}
						</div>
						<div class="col-xs-1" title="{$row_->address}">
							{$row_->address}
						</div>
						<div class="col-xs-2">
							{$row_->time_to}
						</div>
						<div class="col-xs-2">
							{$row_->create_time}
						</div>
						<div class="col-xs-1">
							{$row_->st}
						</div>
						<div class="col-xs-">
							<a href="{:url('edit')}?id={$row_->id}">
								<button class="btn btn-success btn-xs edit_">改</button>
							</a>
							<?php if($row_->st=='已验房' && $row_->article_st=='0'){?>
								<a href="{:url('add')}?id={$row_->id}">
									<button class="btn btn-success btn-xs edit_" title="添加验房总结">总结</button>
								</a>
						<?php }?>
							<?php if($row_->st=='已验房' && $row_->article_st=='1'){?>
								<a href="{:url('edit_article')}?id={$row_->id}">
									<button class="btn btn-success btn-xs edit_" title="修改验房总结">改总结</button>
								</a>
							<?php }?>
							<button class="btn btn-danger btn-xs del_cate" data-toggle="modal"
									data-target="#deleteSource" data-id="<?= $row_['id'] ?>" onclick="del_(this)"> 删
							</button>

						</div>

					</div>
				<?php } ?>
			<?php } else { ?>
				<div class="row">
					<div class="col-xs-12 ">
						<h3 class="" align="center" style="color:red;font-size:18px">结果不存在</h3>
					</div>
				</div>
			<?php } ?>

		</div>

	</div>

	<!--页码块-->
	<footer class="footer">
		{$page_str}
	</footer>


	<!--弹出删除用户警告窗口-->
	<div class="modal fade" id="deleteSource" role="dialog" aria-labelledby="gridSystemModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="gridSystemModalLabel">提示</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						确定删除数据吗？删除后对应的验房总结也会删除。
					</div>
				</div>
				<div class="modal-footer">
					<form action="{:url('delete')}" method="post">
						<input type="hidden" name="id" value="" id="del_id">
						<input type="hidden" name="url" value="{$url}">
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