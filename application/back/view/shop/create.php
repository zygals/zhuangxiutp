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
                                <input type="text" class="form-control input-sm duiqi" name='name' value="" id="" placeholder="">
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>经营类目：</label>
                            <div class="col-xs-8 ">
								<?php if($list_cate->isEmpty()){?>
									<a href="{:url('cate/')}">添加分类</a>
								<?php }?>
                                <?php foreach($list_cate as $row_){?>
                                <label ><input type="radio" name="cate_id" value="{$row_->id}">{$row_->name}&nbsp;&nbsp;</label>
<?php }?>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->经营品牌：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm " name='brand' value="" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>logo：</label>
                            <div class="col-xs-4 ">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd1" name="logo" placeholder=""><span style="color:red">尺寸要求（90*90），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>列表图：</label>
                            <div class="col-xs-4 ">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img" placeholder=""><span style="color:red">尺寸要求（270*270），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                            </div>

                        </div>

						<div class="form-group">
							<label for="sKnot" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->订金：</label>
							<div class="col-xs-8">
								<input type="text" class="form-control input-sm duiqi" name='deposit' value="" id="" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="sKnot" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->订金优惠：</label>
							<div class="col-xs-8">
								<input type="text" class="form-control input-sm duiqi" name='youhui' value="" id="" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="sKnot" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->全款：</label>
							<div class="col-xs-8">
								<input type="text" class="form-control input-sm duiqi" name='money_all' value="" id="" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="sKnot" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->全款优惠：</label>
							<div class="col-xs-8">
								<input type="text" class="form-control input-sm duiqi" name='youhui_all' value="" id="" placeholder="">
							</div>
						</div>
                      <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->商家信息：</label>

                        </div>
                        <div class="address_wrap" style="padding-left:80px;">

                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>--> 商家姓名：</label>
                                <div class="col-xs-8 ">
                                    <input type="text" class="form-control input-sm duiqi" name='truename' value="" id="" placeholder="">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->手机：</label>
                                <div class="col-xs-8 ">
                                    <input type="text" maxlength="11" class="form-control input-sm duiqi" name='phone' value="" id="" placeholder="">
                                </div>
                            </div>
							<div class="form-group ">
								<label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->座机：</label>
								<div class="col-xs-8 ">
									<textarea name="zuoji"  cols="25" rows="5"></textarea>
								</div>
							</div>
                            <div class="form-group">
                                <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>二维码：</label>
                                <div class="col-xs-4 ">
                                    <input type="file" title='' class="form-control  duiqi" id="sOrd1" name="qrcode" placeholder=""><span style="color:red">尺寸要求（180*180），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->城市：</label>
                                <div class="col-xs-8 ">
                                    <input type="text" class="form-control input-sm duiqi" name='city' value="" id="" placeholder="如：北京">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->地址：</label>
                                <div class="col-xs-8 ">
                                    <input type="text" class="form-control input-sm " name='addr' value="" id="" placeholder="">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label">简介：</label>
                                <div class="col-xs-8 ">
                                    <textarea name="info" id="desc_textarea" style="width:700px;height:300px;"></textarea>
                                </div>
                            </div>

                       <!-- <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>详情页图：</label>
                            <div class="col-xs-4 ">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd2" name="img_big" placeholder=""><span style="color:red">尺寸要求（750*300），大小不超过<?php /*echo floor(config('upload_size')/1024/1024);*/?>M。</span>
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
    $('#more_addr').click(function () {
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
                },*/
                img: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }
                    }
                },
                logo: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }
                    }
                },
               /* "name_[]": {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }
                    }
                },

                "truename_[]": {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }
                    }
                },
                "mobile_[]": {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        }
                    }
                },
                "address_[]": {
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
