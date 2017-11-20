{extend name='layout:base' /}
{block name="title"}管理员{/block}
{block name="content"}
<div role="tabpanel" class="tab-pane active" id="sour">
    <div class="check-div form-inline">
        <div class="col-xs-4">
            <a href="{:url('create_')}">
                <button class="btn btn-yellow btn-xs">添加平台管理员</button>
            </a>
        </div>
        <div class="col-xs-">
            <form method="get" action="{:url('index')}" id="searchForm">
                <input type="text" name="shop_id" value="{$Think.get.shop_id}" class="form-control input-sm"
                       placeholder="输入商家编号进行搜索">
                <input type="text" name="name_" value="{$Think.get.name_}" class="form-control input-sm"
                       placeholder="输入账号/姓名进行搜索">
                <button class="btn btn-white btn-xs " type="submit">提交</button>
            </form>
        </div>

    </div>
    <div class="data-div">
        <div class="row tableHeader">
            <div class="col-sm-1 ">
                编码
            </div>
            <div class=" col-sm-1 ">
                账号
            </div>
            <div class=" col-sm-1 ">
                姓名
            </div>
            <div class=" col-sm-1 ">
                身份
            </div>
            <div class=" col-sm-1 ">
                商家编号
            </div>
            <div class=" col-sm-1 ">
                收益
            </div>
            <div class=" col-sm-2 ">
                创建时间
            </div>
            <div class=" col-sm-1 ">
                状态
            </div>
            <div class="col-sm-">
                操作
            </div>
        </div>
        <div class="tablebody">
            <?php foreach ($list_admin as $key => $admin) { ?>
                <div class="row cont_nowrap">
                    <div class="col-sm-1">
                        <?= $admin['id'] ?>
                    </div>
                    <div class="col-sm-1" title="{$admin->name}">
                        <span><?= $admin['name'] ?></span>
                    </div>
                    <div class="col-sm-1" title="{$admin->truename}">
                        <?= $admin['truename'] ?>
                    </div>
                    <div class="col-sm-1">
                        <?= $admin['type'] ?>
                    </div>
                    <div class="col-sm-1" title="{$admin->shop_id}">
                        <?= $admin['shop_id'] ?>
                    </div>
                    <div class="col-sm-1" title="{$admin->income}">
                        {$admin->income}
                    </div>
                    <div class="col-sm-2">
                        <?= $admin['create_time'] ?>
                    </div>
                    <div class="col-sm-1">
                        <?php if ($admin['st'] == '正常') { ?>
                            <?= $admin['st'] ;?>
                        <?php } else { ?>
                            <span style="color:red"><?= $admin['st'] ;?></span>
                        <?php } ?>
                    </div>
                    <div class="col-sm-">
                        <?php if ($admin['type'] == '超级' && \app\back\model\Admin::isAdmin()) { ?>
                            <a href="{:url('edit')}">
                                <button class="btn btn-success btn-xs edit_">改密</button>
                            </a>
                        <?php } elseif ($admin->type == '一般' && \app\back\model\Admin::isAdmin()) { ?>
                            <a href="{:url('edit_general')}?admin_id={$admin['id']}">
                                <button class="btn btn-success btn-xs edit_">修改</button>
                            </a>
                            <button class="btn btn-danger btn-xs del_cate" data-toggle="modal"
                                    data-target="#deleteSource" data-id="<?= $admin['id'] ?>" onclick="del_(this)"> 删除
                            </button>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!--页码块-->
<footer class="footer">
    {$page_str}
</footer>

<!-- /.modal -->
<!--弹出删除资源警告窗口-->
<div class="modal fade" id="deleteSource" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">提示</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    确定要删除该资源？删除后不可恢复！
                </div>
            </div>
            <div class="modal-footer">
                <form method="post" action="{:Url('delete')}">
                    <input type="hidden" name="id" value="" id="del_id"/>
                    <input type="hidden" name="url" value="{$url}" id="">
                    <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">取 消</button>
                    <button type="submit" class="btn btn-xs btn-danger">确 定</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    $(function () {

    });

    //delete
    function del_(obj) {
        var id = $(obj).attr('data-id');
        $('#del_id').val(id);
    }

</script>
{/block}
