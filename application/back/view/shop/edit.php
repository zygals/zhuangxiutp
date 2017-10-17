{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
</style>
	<!--弹出添加用户窗口-->
<form id="addForm" class="form-horizontal" action="{:url($act)}" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="id" value="{$row_->id}">
    <input type="hidden" name="referer" value="{$referer}">
		<div class="row" >
			<div class="col-xs-8">
				<div class="text-center">
					<h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
				</div>
				<div class="">
					<div class="container-fluid">
                        <div class="form-group">
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>商户名称：</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control input-sm duiqi" name='name' value="{$row_->name}" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span> 商家姓名：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='truename' value="{$row_->truename}" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>手机：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='phone' value="{$row_->phone}" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>地址：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='addr' value="{$row_->addr}" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>经营类目：</label>
                            <div class="col-xs-8 ">
                                <?php foreach($list_cate as $row_c){?>
                                <label ><input type="radio" <?php echo $row_c->id==$row_->cate_id?'checked':'';?> name="cate_id" value="{$row_c->id}">{$row_c->name}&nbsp;&nbsp;</label>
<?php }?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>列表图：</label>
                            <div class="col-xs-4 ">
                                <img src="__IMGURL__{$row_->img}" alt="" width="100">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img" placeholder=""><span style="color:red">尺寸要求（100*100），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>详情页图：</label>
                            <div class="col-xs-4 ">
                                <img src="__IMGURL__{$row_->img_big}" alt="" width="300">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img_big" placeholder=""><span style="color:red">尺寸要求（750*300），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                            </div>

                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>详细说明：</label>
                            <div class="col-xs-8 ">
                                <textarea name="info" id="desc_textarea" style="width:700px;height:300px;">{$row_->info}</textarea>
                            </div>
                        </div>
                       <!-- <div class="form-group" id="diliver_fee_wrap" style="">
                            <label for="situation" class="col-xs-3 control-label">排序：</label>
                            <div class="col-xs-8">
                                <label class="control-label">
                                    <input type="number" name="sort" class="form-control input-sm duiqi" id=""
                                           value="10000"></label> &nbsp;

                            </div>
                        </div>-->
                    </div>
				<div class="text-center">
                    <a href="javascript:history.back()">
                        <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回</button>
                    </a>
					<button type="submit" class="btn btn-xs btn-green">保 存</button>
				</div>
			</div>
		</div>
</form>

<script>
      $(function () {

        $('form').bootstrapValidator({
            fields: {
                title: {
                    validators:
                        {
                            notEmpty: {
                                message: '名称不能为空'
                            }
                        }

                },
                lishu: {
                    validators:
                        {
                            notEmpty: {
                                message: '不能为空'
                            }
                        }

                },

                city: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }


                    }
                },



            }
        });

    });

</script>

{/block}
