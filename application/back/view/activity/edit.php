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
    <input type="hidden" name="id" value="{$row_->id}">
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
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>类型：</label>
                        <div class="col-xs-8 ">
                            <label class="control-label">
                                <input type="radio" name="type" id="" class="type_radio" value="1" <?php echo $row_->type==1?'checked':''?>>在线</label>
                            &nbsp;
                            <label class="control-label">
                                <input type="radio" name="type" id="" class="type_radio" <?php echo $row_->type==2?'checked':''?> value="2">验房</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sName" class="col-xs-3 control-label">名称：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='name' value="{$row_->name}"
                                   id="" placeholder="">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label">活动开始：</label>
                        <div class="col-xs-8 ">
                            <input type="date" class="form-control input-sm duiqi" name='start_time'
                                   value="<?= date('Y-m-d', $row_->start_time) ?>" id="" placeholder="">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label">活动结束：</label>
                        <div class="col-xs-8 ">
                            <input type="date" class="form-control input-sm duiqi" name='end_time'
                                   value="<?= date('Y-m-d', $row_->end_time) ?>" id="" placeholder="">
                        </div>
                    </div>
                    <div id="zaixian" style="display:<?php echo $row_->type==1?'block':'none';?>">
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label">活动地址：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm" name='address' value="{$row_->address}"
                                       id="" placeholder="">
                            </div>
                        </div>


                    </div>
                    <div class="form-group">
                        <label for="sOrd" class="col-xs-3 control-label"><span
                                    style="color:red;">*&nbsp;&nbsp;</span>列表图:</label>
                        <div class="col-xs-4 ">
                            <img src="__IMGURL__{$row_->img}" alt="没有上传图片" width="188"/>
                            <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img"
                                   placeholder=""><span
                                    style="color:red">尺寸要求（100*150），大小不超过<?php echo floor(config('upload_size') / 1024 / 1024); ?>
                                M。不上传表示不改</span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>详情大图:</label>
                        <div class="col-xs-4 ">
                            <img src="__IMGURL__{$row_->img_big}" alt="没有上传图片" width="188"/>
                            <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img_big"
                                   placeholder=""><span
                                    style="color:red">尺寸要求（750*400），大小不超过<?php echo floor(config('upload_size') / 1024 / 1024); ?>
                                M。不上传表示不改</span>
                        </div>

                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label">摘要：</label>
                        <div class="col-xs-8 ">
                            <textarea name="charm" id="" cols="50" rows="6">{$row_->charm}</textarea>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label">活动内容：</label>
                        <div class="col-xs-8 ">
                            <textarea name="info" id="" cols="50" rows="15">{$row_->info}</textarea>
                        </div>
                    </div>.
                    <div class="form-group">
                        <label for="sOrd" class="col-xs-3 control-label"><!--<span style="color:red;">*&nbsp;&nbsp;</span>-->内容长图：</label>
                        <div class="col-xs-4 ">
                            <img src="__IMGURL__{$row_->imgs}" alt="没有上传图片" width="188"/>
                            <input type="file" title='' class="form-control  duiqi" id="sOrd" name="imgs" placeholder=""><span style="color:red">尺寸要求（750*x），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。</span>
                        </div>

                    </div>
                    <div class="form-group " style="display:<?php /* echo $row_->type==2?'block':'none';*/?>">
                        <label for="sName" class="col-xs-3 control-label">已参加人数：</label>
                        <div class="col-xs-8 ">
                            <input type="number" class="form-control input-sm duiqi" name='attend_num' value="{$row_->attend_num}" id="" placeholder="">
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
    $('.type_radio').click(function () {
        if($(this).val()==1){
            $('#zaixian').show()
           // $('#yicanji').hide()
        }else{
            $('#zaixian').hide()
           // $('#yicanji').show()
        }
    })

</script>

{/block}
