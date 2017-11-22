{extend name='layout:base' /}
{block name="title"}商户列表{/block}
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

</script>
<div role="tabpanel" class="tab-pane" id="user" style="display:block;">
    <div class="check-div form-inline row">
        <div class="col-xs-2">
            <a href="{:url('create')}">
                <button class="btn btn-yellow btn-xs" data-toggle="modal" data-target="#addUser" id="create">添加商户
                </button>
            </a>
        </div>
        <div class="col-xs-10">
            <form method="get" action="{:url('index')}" id="searchForm">
                <div class="col-xs-7">
                    <?php if (!$isShopAdmin) { ?>
                        <select name="cate_id" style="color:inherit">

                            <option value="">--请选择分类--</option>
                            <?php foreach ($list_cate as $row_) { ?>
                                <option value="{$row_->id}" {eq name="Think.get.cate_id" value="$row_->id"
                                        }selected{/eq}>{$row_->name}</option>
                            <?php } ?>

                        </select>

                        <input type="text" name="name_" value="{$Think.get.name_}" class="form-control input-sm"
                               placeholder="输入名称/姓名/城市搜索"/>
                    <?php } ?>


                </div>
                <div class=" col-xs-5" style=" padding-right: 40px;color:inherit">
                    <select class=" form-control" name="paixu">
                        <option value="">--排序字段--</option>
                        <option value="sort" {eq name="Think.get.paixu" value="sort"
                                }selected{/eq}>排序</option>
                        <option value="ordernum" {eq name="Think.get.paixu" value="ordernum"
                                }selected{/eq}>订单数</tion>
                        <option value="tradenum" {eq name="Think.get.paixu" value="tradenum"
                                }selected{/eq}>交易数</option>
                        <option value="create_time" {eq name="Think.get.paixu" value="create_time"
                                }selected{/eq}>添加时间</option>
                        <option value="update_time" {eq name="Think.get.paixu" value="update_time"
                                }selected{/eq}>修改时间</option>
                    </select>
                    <label class="">
                        <input type="checkbox" name="sort_type" id="" value="desc" {eq name="Think.get.sort_type"
                               value="desc"
                               }checked{/eq}>降序</label>
                    <label class="">
                        <input type="checkbox" name="to_top" id="" value="1" {eq name="Think.get.to_top" value="1"
                               }checked{/eq}>置顶</label>
                    <label class="">
                        <input type="checkbox" name="down" id="" value="1" {eq name="Think.get.down" value="1"
                               }checked{/eq}>关</label>
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
            <div class="col-xs-1 ">
                名称
            </div>
            <div class="col-xs-1 ">
                分类
            </div>
            <div class="col-xs-1">
                商家姓名
            </div>
            <div class="col-xs-1">
                手机
            </div>
            <div class="col-xs-1">
                地址
            </div>
            <div class="col-xs-1">
                logo
            </div>
            <!--   <div class="col-xs-1">
                   列表图
               </div>-->
            <div class="col-xs-1">
                订单量
            </div>
            <div class="col-xs-1">
                交易量
            </div>
            <div class="col-xs-1">
                管理员
            </div>
            <!--   <div class="col-xs-1">
                   添加时间
               </div>-->
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
                        <div class="col-xs-1 " title="{$row_->name}">
                            {$row_->name}
                        </div>
                        <div class="col-xs-1 "  title="{$row_->cate_name}">
                            {$row_->cate_name}
                        </div>
                        <div class="col-xs-1 " title="{$row_->truename}">
                            {$row_->truename}
                        </div>
                        <div class="col-xs-1 " title="{$row_->phone}">
                            {$row_->phone}
                        </div>
                        <div class="col-xs-1 " title="{$row_->addr}">
                            {$row_->addr}
                        </div>
                        <div class="col-xs-1">
                            <a href="__IMGURL__{$row_->logo}" target="_blank">
                                <img src="__IMGURL__{$row_->logo}" height="55" alt="没有">
                            </a>
                        </div>
                        <!--<div class="col-xs-1">
                                    <a href="__IMGURL__{$row_->img}" target="_blank">
                                        <img src="__IMGURL__{$row_->img}" height="55"  alt="没有">
                                    </a>
                                </div>-->
                        <div class="col-xs-1" title=" {$row_->ordernum}">
                            {$row_->ordernum}
                        </div>
                        <div class="col-xs-1" title=" {$row_->tradenum}">
                            {$row_->tradenum}
                        </div>
                        <div class="col-xs-1" title="{$row_->admin_name}">
                            <?php if ($row_->admin_st != 1) { ?>
                                <span style="color:red;"> {$row_->admin_name}</span>
                            <?php } else { ?>
                                {$row_->admin_name}
                            <?php } ?>
                        </div>
                        <!--  <div class="col-xs-1" title=" {$row_->create_time}">
                              {$row_->create_time}
                          </div>-->

                        <div class="col-xs-">
                            <?php if (empty($row_->admin_id)) { ?>
                                <a href="{:url('admin/create')}?shop_id={$row_->id}">
                                    <button class="btn btn-success btn-xs edit_" title="添加管理员">加管</button>
                                </a>
                            <?php } else { ?>
                                <a href="{:url('admin/edit_')}?admin_id={$row_->admin_id}&shop_id={$row_->id}">
                                    <button class="btn btn-success btn-xs edit_" title="改管理员">改管</button>
                                </a>
                            <?php } ?>
                            <a href="{:url('edit')}?id={$row_->id}">
                                <button class="btn btn-success btn-xs edit_" title="修改商户">改</button>
                            </a>

                            <?php if ($row_->is_add_address == 0) { ?>
                                <a href="{:url('add_address')}?id={$row_->id}">
                                    <button class="btn btn-success btn-xs edit_" title="添加店铺地址">加地</button>
                                </a>
                            <?php } else { ?>
                                <a href="{:url('edit_address')}?id={$row_->id}">
                                    <button class="btn btn-success btn-xs edit_" title="修改店铺地址">改地</button>
                                </a>
                            <?php } ?>

                            <?php if ($row_->st == '关') { ?>
                                <button class="btn btn-danger btn-xs del_cate" data-toggle="modal"
                                        data-target="#deleteSource" data-id="<?= $row_['id'] ?>" onclick="del_(this)" title="删除"> 删
                                </button>
                            <?php } else{?>
                                <a href="{:url('edit_guan')}?id={$row_->id}">
                                    <button class="btn btn-danger btn-xs" title="前台不显示">关</button>
                                </a>
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
                        确定删除数据吗？删除商户后，对应的管理员也被删除。
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