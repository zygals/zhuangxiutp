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
					<div class="container-fluid" id="fields_div">
                        <div class="form-group">
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>商户名称：</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control input-sm duiqi" name='name' value="{$row_->name}" id="" placeholder="">
                            </div>
                        </div>
                        <?php if($row_->st=='关'){?>
                            <div class="form-group">
                                <label for="situation" class="col-xs-3 control-label">状态：</label>
                                <div class="col-xs-8">
                                    <label class="control-label" >
                                        <input type="radio" name="st" id="" value="1" <?php echo $row_->st=='正常'?'checked':''?>>正常</label> &nbsp;
                                    <label class="control-label">
                                        <input type="radio" name="st" id="" value="0" <?php echo $row_->st=='关'?'checked':''?>> 关</label>
                                </div>
                            </div>
                        <?php }?>


                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label">排序：</label>
                            <div class="col-xs-8 ">
                                <input type="number" class="form-control input-sm duiqi" name='sort' value="{$row_->sort}" id="" placeholder=""><span class="tip">小的在前</span>
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
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->经营品牌：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm " name='brand' value="{$row_->brand}" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>列表图：</label>
                            <div class="col-xs-4 ">
                                <img src="__IMGURL__{$row_->img}" alt="" width="130">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img" placeholder=""><span style="color:red">尺寸要求（270*270），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>logo：</label>
                            <div class="col-xs-4 ">
                                <img src="__IMGURL__{$row_->logo}" alt="" width="60">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="logo" placeholder=""><span style="color:red">尺寸要求（90*90），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="sKnot" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->订金：</label>
							<div class="col-xs-8">
								<input type="text" class="form-control input-sm duiqi" name='deposit' value="{$row_->deposit}" id="" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="sKnot" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->订金优惠：</label>
							<div class="col-xs-8">
								<input type="text" class="form-control input-sm duiqi" name='youhui' value="{$row_->youhui}" id="" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="sKnot" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->全款：</label>
							<div class="col-xs-8">
								<input type="text" class="form-control input-sm duiqi" name='money_all' value="{$row_->money_all}" id="" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="sKnot" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->全款优惠：</label>
							<div class="col-xs-8">
								<input type="text" class="form-control input-sm duiqi" name='youhui_all' value="{$row_->youhui_all}" id="" placeholder="">
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
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->商家信息：</label>
                        </div>
                        <div class="address_wrap" style="padding-left:80px;">

                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>--> 商家姓名：</label>
                                <div class="col-xs-8 ">
                                    <input type="text" class="form-control input-sm duiqi" name='truename' value="{$row_->truename}" id="" placeholder="">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->手机：</label>
                                <div class="col-xs-8 ">
                                    <input type="number" class="form-control input-sm duiqi" name='phone' value="{$row_->phone}" id="" placeholder="">
                                </div>
                            </div>
							<div class="form-group ">
								<label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->座机：</label>
								<div class="col-xs-8 ">
									<textarea name="zuoji"  cols="25" rows="5">{$row_->zuoji}</textarea>
								</div>
							</div>
                            <div class="form-group">
                                <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>二维码：</label>
                                <div class="col-xs-4 ">
                                    <img src="__IMGURL__{$row_->qrcode}" alt="" width="60">
                                    <input type="file" title='' class="form-control  duiqi" id="sOrd" name="qrcode" placeholder=""><span style="color:red">尺寸要求（180*180），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->城市：</label>
                                <div class="col-xs-8 ">
                                    <input type="text" class="form-control input-sm duiqi" name='city' value="{$row_->city}" id="" placeholder="如：北京">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->地址：</label>
                                <div class="col-xs-8 ">
                                    <input type="text" class="form-control input-sm duiqi" name='addr' value="{$row_->addr}" id="" placeholder="">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label">简介：</label>
                                <div class="col-xs-8 ">
                                    <textarea name="info" id="desc_textarea" style="width:700px;height:300px;">{$row_->info}</textarea>
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
    $('#more_addr').click(function () {
       // alert()
        var str = $('.address_wrap').last().clone();
        $('#fields_div').append(str);
    });
    $('#minus_addr').click(function () {
        if( $('.address_wrap').length==1){
            return;
        }
        $('.address_wrap').last().remove();
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
              /*  truename: {
                    validators:
                        {
                            notEmpty: {
                                message: '不能为空'
                            }
                        }

                },
                phone: {
                    validators:
                        {
                            notEmpty: {
                                message: '不能为空'
                            }
                        }

                },*/
                cate_id: {
                    validators:
                        {
                            notEmpty: {
                                message: '不能为空'
                            }
                        }

                },
               /* city: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }


                    }
                },
                addr: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }


                    }
                },
*/

            }
        });

    });

</script>

{/block}
