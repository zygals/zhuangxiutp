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
                            <?php if($isShopAdmin){?>
                                <div class="col-xs-8">
                                    <label>
                                        <?php foreach ($list_shop as $row_) {
                                            if($row_['id']==session('admin_zhx')->shop_id){
                                                echo $row_['name'];
                                        ?>
                                            <input type="hidden" name="shop_id" value="{$row_['id']}">
                                        <?php }}?>
                                    </label>
                                </div>
                            <?php }else{?>
                                <div class="col-xs-8">
                                    <select onchange="changeCate(this)" class=" form-control select-duiqi" name="shop_id" id="">
                                        <?php foreach ($list_shop as $row_) { ?>
                                            <option data_cate_name="{$row_->cate_name}" value="{$row_['id']}" >{$row_['id']}:{$row_['name']}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>


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
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>计量单位：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='unit' value="" id="" placeholder="如:瓶、平方米">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>列表图：</label>
                            <div class="col-xs-4 ">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img" placeholder=""><span style="color:red">尺寸要求（270*270），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>详情页图：</label>
                            <div class="col-xs-4 ">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img_big" placeholder=""><span style="color:red">尺寸要求（750*750），大小不超过<?php /*echo floor(config('upload_size')/1024/1024);*/?>M。</span>
                            </div>

                        </div>-->
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>描述类型：</label>
                            <div class="col-xs-8 ">
                                <label><input class="which_info" type="radio" name="which_info" checked value="1">文字</label>
                                <label ><input class="which_info" type="radio" name ='which_info' value="2">图片</label>
                            </div>
                        </div>
                        <div class="form-group " id="desc_text">
                            <label for="sName" class="col-xs-3 control-label">描述：</label>
                            <div class="col-xs-8 ">
                                <textarea name="desc" id="desc_textarea" style="width:700px;height:300px;"></textarea>
                            </div>
                        </div>
                        <div class="form-group" style="display:none;" id="imgs_div">
                            <label for="sOrd" class="col-xs-3 control-label">长图：</label>
                            <div class="col-xs-4 ">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="imgs" placeholder=""><span style="color:red">尺寸要求（750*），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                            </div>

                        </div>


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
    $('.which_info').click(function () {
//        alert()
if(this.value==1){
$('#desc_text').show();
$('#imgs_div').hide();
}else{
    $('#desc_text').hide();
    $('#imgs_div').show();
}
    });
      $(function () {

        $('form').bootstrapValidator({/*
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
                unit: {
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
        }*/);

    });

</script>

{/block}
