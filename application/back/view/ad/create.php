{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
</style>

	<!--弹出添加用户窗口--><form class="form-horizontal" action="{:url($act)}" method="post" enctype="multipart/form-data" >
		<div class="row" >
			<div class="col-xs-8">
				<div class="text-center">
					<!---->
					<h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
				</div>
				<div class="">
					<div class="container-fluid">

							<div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label">名称：</label>
								<div class="col-xs-8 ">
									<input type="text" class="form-control input-sm duiqi" name='name' value="" id="" placeholder="">
								</div>
							</div>

                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>广告图：</label>
                            <div class="col-xs-4 ">
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img" placeholder=""><span style="color:red">尺寸要求（750*400），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                            </div>

                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>链接方向：</label>
                            <div class="col-xs-8 ">
                                <label><input class="url_to" type="radio" name="url_to" checked value="1">活动详情</label>
                                <label ><input class="url_to" type="radio" name ='url_to' value="2">商品详情</label>
                                <label ><input class="url_to" type="radio" name ='url_to' value="3">店铺详情</label>
                                <label ><input class="url_to" type="radio" name ='url_to' value="4">店铺列表</label>
                                <label ><input class="url_to" type="radio" name ='url_to' value="5">线上拼团</label>
                                <label ><input class="url_to" type="radio" name ='url_to' value="6">公益验房</label>
                                <label ><input class="url_to" type="radio" name ='url_to' value="0">无</label>
                            </div>
                        </div>
                        <div class="form-group " id="url_id_div" style="display: block;">
                            <label for="sName" class="col-xs-3 control-label"><span id="url_desc">编号</span>：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='url' value="" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label">排序：</label>
                            <div class="col-xs-8 ">
                                <input type="number" class="form-control input-sm duiqi" name='sort' value="0" id="" placeholder="">
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
$('.url_to').click(function () {
    if(this.value==0 || this.value==4 || this.value==6){
        $('#url_id_div').hide();
    }else{
        $('#url_id_div').show();
    }
})
/*    $(function () {
        $('form').bootstrapValidator({
                img: {
                    validators: {
                        notEmpty: {
                            message: '请添加广告图'
                        }
                    }
                }

            }
        });

    });*/

</script>

{/block}
