{extend name='layout:base' /}
{block name="title"}订单列表{/block}

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
    <div class="check-div form-inline">
        <div class="row">
            <form method="get" action="{:url('index')}" id="searchForm">
                <div class="col-xs-8">
                    <input type="datetime-local" id="" name="time_from" value="{$Think.get.time_from}"
                           class="form-control input-sm " placeholder="日期从">
                    <!-- <input type="text" id="" name="time_from" value="{$Think.get.time_from}"
                            class="form-control input-sm date_input" placeholder="日期从">-->
                    <input type="datetime-local" id="" name="time_to" value="{$Think.get.time_to}"
                           class="form-control input-sm" placeholder="到">
                    <!--  <input type="text" id="" name="time_to" value="{$Think.get.time_to}"
                             class="form-control input-sm date_input" placeholder="到">-->
                    <!--<input type="text" name="orderno" value="{$Think.get.orderno}" class="form-control input-sm"
                           placeholder="输入订单编号">
                    <input type="text" name="shop_id" value="{$Think.get.shop_id}" class="form-control input-sm"
                           placeholder="输入店铺ID">-->
                    <select name="st" id="" class="form-control">
                        <option value="">－－选择状态－－</option>
                        <?php foreach (app\back\model\Dingdan::$arrStatus as $k => $v) { ?>
                            <option value="{$k}" <?php echo isset($_GET['st']) ? $k === (int)$_GET['st'] ? 'selected' : '' : ''; ?>>
                                {$v}
                            </option>
                        <?php } ?>
                    </select>
                    <select name="goodst" id="" class="form-control">
                        <option value="">－－商品状态－－</option>
                        <?php foreach (app\back\model\Dingdan::$arrGoodSt as $k => $v) { ?>
                            <option value="{$k}" <?php echo isset($_GET['goodst']) ? $k === (int)$_GET['goodst'] ? 'selected' : '' : ''; ?>>
                                {$v}
                            </option>
                        <?php } ?>
                    </select>
                    <select name="type" id="" class="form-control">
                        <option value="">－－选择类型－－</option>
                        <?php foreach (app\back\model\Dingdan::$arrType as $k => $v) { ?>
                            <option value="{$k}" <?php echo isset($_GET['type']) ? $k === (int)$_GET['type'] ? 'selected' : '' : ''; ?>>
                                {$v}
                            </option>
                        <?php } ?>
                    </select>
                    <select class=" form-control" name="sel_type">
                        <option value="">--商家名称等--</option>
                        <option value="shop_name" <?php echo isset($_GET['sel_type']) ? $_GET['sel_type'] == 'shop_name' ? 'selected' : '' : ''; ?>>商家名称</option>
                        <option value="brand" <?php echo isset($_GET['sel_type']) ? $_GET['sel_type'] == 'brand' ? 'selected' : '' : ''; ?>>商家品牌</option>
                        <option value="truename" <?php echo isset($_GET['sel_type']) ? $_GET['sel_type'] == 'truename' ? 'selected' : '' : ''; ?>>用户姓名</option>
                        <option value="mobile" <?php echo isset($_GET['sel_type']) ? $_GET['sel_type'] == 'mobile' ? 'selected' : '' : ''; ?>>用户手机</option>

                        <option value="orderno" <?php echo isset($_GET['sel_type']) ? $_GET['sel_type'] == 'orderno' ? 'selected' : '' : ''; ?>>订单号 </option>

                    </select>
                    <input type="text" name="name_" value="{$Think.get.name_}" class="form-control input-sm"
                           placeholder="输入对应内容">
                </div>
                <div class=" col-xs-4" style=" padding-right: 40px;color:inherit">
                    <select class=" form-control" name="paixu">
                        <option value="">--请选择排序字段--</option>
                        <option value="sum_price" <?php echo isset($_GET['paixu']) ? $_GET['paixu'] == 'sum_price' ? 'selected' : '' : ''; ?>>总价</option>
                        <option value="create_time" <?php echo isset($_GET['paixu']) ? $_GET['paixu'] == 'create_time' ? 'selected' : '' : ''; ?>>添加时间</option>
                        <option value="update_time" <?php echo isset($_GET['paixu']) ? $_GET['paixu'] == 'update_time' ? 'selected' : '' : ''; ?>>修改时间</option>
                    </select>
                    <label class="">
                        <input type="checkbox" name="sort_type" id="" value="desc" {eq name="Think.get.sort_type"
                               value="desc"
                               }checked{/eq}>降序</label>

                    <button class="btn btn-white btn-xs " name="sub" value="" type="submit">提交</button>
                    <button class="btn btn-white btn-xs " name="excel" value="1" type="submit">导出表格</button>
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
                联合编号
            </div>
            <div class="col-xs-1">
                类型
            </div>
            <div class="col-xs-2">
                订单编号
            </div>
            <div class="col-xs-1">
                商户名
            </div>
            <div class="col-xs-1 ">
                用户
            </div>
            <div class="col-xs-1" title="{$list_->sum_all_price}">
                总价
            </div>

            <div class="col-xs-1">
                创建时间
            </div>
            <div class="col-xs-1">
                状态
            </div>
            <div class="col-xs-1">
                商品状态
            </div>
            <div class="col-xs-">
                操 作({$list_->total()})
            </div>
        </div>
        <div class="tablebody">
            <?php if (count($list_) > 0) { ?>
                <?php foreach ($list_ as $key => $row_) { ?>
                    <div class="row cont_nowrap">
                        <div class="col-xs-1">
                            {$row_->id}
                        </div>
                        <div class="col-xs-1" title=" {$row_->orderno_contact}">
                            <?= $row_->orderno_contact ? $row_->orderno_contact : '无' ?>
                        </div>
                        <div class="col-xs-1" title=" {$row_->type}">
                            <?= $row_->type; ?>
                        </div>
                        <div class="col-xs-2" title=" {$row_->orderno}">
                            {$row_->orderno}
                        </div>
                        <div class="col-xs-1" title=" {$row_->shop_name}">
                            {$row_->shop_id}:{$row_->shop_name}
                        </div>
                        <div class="col-xs-1">
                            {$row_->username}
                        </div>
                        <div class="col-xs-1">
                            {$row_->sum_price}
                        </div>
                        <div class="col-xs-1" title="{$row_->create_time}">
                            {$row_->create_time}
                        </div>

                        <div class="col-xs-1">
                            {$row_->st}
                        </div>

                        <div class="col-xs-1">
                                {$row_->goodst}
                        </div>
                        <div class="col-xs-">
                            <button class="btn btn-success btn-xs "
                                    onclick="modalShow('{:url(\'read\')}','{$row_->id}')"  title="订单详情?">查
                            </button>
                            <?php if ($row_->st == '申请退款' && \app\api\model\Admin::isAdmin()) { ?>
                                <a href="javascript:allow_refund({$row_->id})">
                                    <button class="btn btn-danger btn-xs" title="同意退款?">退</button>
                                </a>
                                <a href="javascript:cancel_refund({$row_->id})">
                                    <button class="btn btn-danger btn-xs" title="取消退款?">消</button>
                                </a>
                            <?php } ?>
                            <?php if ($row_->st == '用户删除') { ?>
                                <button class="btn btn-danger btn-xs del_cate" data-toggle="modal"
                                        data-target="#deleteSource"
                                        data-id="<?= $row_['id'] ?>" onclick="del_(this)"> 删
                                </button>
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
</div>
<script>

    function cancel_refund(order_id) {
        if (!confirm('确定取消退款么？')) {
            return false;
        }
        $.ajax({
            url: "{:url('api/dingdan/update_st')}",//前台退款接口
            method: 'post',
            data: {
                order_id: order_id,
                st: 'refundCancelByUser',
            },
            success: function (res) {
                alert(res.msg)
                if (res.code == 0) {
                    location.reload();
                }
            }

        })

    }
    function allow_refund(order_id) {
        if (!confirm('确定给用户退款么？')) {
            return false;
        }
        var admin_pass = prompt('请输入管理员密码：');
        if (admin_pass == '') {
            alert('密码不能为空!')
            return false;
        }
        $.ajax({
            url: "{:url('api/pay/refund')}",//前台退款接口
            method: 'post',
            data: {
                order_id: order_id,
                admin_pass: admin_pass,
            },
            success: function (res) {
                alert(res.msg)
                if (res.code == 0) {
                    location.reload();
                }
            }

        })
    }
    function modalShow(url, id) {
        window.open(url + "?id=" + id, 'orderDetail', "width=900,height=500,left=200,top=180,location=no,menubar=0");
    }
    function del_(obj) {
        var id = $(obj).attr('data-id');
        $('#del_id').val(id);
    }
</script>

{/block}