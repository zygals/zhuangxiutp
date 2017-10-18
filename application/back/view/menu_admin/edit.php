{extend name='layout:base' /}
{block name="title"}编辑菜单{/block}

{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
</style>

	<!--弹出添加用户窗口--><form class="form-horizontal" action="{:url('update')}" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="id" value="{$row_->id}">
		<div class="row" >
			<div class="col-xs-8">
				<div class="text-center">
					<h4 class="modal-title" id="gridSystemModalLabel">编辑菜单</h4>
				</div>
				<div class="">
					<div class="container-fluid">
                        <?php if(!empty($list_menu)){?>
                        <div class="form-group">
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>上级：</label>
                            <div class="col-xs-8">
                                <select class=" form-control select-duiqi" name="pid" id="a_cate_id">
                                    <option value="0">-- 一级 --</option>
                                    <?php foreach ($list_menu as $k => $row_m) { ?>
                                        <option value="{$row_m->id}" <?php echo $row_m->id==$row_->pid?"selected":''?>>{$row_m->name}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php }?>
							<div class="form-group ">
								<label for="sName" class="col-xs-3 control-label">名称：</label>
								<div class="col-xs-8 ">
									<input type="text" class="form-control input-sm duiqi" name='name' value="{$row_->name}" id="sName" placeholder="">
								</div>
							</div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>控制器：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='controller' value="{$row_->controller}" id=""
                                       placeholder="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>方法：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='action' value="{$row_->action}" id=""
                                       placeholder="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label">参数：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='param' value="{$row_->param}" id=""
                                       placeholder="">
                            </div>
                        </div>

                        <div class="form-group" id="diliver_fee_wrap" style=";">
                            <label for="situation" class="col-xs-3 control-label">排序：</label>
                            <div class="col-xs-8">
                                <label class="control-label">
                                    <input type="number" name="sort" class="form-control input-sm duiqi" id=""
                                           value="{$row_->sort}"></label> &nbsp;

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="situation" class="col-xs-3 control-label">商户是否可用：</label>
                            <div class="col-xs-8">
                                <label class="control-label" >
                                    <input type="radio" name="is_show_to_shop" id="" value="1" <?php echo $row_->getData('is_show_to_shop')==1?'checked':''?>>可用</label> &nbsp;
                                <label class="control-label">
                                    <input type="radio" name="is_show_to_shop" id="" value="0" <?php echo $row_->getData('is_show_to_shop')==0?'checked':''?>> 不可用</label>
                            </div>
                        </div>
					</div>
				</div>
				<div class="text-center">
                    <a href="{:url('index')}"><button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回列表 </button></a>
					<button type="submit" class="btn btn-xs btn-green">保 存</button>
				</div>
			</div>
		</div>
</form>

<script>
   $(function () {
        $('form').bootstrapValidator({
            fields: {
                name: {
                    validators:
                        {
                            notEmpty: {
                                message: '不能为空'
                            }
                        }

                }
            }
        });

    });

</script>

{/block}
