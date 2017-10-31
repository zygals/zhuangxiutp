{extend name='layout:base' /}
{block name="title"}{$title}{/block}

{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
</style>
	<!--弹出添加用户窗口--><form class="form-horizontal" action="{:url($act)}" method="post" enctype="multipart/form-data" >
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
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>分类：</label>
                            <div class="col-xs-8">
                                <select class=" form-control select-duiqi" name="cate_id" id="sel_cate">
                                    <?php foreach ($list_cate_article as $row_c) { ?>
                                        <option value="{$row_c['id']}" <?php echo $row_c->id==$row_->cate_id?'selected':'' ?> >{$row_c['name']}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>标题：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='name' value="{$row_->name}" id="" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>缩略图：</label>
                            <div class="col-xs-4 ">
                                <img src="__IMGURL__{$row_->img}" alt="没有上传图片" width="188"/>
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img" placeholder=""><span style="color:red">尺寸要求（710*300），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。不上传表示不改</span>
                            </div>

                        </div>

                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>内容：</label>
                            <div class="col-xs-8 ">
                                <textarea name="cont" id="desc_textarea" style="width:700px;height:300px;">{$row_->cont}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="situation" class="col-xs-3 control-label">首页推荐：</label>
                            <div class="col-xs-8">
                                <label class="control-label" >
                                    <input type="radio" name="index_show" <?php echo $row_->index_show=='是'?'checked':''?> class="index_show yes" value="1" >是</label> &nbsp;
                                <label class="control-label">
                                    <input type="radio" name="index_show" class="index_show no" value="0" <?php echo $row_->index_show=='否'?'checked':''?> > 否</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="situation" class="col-xs-3 control-label">状态：</label>
                            <div class="col-xs-8">
                                <label class="control-label" >
                                    <input type="radio" name="st" id="" value="1" <?php echo $row_->st=='正常'?'checked':''?>>正常</label> &nbsp;
                                <label class="control-label">
                                    <input type="radio" name="st" id="" value="2" <?php echo $row_->st=='不显示'?'checked':''?>> 不显示</label>
                            </div>
                        </div>
                    </div>
				<div class="text-center">
                    <a href="javascript:history.back()"><button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回列表 </button></a>
					<button type="submit" class="btn btn-xs btn-green">保 存</button>
				</div>
			</div>
		</div>
</form>

<script>
    $('.index_show').click(function () {
        var index_img = document.getElementById('img_index');
        if($(this).hasClass('yes')){
            index_img.style.display='block';
        }else {
            index_img.style.display='none';
        }
    });
    $(function () {
        $('form').bootstrapValidator({
            fields: {
                name: {
                    validators:
                        {
                            notEmpty: {
                                message: '名称不能为空'
                            }
                        }

                },
                desc: {
                    validators:
                        {
                            notEmpty: {
                                message: '不能为空'
                            }
                        }

                },

                cate_id: {
                    validators: {
                        notEmpty: {
                            message: '请选择分类'
                        }


                    }
                },


            }
        });

    });
</script>

{/block}
