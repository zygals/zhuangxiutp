{extend name='layout:base' /}
{block name="title"}评价列表{/block}
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
					<input type="text" id="" name="time_from" value="{$Think.get.time_from}"
						   class="form-control input-sm date_input" placeholder="从？如：2017-02-03">

					<input type="text" id="" name="time_to" value="{$Think.get.time_to}"
						   class="form-control input-sm date_input" placeholder="到?如：2017-03-03"">
					<select class=" form-control" name="paixu">
						<option value="">--请选择评价--</option>
						<option value="1" {eq name="Think.get.paixu" value="1"
								}selected{/eq}>好评</option>
						<option value="2" {eq name="Think.get.paixu" value="2"
								}selected{/eq}>中评</option>
						<option value="3" {eq name="Think.get.paixu" value="3"
								}selected{/eq}>差评</option>
					</select>
				</div>
				<div class=" col-xs-4" style=" padding-right: 40px;color:inherit">


					<label class="">
						<input type="checkbox" name="sort_type" id="" value="desc" {eq name="Think.get.sort_type"
							   value="desc"
							   }checked{/eq}>降序
					</label>

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
			<div class="col-xs-1">
                订单
			</div>
            <div class="col-xs-1">
                商户名称
            </div>
            <div class="col-xs-1">
                用户名
            </div>
            <div class="col-xs-1">
                内容
            </div>
			<div class="col-xs-1">
				评价
			</div>

            <div class="col-xs-1">
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
			<?php if(count($list_)>0){?>
			<?php foreach($list_ as $key=>$row_){?>
			<div class="row cont_nowrap">
                <div class="col-xs-1 ">
                    {$row_->id}
                </div>
				<div class="col-xs-1 " title="{$row_->orderno}">
                    {$row_->orderno}
                </div>
                <div class="col-xs-1 " title="{$row_->shop_name}"  >
                    {$row_->shop_name}
                </div>
                <div class="col-xs-1 " title="{$row_->username}">
                    {$row_->username}
                </div>
                <div class="col-xs-1" title="{$row_->cont}">
                    {$row_->cont}
                </div>
				<div class="col-xs-1" title="{$row_->star}">
					<?php if($row_->star == '好评'){?>
						{$row_->star}
					<?php }elseif($row_->star == '中评'){ ?>
						<span style="color:orange">{$row_->star}</span>
					<?php }else{ ?>
						<span style="color:red">{$row_->star}</span>
					<?php } ?>
				</div>
                <div class="col-xs-1">
                    {$row_->create_time}
                </div>
                <div class="col-xs-1">
                <?php if($row_->st=='不显示'){?>
                    <span style="color:red">{$row_->st}</span>
                <?php }else{?>
                    {$row_->st}
                    <?php }?>
                </div>
				<div class="col-xs-">
                    <a href="{:url('edit')}?id={$row_->id}"><button class="btn btn-success btn-xs edit_" >修改</button></a>
<?php if($row_->st=='不显示'){?>
                    <button class="btn btn-danger btn-xs del_cate" data-toggle="modal" data-target="#deleteSource" data-id="<?= $row_['id']?>" onclick="del_(this)"> 删除</button>
<?php }?>
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
		{$page_str}
	</footer>


	<!--弹出删除用户警告窗口-->
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
                        <input type="hidden" name="url" value="{$url}" >
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