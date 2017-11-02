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
    <input type="hidden" name="shop_id" value="{$shop_id}">
    <input type="hidden" name="referer" value="{$referer}">
		<div class="row" >
			<div class="col-xs-8">
				<div class="text-center">
					<h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
				</div>
				<div class="">
					<div class="container-fluid" id="fields_div">


                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>门店地址：</label>
<button type="button" id="more_addr">增加</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="minus_addr">减少</button>
                        </div>
                        <?php foreach($list_address as $row_){?>
                        <div class="address_wrap" style="padding-left:80px;">

                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><span
                                            style="color:red;">*&nbsp;&nbsp;</span>门店名称：</label>
                                <div class="col-xs-8 ">
<!--                                    <input type="hidden" name="id[]" value="{$row_->id}">-->
                                    <input type="text" class="form-control input-sm" name='name_[]' value="{$row_->name_}" id=""
                                           placeholder="">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><span
                                            style="color:red;">*&nbsp;&nbsp;</span>联系人姓名：</label>
                                <div class="col-xs-8 ">
                                    <input type="text" class="form-control input-sm duiqi" name='truename_[]' value="{$row_->truename_}"
                                           id="" placeholder="">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><span
                                            style="color:red;">*&nbsp;&nbsp;</span>手机：</label>
                                <div class="col-xs-8 ">
                                    <input type="number" class="form-control input-sm duiqi" name='mobile_[]' value="{$row_->mobile_}"
                                           id="" placeholder="">
                                </div>
                            </div>
							<div class="form-group ">
								<label for="sName" class="col-xs-3 control-label"><span
										style="color:red;">*&nbsp;&nbsp;</span>座机：</label>
								<div class="col-xs-8 ">
									<textarea name="zuoji[]"  cols="25" rows="5">{$row_->zuoji}</textarea>
								</div>
							</div>
                            <div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><span
                                            style="color:red;">*&nbsp;&nbsp;</span>详细地址：</label>
                                <div class="col-xs-8 ">
                                    <input type="text" class="form-control input-sm " name='address_[]' value="{$row_->address_}" id=""
                                           placeholder="">
                                </div>
                            </div>
                        </div>
                            <hr size="5" color="blue" />
                        <?php }?>



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

                "name_[]": {
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


            }
        });

    });

</script>

{/block}
