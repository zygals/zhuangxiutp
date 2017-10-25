{extend name='layout:base' /}
{block name="title"}分类列表{/block}
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
                <button class="btn btn-yellow btn-xs">添加分类</button>
            </a>
        </div>
        <div class="col-xs-10">
            <form method="get" action="{:url('index')}">
                <div class="col-xs-5">

                    <select name="type_id" style="color:inherit">
                        <option value="">--请选择类型--</option>
                        <?php foreach (\app\back\model\Cate::$type_cate as $row_) { ?>
                            <option value="{$row_['type_id']}" {eq name="Think.get.type_id" value="$row_['type_id']"
                                    }selected{/eq}>{$row_['title']}</option>
                        <?php } ?>
                    </select>

                    <input type="text" name="name" value="{$Think.get.name}" class="form-control input-sm"
                           placeholder="输入名称搜索">


                </div>
                <div class=" col-xs-7" style=" padding-right: 40px;">
                    <select style="color:inherit" class=" form-control" name="paixu">
                        <option value="">--请选择排序字段--</option>
                        <option value="sort" {eq name="Think.get.paixu" value="sort"
                                }selected{/eq}>排序</option>
                        <option value="create_time" {eq name="Think.get.paixu" value="create_time"
                                }selected{/eq}>添加时间</option>
                        <option value="update_time" {eq name="Think.get.paixu" value="update_time"
                                }selected{/eq}>修改时间</option>
                    </select>
                    <label class="">
                        <input type="checkbox" name="sort_type" id="" value="desc" {eq name="Think.get.sort_type" value="desc"
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
            <div class="col-xs-2">
                名称
            </div>
            <div class="col-xs-1 ">
                类型
            </div>
            <div class="col-xs-1">
                排序
            </div>
            <div class="col-xs-2">
                添加时间
            </div>

            <div class="col-xs-">
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
                        <div class="col-xs-2" title="{$row_->name}">
                            {$row_->name}
                        </div>
                        <div class="col-xs-1 ">
                            {$row_->type}
                        </div>
                        <div class="col-xs-1">
                            {$row_->sort}
                        </div>
                        <div class="col-xs-2">
                            {$row_->create_time}
                        </div>

                        <div class="col-xs-">
                            <a href="<?php echo url('edit', "id=$row_->id") ?>">
                                <button class="btn btn-success btn-xs edit_">修改</button>
                            </a>
                            <button class="btn btn-danger btn-xs del_cate" data-toggle="modal"
                                    data-target="#deleteSource" data-id="<?= $row_['id'] ?>" onclick="del_(this)"> 删除
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
                    <form action="{:url('delete')}" method="get">
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