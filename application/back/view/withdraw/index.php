{extend name='layout:base' /}
{block name="title"}会员列表{/block}

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
                    <input type="text" id="" name="time_from" value="{$Think.get.time_from}"
                           class="form-control input-sm date_input" placeholder="从？如：2017-02-03">

                    <input type="text" id="" name="time_to" value="{$Think.get.time_to}"
                           class="form-control input-sm date_input" placeholder="到?如：2017-03-03"">

                    <input type="text" name="cash" value="" class="form-control input-sm"
                           placeholder="输入金额">

                    <select name="st" id="" class="form-control">
                        <option value="">--申请状态--</option>
                        <?php foreach (app\back\model\Withdraw::$stStatus as $k => $v) { ?>
                            <option value="{$k}" <?php echo isset($_GET['st']) ? $k === (int)$_GET['st'] ? 'selected' : '' : ''; ?>>
                                {$v}
                            </option>
                        <?php } ?>
                    </select>

                    <select name="cash_st" id="" class="form-control">
                        <option value="">--资金状态--</option>
                        <?php foreach (app\back\model\Withdraw::$cashStStatus as $m => $n) { ?>
                            <option value="{$m}" <?php echo isset($_GET['cash_st']) ? $m === (int)$_GET['cash_st'] ? 'selected' : '' : ''; ?>>
                                {$n}
                            </option>
                        <?php } ?>
                    </select>

                </div>
                <div class=" col-xs-4" style=" padding-right: 40px;color:inherit">
                    <select class=" form-control" name="paixu">
                        <option value="">--请选择排序字段--</option>
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
                编号
            </div>
            <div class="col-xs-1 ">
                帐号
            </div>
            <div class="col-xs-1 ">
                真实姓名
                </div>
            <div class="col-xs-1 ">
                申请金额
            </div>
            <div class="col-xs-1 ">
                申请状态
            </div>
            <div class="col-xs-1">
                资金状态
            </div>
            <div class="col-xs-2">
                申请时间
            </div>
            <div class="col-xs-">
                <?php if(!\app\back\model\Admin::isShopAdmin()){ ?>
                操作
                <?php }?>
            </div>
        </div>
        <div class="tablebody">
            <?php if (count($list_) > 0){ ?>
                <?php foreach ($list_ as $key => $row_){ ?>
                    <div class="row cont_nowrap">
                        <div class="col-xs-1">
                            {$row_->id}
                        </div>
                        <div class="col-xs-1" title="admin_id">
                            {$row_->admin_name}
                        </div>
                        <div class="col-xs-1" title="admin_truename">
                            {$row_->admin_truename}
                        </div>
                        <div class="col-xs-1 " title=" ">
                            {$row_->cash}元
                        </div>
                        <div class="col-xs-1">
                            {$row_->st}
                        </div>
                        <div class="col-xs-1">
                            {$row_->cash_st}
                        </div>
                        <div class="col-xs-2">
                            {$row_->create_time}
                        </div>
                        <div class="col-xs-">
                            <?php if(!\app\back\model\Admin::isShopAdmin()){ ?>
                                <a href="{:url('editSt')}?id={$row_->id}">
                                    <button class="btn btn-success btn-xs edit_" title="修改">修改</button>
                                </a>
                            <?php }?>

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
                    <form action="" method="post">
                        <input type="hidden" name="id" value="" id="del_id">
                        <input type="hidden" name="url" value="">
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
    function modalShow(url, id) {
        window.open(url + "?id=" + id, 'orderDetail', "width=900,height=500,left=200,top=180,location=no,menubar=0");
    }
    function del_(obj) {
        var id = $(obj).attr('data-id');
        $('#del_id').val(id);
    }
</script>

{/block}