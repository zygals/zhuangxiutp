{extend name='layout:base' /}
{block name="title"}花卉列表{/block}

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
        <div class="col-xs-2">
            <a href="{:url('create')}">
                <button class="btn btn-yellow btn-xs">添加菜单</button>
            </a>
        </div>
    </div>
    <div class="data-div">
        <div class="row tableHeader">
            <div class="col-xs-1 ">
                编 号
            </div>
            <div class="col-xs-2 ">
                导航名称
            </div>
            <div class="col-xs-1 ">
                导航上级
            </div>
            <div class="col-xs-1 ">
                控制器
            </div>
            <div class="col-xs-1">
                方法
            </div>
            <div class="col-xs-1">
                商户可用
            </div>

            <div class="col-xs-1">
                排序
            </div>
            <div class="col-xs-4">
                操 作
            </div>
        </div>
        <div class="tablebody">
            <?php if (count($list_) > 0) { ?>
                <?php foreach ($list_ as $key => $row_) { ?>
                    <div class="row cont_nowrap">
                        <div class="col-xs-1 ">
                            {$row_->id}
                        </div>
                        <div class="col-xs-2 " title="{$row_->name}">
                            {$row_->name}
                        </div>
                        <div class="col-xs-1 ">
                            {$row_->getName($row_->pid)}
                        </div>
                        <div class="col-xs-1 " title="{$row_->controller}">
                            {$row_->controller}
                        </div>
                        <div class="col-xs-1">
                            {$row_->action}
                        </div>
                        <div class="col-xs-1" title="{$row_->is_show_to_shop}">
                            {$row_->is_show_to_shop}
                        </div>
                        <div class="col-xs-1">
                            {$row_->sort}
                        </div>

                        <div class="col-xs-4">
                            <a href="{:url('edit')}?id={$row_->id}">
                                <button class="btn btn-success btn-xs edit_">修改</button>
                            </a>
                            <button class="btn btn-danger btn-xs del_cate" data-toggle="modal"
                                    data-target="#deleteSource" data-id="<?= $row_['id'] ?>" onclick="del_(this)"> 删除
                            </button>
                        </div>

                    </div>
                    <?php foreach($row_->childs as $k2=>$row_child){?>
                        <div class="row cont_nowrap">
                            <div class="col-xs-1 ">
                                {$row_child->id}
                            </div>
                            <div class="col-xs-2 " title="{$row_->name}">
                                {$row_child->name}
                            </div>
                            <div class="col-xs-1 ">
                                {$row_->getName($row_child->pid)}
                            </div>
                            <div class="col-xs-1 " title="{$row_->controller}">
                                {$row_child->controller}
                            </div>
                            <div class="col-xs-1">
                                {$row_child->action}
                            </div>
                            <div class="col-xs-1" title=" {$row_->is_show_to_shop}">
                                {$row_child->is_show_to_shop}
                            </div>
                            <div class="col-xs-1">
                                {$row_child->sort}
                            </div>

                            <div class="col-xs-4">
                                <a href="{:url('edit')}?id={$row_child->id}">
                                    <button class="btn btn-success btn-xs edit_">修改</button>
                                </a>
                                <button class="btn btn-danger btn-xs del_cate" data-toggle="modal"
                                        data-target="#deleteSource" data-id="<?= $row_child['id'] ?>" onclick="del_(this)"> 删除
                                </button>
                            </div>

                        </div>
                        <?php }?>
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
                    <form action="{:url('delete')}" method="get">
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

    function del_(obj) {
        var id = $(obj).attr('data-id');
        $('#del_id').val(id);
    }

</script>

{/block}