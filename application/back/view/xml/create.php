{extend name='layout:base' /}
{block name="title"}测试xml{/block}
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
					<h4 class="modal-title" id="gridSystemModalLabel">{测试xml}</h4>
				</div>
				<div class="">
					<div class="container-fluid">

							<div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label">名称：</label>

                                <div class="col-xs-8 ">

                                    <textarea name="cont" id="" cols="30" rows="10"></textarea>
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
