{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
	.control-label {
		padding-right: 10px;
	}
</style>

<!--弹出添加用户窗口-->
<form class="form-horizontal" action="" method="post">

	<div class="row">
		<div class="col-xs-8">
			<div class="text-center">
				<!---->
				<h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
			</div>
			<div class="">
				<div class="container-fluid">
					<?php if ( $row_order->order_contact_id > 0 ) { ?>
						<div class="form-group ">
							<label for="sName" class="col-xs-3 control-label">联合订单号：</label>

							<div class="col-xs-8 ">
								<label>{$row_order->orderno_contact}</label>
							</div>
						</div>
					<?php } ?>
					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">订单号：</label>

						<div class="col-xs-8 ">
							<label>{$row_order->orderno}</label>
						</div>
					</div>
					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">订单类型：</label>

						<div class="col-xs-8 ">
							<label>{$row_order->type}</label>
						</div>
					</div>
					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">状态：</label>

						<div class="col-xs-8 ">
							<label>{$row_order->st}</label>
							<?php if ( $row_order->st == '未支付' && \app\back\model\Admin::isAdmin() ) { ?>
								<button onclick="order_st_paid('{$row_order->id}')">改为已支付</button>
							<?php } ?>
						</div>
					</div>
					<?php if($row_order->type=='普通' || $row_order->type=='限人'){?>
						<div class="form-group ">
							<label for="sName" class="col-xs-3 control-label">商品状态：</label>

							<div class="col-xs-8 ">
								<label>{$row_order->goodst}</label>
							</div>
						</div>
					<?php }?>


					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">会员用户名：</label>

						<div class="col-xs-8 ">
							<label>{$row_order->username}</label>
						</div>
					</div>
					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">商户名称：</label>

						<div class="col-xs-8 ">
							<label>{$row_order->shop_id}:{$row_order->shop_name}</label>
						</div>
					</div>
					<?php foreach ( $list_good as $k => $row_good ) { ?>
						<div class="form-group ">
							<label for="sName"
								   class="col-xs-3 control-label"><?php if ( $k == 0 ) { ?>商品：<?php } ?></label>

							<div class="col-xs-8">
								<div class="col-xs-6">
									<img src="__IMGURL__{$row_good->img}" alt="没有上传图片" width="136"/>
								</div>
								<div class="col-xs-6">
									<p>编号：{$row_good->good_id}</p>
									<p>商品：{$row_good->good_name}</p>
									<p>单价*数量：{$row_good->price} * {$row_good->num}</p>
<?php if($row_order->getData('type')==3 ||$row_order->getData('type')==6){?>
	<p>团购价：{$row_good->price_group}</p>
	<p>团购订金：{$row_good->group_deposit}</p>
									<?php }?>
									<p>{$row_good->st}</p>
									<?php if ( $row_order->st == '已支付' && $row_good->st == '没发货' && $row_order->getData('type')!==3) { ?>
										<a href="javascript:if(confirm('确认已发货了吗？'))window.location.href='{:url('change_goodst')}?order_good_id={$row_good->id}'">确认发货</a>
									<?php } ?>
									<!--<p>状态：<label><input type="radio" name="st" <? /*= $row_good->st=='1'?'checked':'';*/ ?>/>待发货</label>
										<label><input type="radio" name="st"/>已发货</label></p>-->
								</div>

							</div>
						</div>
					<?php } ?>

					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">总额：</label>

						<div class="col-xs-8 ">
							<label>{$row_order->sum_price}</label>
						</div>
					</div>

					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">收货人信息：</label>

						<div class="col-xs-8 ">
							<div>
								<span>姓名：</span>
								<span>{$row_order->truename}</span>
							</div>
							<div>
								<span>电话：</span>
								<span>{$row_order->mobile}</span>
							</div>
							<div>
								<span>地址：</span>
								<span>{$row_order->pcd} {$row_order->info}</span>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">备注：</label>

						<div class="col-xs-8 ">
							<label>{$row_order->beizhu}</label>
						</div>
					</div>
					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">创建时间：</label>

						<div class="col-xs-8 ">
							<label>{$row_order->create_time}</label>
						</div>
					</div>
					<div class="form-group ">
						<label for="sName" class="col-xs-3 control-label">修改时间：</label>

						<div class="col-xs-8 ">
							<label>{$row_order->update_time}</label>
						</div>
					</div>

				</div>
				<!-- <div class="text-center">
						<a href="javascript:history.back()">
							<button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回</button>
						</a>

					</div>-->
			</div>
		</div>
</form>

<script>

	function order_st_paid(order_id) {
		//alert()
		if (confirm('确定更改订单为已支付吗？')) {
			var pass_admin = prompt('请输入管理员密码：');
			$.ajax({

				"url": "{:url('order_paid')}",
				"data": {
					pass_admin: pass_admin,
					order_id: order_id
				},
				success: function (data) {
					alert(data.msg)
					if (data.code == 0) {
						window.location.href = '';
					}
				}

			})

		}

	}

</script>

{/block}
