{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
</style>
<script>
  function  changeCate(obj){
     var cate_name= $(obj).children('option:selected').attr('data_cate_name');
$('#cate_name_label').html(cate_name);
    }
</script>
	<!--弹出添加用户窗口-->
<form id="addForm" class="form-horizontal" action="{:url($act)}" method="post" enctype="multipart/form-data" >
		<div class="row" >
			<div class="col-xs-8">
				<div class="text-center">
					<!---->
					<h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
				</div>
				<div class="">
					<div class="container-fluid">
                        <div class="form-group">
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>商户：</label>
                            <div class="col-xs-8">
                                <select onchange="changeCate(this)" class=" form-control select-duiqi" name="shop_id" id="">
                                    <?php foreach ($list_shop as $row_) { ?>
                                        <option data_cate_name="{$row_->cate_name}" value="{$row_['id']}" >{$row_['name']}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>分类：</label>
                            <div class="col-xs-8">
                                <label id="cate_name_label"><?php echo $list_shop[0]->cate_name?></label>
                            </div>
                        </div>
							<div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>名称：</label>
								<div class="col-xs-8 ">
									<input type="text" class="form-control input-sm" name='name' value="" id="" placeholder="">
								</div>
							</div>

                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>价格：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='price' value="" id="" placeholder="0.00元">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>列表图：</label>
                            <div class="col-xs-4 ">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img" placeholder=""><span style="color:red">尺寸要求（100*100），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>详情页图：</label>
                            <div class="col-xs-4 ">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img_big" placeholder=""><span style="color:red">尺寸要求（750*300），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                            </div>

                        </div>

                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>描述：</label>
                            <div class="col-xs-8 ">
                                <textarea name="desc" id="desc_textarea" style="width:700px;height:300px;"></textarea>
                            </div>
                        </div>

                       <!-- <div class="form-group">
                            <label for="situation" class="col-xs-3 control-label">首页推荐：</label>
                            <div class="col-xs-8">
                                    <label class="control-label" >
                                        <input type="radio" name="index_show" class="index_show yes" value="1" >是</label> &nbsp;
                                    <label class="control-label">
                                        <input type="radio" name="index_show" class="index_show no" value="0" checked> 否</label>
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
                name: {
                    validators:
                        {
                            notEmpty: {
                                message: '名称不能为空'
                            }
                        }

                },
                price: {
                    validators:
                        {
                            notEmpty: {
                                message: '不能为空'
                            }
                        }

                },


                shop_id: {
                    validators: {
                        notEmpty: {
                            message: '请选择'
                        }


                    }
                },

                img: {
                    validators: {
                        notEmpty: {
                            message: '请添加缩略图'
                        }
                    }
                },
                img_big: {
                    validators: {
                        notEmpty: {
                            message: '请添加详情页图'
                        }
                    }
                },

            }
        });

    });

</script>

{/block}
