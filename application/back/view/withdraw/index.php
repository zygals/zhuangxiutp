{extend name='layout:base' /}
{block name="title"}提现列表{/block}

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
                    <!--<input type="text" id="" name="time_from" value="{$Think.get.time_from}"
                           class="form-control input-sm date_input" placeholder="从？如：2017-02-03">

                    <input type="text" id="" name="time_to" value="{$Think.get.time_to}"
                           class="form-control input-sm date_input" placeholder="到?如：2017-03-03"">-->

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



                </div>
                <div class=" col-xs-4" style=" padding-right: 40px;color:inherit">
                    <select class=" form-control" name="paixu">
                        <option value="">--请选择排序字段--</option>
                        <option value="cash" {eq name="Think.get.paixu" value="cash"
                                }selected{
                        /eq}>金额 </option>
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
                商家姓名
             </div>
            <div class="col-xs-1 ">
                申请金额
            </div>
            <div class="col-xs-1 ">
                状态
            </div>
            <div class="col-xs-1 ">
                资金状态
            </div>
            <div class="col-xs-1">
                申请时间
            </div>
            <div class="col-xs-2">
                审核时间
            </div>
            <div class="col-xs-2">
                转账时间
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
                        <div class="col-xs-1" title=" {$row_->admin_name}">
                            {$row_->admin_name}
                        </div>
                        <div class="col-xs-1" title=" {$row_->admin_truename}">
                            {$row_->admin_truename}
                        </div>
                        <div class="col-xs-1 " title="{$row_->cash}元">
                            {$row_->cash}元
                        </div>
                        <div class="col-xs-1" title=" {$row_->st}">
                            {$row_->st}
                        </div>
                        <div class="col-xs-1" title="  {$row_->cashst}">
                            {$row_->cashst}
                        </div>
                        <div class="col-xs-1" title="{$row_->create_time}">
                            {$row_->create_time}
                        </div>

                        <div class="col-xs-2">
                            <?php echo $row_->verify_time>0?date('Y-m-d H:i:s',$row_->verify_time):'无' ;?>
                        </div>
                        <div class="col-xs-2">
            <?php echo $row_->transfer_time>0?date('Y-m-d H:i:s',$row_->transfer_time):'无' ;?>
                        </div>
                        <div class="col-xs-">

                            <?php if(!\app\back\model\Admin::isShopAdmin() && $row_->st=='待审核'){ ?>

                                    <button class="btn btn-danger btn-xs edit_" title="点击是否能给商家转账？" onclick
                                    ="transferOk(this)"  data_id="{$row_->id}">审核</button>

                            <?php }?>
                            <?php if(!\app\back\model\Admin::isShopAdmin() && $row_->st=='审核通过' &&$row_->cashst=='待转账'){ ?>

                                <button class="btn btn-danger btn-xs edit_" title="线下已转账？" onclick
                                ="transferOk2(this)" data_cash="{$row_->cash}" data_id="{$row_->id}">转账</button>

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

   function transferOk2(obj) {
       var money= $(obj).attr('data_cash');
       var id= $(obj).attr('data_id');
       if(confirm('商家可用收益也会减少'+money)){
           var admin_pass = prompt('请输入管理员密码');
           if(admin_pass==''){
               alert('密码不能为空');
               return false;
           }
           $.ajax({
               method:'post',
               url:'{:url("update_cashst")}',
               data:{
                    pass_admin:admin_pass,
                    withdraw_id:id,
               },
               success:function (data) {
                   alert(data.msg);
                   if(data.code==0){
                       window.location.reload();
                   }
               }
               
           });

       }
   }
   function transferOk(obj) {
       var id= $(obj).attr('data_id');
       if(confirm('此操作可以分析商家是否能够正常提现，如审核状态为通过，则平台通过线下转账给商家。')){
           var admin_pass = prompt('请输入管理员密码');
           if(admin_pass==''){
               alert('密码不能为空');
               return false;
           }
           $.ajax({
               method:'post',
               url:'{:url("updateSt")}',
               data:{
                   pass_admin:admin_pass,
                   withdraw_id:id,
               },
               success:function (data) {
                   alert(data.msg);
                   if(data.code==0){
                       window.location.reload();
                   }
               }

           });

       }
   }

    function del_(obj) {
        var id = $(obj).attr('data-id');
        $('#del_id').val(id);
    }
</script>

{/block}