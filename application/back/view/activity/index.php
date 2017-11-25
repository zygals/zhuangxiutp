{extend name='layout:base' /}
{block name="title"}在线活动列表{/block}
{block name="content"}
<style>
	.pagination li.disabled>a, .pagination li.disabled>span{color:inherit;}
	.pagination li>a, .pagination li>span{color:inherit}
</style>
<div role="tabpanel" class="tab-pane" id="user" style="display:block;">
	<div class="check-div form-inline row">
				<div class="col-xs-2">
                    <a href="{:url('create')}"><button class="btn btn-yellow btn-xs" data-toggle="modal" data-target="#addUser" id="create">添加活动</button></a>
		</div>
		<div class="col-xs-10">
            <form method="get" action="{:url('index')}" id="searchForm">
                <div class="col-xs-7">
                    <select name="type"  class=" form-control">
                        <option value="">--请选择类型--</option>
                        <option value="1" {eq name="Think.get.type" value="1"
                                }selected{/eq}>在线</option>
                        <option value="2" {eq name="Think.get.type" value="2"
                                }selected{/eq}>验房</option>
                    </select>
                    <select name="online"  class=" form-control">
                        <option value="">--请选择活动时间--</option>
                        <option value="now" {eq name="Think.get.online" value="now"
                                }selected{/eq}>进行</option>
                        <option value="end" {eq name="Think.get.online" value="end"
                                }selected{/eq}>结束</option>
                    </select>
                    <input type="text" name="name" value="{$Think.get.name}" class="form-control input-sm"
                           placeholder="输入标题进行搜索">
                </div>
                <div class=" col-xs-5" style=" padding-right: 40px;color:inherit">
                    <select class=" form-control" name="paixu">
                        <option value="">--请选择排序字段--</option>
                       <!-- <option value="sort" {eq name="Think.get.paixu" value="sort"
                                }selected{/eq}>排序</option>-->
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
			<div class="col-xs-1">
                标题
			</div>
           <!-- <div class="col-xs-2">
                链接
            </div>-->
			<div class="col-xs-1">
                图片
			</div>
            <div class="col-xs-2">
                活动地址
            </div>
            <div class="col-xs-2">
                活动开始
            </div>
            <div class="col-xs-2">
                活动结束
            </div>
            <div class="col-xs-2">
                添加时间
            </div>
			<div class="col-xs-">
				操 作
			</div>
		</div>
		<div class="tablebody">
			<?php if(count($list_)>0){?>
			<?php foreach($list_ as $key=>$row_){?>
			<div class="row cont_nowrap">
                <div class="col-xs-1 ">
                    {$row_->id}
                </div>
				<div class="col-xs-1 " title="{$row_->name}">
					{$row_->name}
				</div>

				<div class="col-xs-1">
                    <a href="__IMGURL__{$row_->img}" target="_blank">
                        <img src="__IMGURL__{$row_->img}" style="height:65px;max-width:175px;"  alt="没有">
                    </a>
				</div>
                <div class="col-xs-2" title="{$row_->address}">
                    {$row_->address}
                </div>
                <div class="col-xs-2">
                    {$row_->start_time}
                </div>
                <div class="col-xs-2">
                    {$row_->end_time}
                </div>
                <div class="col-xs-2">
                    {$row_->create_time}
                </div>
               <div class="col-xs-">
                   <?php if($row_->pnum>0){?>
                    <a href="{:url('index_attend')}?activity_id={$row_->id}"><button title="已报名（{$row_->pnum}）" class="btn btn-success btn-xs edit_" >已报</button></a>
                   <?php }?>
                    <a href="{:url('edit')}?id={$row_->id}"><button class="btn btn-success btn-xs edit_" >改</button></a>
                    <button class="btn btn-danger btn-xs del_cate" data-toggle="modal" data-target="#deleteSource" data-id="<?= $row_['id']?>" onclick="del_(this)">删</button>

				</div>

			</div>
			<?php }?>
			<?php }else{?>
				<div class="row">
					<div class="col-xs-12 ">
						<h3 class="" align="center" style="color:red;font-size:18px">结果不存在</h3>
					</div>
				</div>
			<?php }?>

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
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="gridSystemModalLabel">提示</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						确定删除数据吗？
					</div>
				</div>
				<div class="modal-footer">
					<form action="{:url('delete')}" method="post" >
						<input type="hidden" name="id" value="" id="del_id">
                        <input type="hidden" name="url" value="{$url}" >
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