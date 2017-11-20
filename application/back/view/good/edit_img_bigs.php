{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label {
        padding-right: 10px;
    }
</style>

<!--弹出添加用户窗口-->
<form class="form-horizontal" action="{:url($act)}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="good_id" value="{$good_id}">
    <input type="hidden" name="referer" value="{$referer}">
    <div class="row">
        <div class="col-xs-8">
            <div class="text-center">
                <!---->
                <h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
            </div>
            <div class="">
                <div class="container-fluid">

                    <div class="form-group ">

                    </div>

                    <div class="form-group">
                        <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>大图：</label>
                        <div class="col-xs-4" id="img_wrap_div">
<?php foreach ($list_img_big as  $row_){?>
                            <div class="img_wrap">
                                <img src="__IMGURL__{$row_['img_big']}" alt="没有上传图片" width="250"/>
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img_big[]"
                                       placeholder=""><span
                                        style="color:red">尺寸要求（750*750），大小不超过<?php echo floor(config('upload_size') / 1024 / 1024); ?>
                                    M。</span>
                            </div>
                            <?php }?>

                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a href="javascript:history.back()">
                        <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回</button>
                    </a>
                    <button type="submit" class="btn btn-xs btn-green">清空大图</button>
                </div>
            </div>
        </div>
</form>

<script>

    $('#addFile').click(function () {
        var obj = $('.img_wrap').last().clone();
        $('#img_wrap_div').append(obj);
        $('.img_wrap').last().find('img').attr('src','')

    });
    $('#jianFile').click(function () {
        if ($('.img_wrap').length == 1) {
            return;
        }
        $('.img_wrap').last().remove();
    });


</script>

{/block}
