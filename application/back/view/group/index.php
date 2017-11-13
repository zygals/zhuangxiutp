{extend name='layout:base' /}
{block name="title"}商品列表{/block}
{block name="content"}
<style>
	.pagination li.disabled > a, .pagination li.disabled > span {
		color: inherit;
	}

	.pagination li > a, .pagination li > span {
		color: inherit
	}
</style>
<script>
	function getGoodsByType() {
		$('#sel_cate_id').val('');
		$('#searchForm').submit();
	}
	;
</script>
<div role="tabpanel" class="tab-pane" id="user" style="display:block;">
	<div class="check-div form-inline row" style="">
		<div class="col-xs-1">
			<a href="{:url('create')}">
				<button class="btn btn-yellow btn-xs" data-toggle="modal" data-target="#addUser" id="create">添加团购
				</button>
			</a>
		</div>
		<div class="col-xs-11">
			<form method="get" action="{:url('index')}" id="searchForm">
				<div class="col-xs-7">
					<!-- <input type="text" name="name" value="{$Think.get.name}" class="form-control input-sm"
							   placeholder="输入名称搜索">-->
				</div>
				<div class=" col-xs-5" style=" padding-right: 40px;color:inherit">
					<select class=" form-control" name="paixu">
						<option value="">--请选择排序字段--</option>
						<option value="price_group" {eq name="Think.get.paixu" value="price_group"
								}selected{
						/eq}>价格</option>

						<option value="attend_pnum" {eq name="Think.get.paixu" value="attend_pnum"
								}selected{
						/eq}>已参加人数</option>
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
					<label class="">
						<input type="checkbox" name="st" id="" value="2" {eq name="Think.get.st" value="2"
							   }checked{/eq}>下架</label>
					<button class="btn btn-white btn-xs " type="submit">提交</button>
				</div>
			</form>
		</div>
	</div>
	<div class="data-div">
		<div class="row tableHeader">
			<div class="col-xs-1 ">
				编号
			</div>
			<div class="col-xs-1 ">
				店铺
			</div>
			<div class="col-xs-1">
				商品名称
			</div>
			<div class="col-xs-1">
				限人数
			</div>
<!--			<div class="col-xs-1">-->
<!--				限量数-->
<!--			</div>-->
			<div class="col-xs-1">
				团购价格
			</div>
			<div class="col-xs-1">
				订金
			</div>
			<div class="col-xs-1">
				团购状态
			</div>

			<!--<div class="col-xs-1">
				活动截止时间
			</div>-->
<!--			<div class="col-xs-1">-->
<!--				类型-->
<!--			</div>-->
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
						<div class="col-xs-1 " title="{$row_->shop_id}:{$row_->shop_name}">
							{$row_->shop_id}:{$row_->shop_name}
						</div>
						<div class="col-xs-1 " title="{$row_->good_id}">
							{$row_->good_name}
						</div>
						<?php if ( $row_->pnum != '' ) { ?>
							<div class="col-xs-1 " title="已参：{$row_->attend_pnum}人">
								{$row_->pnum}
							</div>
						<?php } else { ?>
							<div class="col-xs-1 ">
								无
							</div>
						<?php } ?>
<!--						--><?php //if ( $row_->type == '限量' ) { ?>
<!--							<div class="col-xs-1 " title="已售：{$row_->already_sales}人">-->
<!--								{$row_->store}-->
<!--							</div>-->
<!--						--><?php //} else { ?>
<!--							<div class="col-xs-1 ">-->
<!--								无-->
<!--							</div>-->
<!--						--><?php //} ?>

						<div class="col-xs-1 " title="{$row_->price_group}">
							{$row_->price_group}
						</div>

							<div class="col-xs-1 " title="{$row_->deposit}">
								{$row_->deposit}
							</div>


						<div class="col-xs-1 " title="{$row_->group_st}">
							{$row_->group_st}
						</div>
						<?php if($row_->end_time != 0){ ?>
							<!--<div class="col-xs-1" title="{$row_->end_time}">
								<?php /*echo date( 'Y-m-d' , $row_->end_time ) */?>
							</div>-->
						<?php }else{ ?>
						<!--	<div class="col-xs-1" title="{$row_->end_time}">
								无
							</div>-->
						<?php } ?>
<!--						<div class="col-xs-1">-->
<!--							{$row_->type}-->
<!--						</div>-->

						<div class="col-xs-">
							<a href="{:url('edit')}?id={$row_->id}">
								<button class="btn btn-success btn-xs edit_" title="修改">修</button>
							</a>
							<?php if ( $row_->article_st == 0 ) { ?>
								<a href="{:url('add')}?id={$row_->id}">
									<button class="btn btn-success btn-xs edit_" title="总结">总结</button>
								</a>
							<?php } else { ?>
								<a href="{:url('edit_article')}?id={$row_->id}">
									<button class="btn btn-success btn-xs edit_" title="修改总结">改总结</button>
								</a>
							<?php } ?>

							<?php if ( $row_->end_time <= time() ) { ?>

								<?php if ($row_->st == '下架') { ?>
									<button class="btn btn-danger btn-xs del_cate" data-toggle="modal"
											data-target="#deleteSource" data-id="<?= $row_['id'] ?>" onclick="del_(this)"> 删
									</button>
								<?php } else{?>
									<button class="btn btn-danger btn-xs del_cate" data-toggle="modal"
											data-target="#downSource" data-id="<?= $row_['id'] ?>" onclick="down_(this)" title="下架"> 下
									</button>
								<?php }?>
							<?php } ?>
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
						确定删除数据吗？
					</div>
				</div>
				<div class="modal-footer">
					<form action="{:url('delete')}" method="post">
						<input type="hidden" name="id" value="" id="del_id">
						<input type="hidden" name="url" value="{$url}" id="">
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

	<!-- /.下架对话 -->

	<div class="modal fade" id="downSource" role="dialog" aria-labelledby="gridSystemModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="gridSystemModalLabel">提示</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						确定要下架此商品吗？
					</div>
				</div>
				<div class="modal-footer">
					<form action="{:url('down')}" method="post">
						<input type="hidden" name="id" value="" id="down_id">
						<input type="hidden" name="url" value="{$url}" id="">
						<button type="button" class="btn btn-xs btn-white" data-dismiss="modal">取 消</button>
						<button type="submit" class="btn  btn-xs btn-danger">确 定</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>
<script>

	function del_(obj) {
		var id = $(obj).attr('data-id');
		$('#del_id').val(id);
	}

	function down_(obj) {
		var id = $(obj).attr('data-id');
		$('#down_id').val(id);
	}
</script>

{/block}