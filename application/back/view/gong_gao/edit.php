{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
</style>

        <form class="form-horizontal" action="/zhuangxiutp/public/back/gong_gao/save.html" method="post" enctype="multipart/form-data" >
		<div class="row" >
			<div class="col-xs-8">
				<div class="text-center">
					<!---->
					<h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
				</div>
				<div class="">
					<div class="container-fluid">

							<div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label">公告内容：</label>
								<div class="col-xs-8 ">
									<input type="text" class="form-control input-sm duiqi" value="{$item.content}" name="content">
                                    <input type="hidden" value="{$item.id}" name="id">
								</div>
							</div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label">排序：</label>
                            <div class="col-xs-8 ">
                                <input type="number" class="form-control input-sm duiqi" value="{$item.sort}" name="sort"><span style="color:red">排序越小越在前面</span>
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