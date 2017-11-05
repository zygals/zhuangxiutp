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
<form class="form-horizontal" action="{:url($act)}" method="post" enctype="multipart/form-data" >
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
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>商户：</label>
                            <div class="col-xs-8">

                                <label  id="cate_name_label">
                                    <?php foreach ($list_shop as $row_s) { ?>
                                        <?php echo $row_s->id==$row_->shop_id ?$row_s->name:'' ;?>
                                    <?php } ?>
                                    <input type="hidden" name="shop_id" value="{$row_['shop_id']}">

                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>分类：</label>
                            <div class="col-xs-8">
                                <label  id="cate_name_label">
                                    <?php foreach ($list_shop as $row_s) { ?>
                                        <?php echo $row_s->id==$row_->shop_id ?$row_s->cate_name:'' ;?>
                                    <?php } ?>
                                </label>

                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>名称：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm " name='name' value="{$row_->name}" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="situation" class="col-xs-3 control-label">置顶：</label>
                            <div class="col-xs-8">
                                <label class="control-label" >
                                    <input type="radio" name="to_top" id="" value="1" <?php echo $row_->to_top=='是'?'checked':''?>>是</label> &nbsp;
                                <label class="control-label">
                                    <input type="radio" name="to_top" id="" value="0" <?php echo $row_->to_top=='否'?'checked':''?>> 否</label>
                            </div>
                        </div>
                       <?php if($row_->st=='下架'){?>
                        <div class="form-group">
                            <label for="situation" class="col-xs-3 control-label">状态：</label>
                            <div class="col-xs-8">
                                <label class="control-label" >
                                    <input type="radio" name="st" id="" value="1" <?php echo $row_->st=='正常'?'checked':''?>>正常</label> &nbsp;
                                <label class="control-label">
                                    <input type="radio" name="st" id="" value="2" <?php echo $row_->st=='下架'?'checked':''?>> 下架</label>
                            </div>
                        </div>
                        <?php }?>

                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>价格：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='price' value="{$row_->price}" id="" placeholder="">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>计量单位：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='unit' value="{$row_->unit}" id="" placeholder="">
                            </div>
                        </div>
                       <!-- <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>库存：</label>
                            <div class="col-xs-8 ">
                                <input type="number" class="form-control input-sm duiqi" name='store' value="{$row_->store}" id="" placeholder="">
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>列表图：</label>
                            <div class="col-xs-4 ">
                                <img src="__IMGURL__{$row_->img}" alt="没有上传图片" width="88"/>
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img" placeholder=""><span style="color:red">尺寸要求（270*270），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。不选择表示不修改。</span>
                            </div>

                        </div>
                        <!--<div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>详情页图：</label>
                            <div class="col-xs-4 ">
                                <img src="__IMGURL__{$row_->img_big}" alt="没有上传图片" width="188"/>
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img_big" placeholder=""><span style="color:red">尺寸要求（750*750），大小不超过<?php /*echo floor(config('upload_size')/1024/1024);*/?>M。不选择表示不修改。</span>
                            </div>

                        </div>-->
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>描述类型：</label>
                            <div class="col-xs-8 ">
                                <label><input class="which_info" type="radio" name="which_info" <?=  $row_->which_info==1?'checked':'';?> value="1">文字</label>
                                <label ><input class="which_info" type="radio" name ='which_info' value="2" <?=  $row_->which_info==2?'checked':'';?>>图片</label>
                            </div>
                        </div>
                        <div class="form-group " style="display: <?=  $row_->which_info==1?'block':'none';?>;" id="desc_text">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>描述：</label>
                            <div class="col-xs-8 ">
                                <textarea name="desc" id="desc_textarea" style="width:700px;height:300px;">{$row_->desc}</textarea>
                            </div>
                        </div>
                        <div class="form-group" style="display:<?=  $row_->which_info==2?'block':'none';?>" id="imgs_div">
                            <label for="sOrd" class="col-xs-3 control-label">长图：</label>
                            <div class="col-xs-4 ">
                                <img src="__IMGURL__{$row_->imgs}" alt="没有上传图片" width="188"/>
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="imgs" placeholder=""><span style="color:red">尺寸要求（750*），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
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
        $('form').bootstrapValidator(/*{
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




            }
        }*/);

    });
</script>

{/block}
