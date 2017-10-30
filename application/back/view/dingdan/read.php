{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
</style>

<!--弹出添加用户窗口--><form class="form-horizontal" action="" method="post"  >

    <div class="row" >
        <div class="col-xs-8">
            <div class="text-center">
                <!---->
                <h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
            </div>
            <div class="">
                <div class="container-fluid">

                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label">订单号：</label>
                        <div class="col-xs-8 ">
                            <label>{$row_order->orderno}</label>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label">状态：</label>
                        <div class="col-xs-8 ">
                            <label>{$row_order->st}，{$row_order->goodst}</label>
                        </div>
                    </div>
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
                    <?php foreach($list_good as $k=>$row_good){?>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><?php if($k==0){?>商品：<?php }?></label>
                            <div class="col-xs-8">
                                <div class="col-xs-6">
                                    <img src="__IMGURL__{$row_good->img}" alt="没有上传图片" width="136"/>
                                </div>
                                <div class="col-xs-6">
                                    <p>编号：{$row_good->good_id}</p>
                                    <p>{$row_good->good_name}</p>
                                    <p>{$row_good->price} * {$row_good->num}</p>
                                    <p>{$row_good->st}</p>
									<?php if($row_order->st=='已支付' && $row_good->st=='没发货'){?>
										<a href="javascript:if(confirm('确认已发货了吗？'))window.location.href='{:url('change_goodst')}?order_good_id={$row_good->id}'">确认发货</a>
									<?php }?>
									<!--<p>状态：<label><input type="radio" name="st" <?/*= $row_good->st=='1'?'checked':'';*/?>/>待发货</label>
										<label><input type="radio" name="st"/>已发货</label></p>-->
                                </div>

                            </div>
                    </div>
                    <?php }?>

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



</script>

{/block}
