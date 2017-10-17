{extend name='layout:base' /}
{block name="title"}{$title}{/block}

{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
</style>
<script src="__EDITOR__/kindeditor.js"></script>
<script src="__EDITOR__/lang/zh_CN.js"></script>
<script>
    KindEditor.ready(function (K) {
        // var editor = K.create('#desc_textarea');
      /*  var editor = K.create('textarea[name="desc"]',{
            themeType: 'simple',
            resizeType: 1,
            uploadJson: '__EDITOR__/php/upload_json.php',
            fileManagerJson: '__EDITOR__/php/file_manager_json.php',
            allowFileManager: true,
            //下面这行代码就是关键的所在，当失去焦点时执行 this.sync();
            afterBlur: function(){this.sync();}
        });*/

    });
    function getListCate(obj) {
        var type_id = obj.value;
        $.get('{:url("ajax/index")}',{type_id:type_id},function (data) {
            // console.log(data);
            var str = '';
            var data_cate = data.data;
            for(var i=0;i<data_cate.length;i++){
                str+='<option value="'+data_cate[i].id+'">'+data_cate[i].title+'</option>';
            }
            $('#sel_cate').html(str);
        });

    }
</script>
	<!--弹出添加用户窗口--><form class="form-horizontal" action="{:url($act)}" method="post" enctype="multipart/form-data" >
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
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>院校：</label>
                            <div class="col-xs-8">
                                <select class=" form-control select-duiqi" name="school_id" id="">
                                    <?php foreach ($list_school as $row_s) { ?>
                                        <option value="{$row_s['id']}" <?php echo $row_s->id==$row_->school_id?'selected':''?>>{$row_s['title']}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>类型：</label>
                            <div class="col-xs-8">
                                <select onchange="getListCate(this)" class=" form-control select-duiqi" name="type" id="">
                                    <?php foreach (\app\common\model\Cate::$type_cate as $row_type) { ?>
                                        <option value="{$row_type['type_id']}" <?php echo $row_type['title']==$row_->type?'selected':''?>>{$row_type['title']}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>分类：</label>
                            <div class="col-xs-8">
                                <select class=" form-control select-duiqi" name="cate_id" id="sel_cate">
<?php foreach($list_cate as $k=>$row_cate){?>
    <option value="{$row_cate->id}" <?php echo $row_->cate_id==$row_cate->id?'selected':''?>>{$row_cate->title}</option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>名称：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='title' value="{$row_->title}" id="" placeholder="">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>价格：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='price' value="{$row_->price}" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>库存：</label>
                            <div class="col-xs-8 ">
                                <input type="number" class="form-control input-sm duiqi" name='store' value="{$row_->store}" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>列表图：</label>
                            <div class="col-xs-4 ">
                                <img src="__IMGURL__{$row_->img}" alt="没有上传图片" width="88"/>
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img" placeholder=""><span style="color:red">尺寸要求（180*210），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。不选择表示不修改。</span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>详情页图：</label>
                            <div class="col-xs-4 ">
                                <img src="__IMGURL__{$row_->img_big}" alt="没有上传图片" width="188"/>
                                <input type="file" title='' class="form-control  duiqi" id="sOrd" name="img_big" placeholder=""><span style="color:red">尺寸要求（260*300），大小不超过<?php echo floor(config('upload_size')/1024/1024);?>M。不选择表示不修改。</span>
                            </div>

                        </div>

                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>资料描述：</label>
                            <div class="col-xs-8 ">
                                <textarea name="desc" id="desc_textarea" style="width:700px;height:300px;">{$row_->desc}</textarea>
                            </div>
                        </div>
                        <div class="form-group" id="diliver_fee_wrap" style=";">
                            <label for="situation" class="col-xs-3 control-label">排序：</label>
                            <div class="col-xs-8">
                                <label class="control-label">
                                    <input type="number" name="sort" class="form-control input-sm duiqi" id=""
                                           value="{$row_->sort}"></label> &nbsp;

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="situation" class="col-xs-3 control-label">首页推荐：</label>
                            <div class="col-xs-8">
                                <label class="control-label" >
                                    <input type="radio" name="index_show" class="index_show yes" value="1" <?php echo $row_->index_show=='是'?'checked':'';?> >是</label> &nbsp;
                                <label class="control-label">
                                    <input type="radio" name="index_show" class="index_show no" value="0" <?php echo $row_->index_show=='否'?'checked':'';?>> 否</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="situation" class="col-xs-3 control-label">状态：</label>
                            <div class="col-xs-8">
                                <label class="control-label" >
                                    <input type="radio" name="st" id="" value="1" <?php echo $row_->st=='正常'?'checked':''?>>正常</label> &nbsp;
                                <label class="control-label">
                                    <input type="radio" name="st" id="" value="2" <?php echo $row_->st=='不显示'?'checked':''?>> 不显示</label>
                            </div>
                        </div>
                        <?php if($row_->is_add_attr=1 && !empty($row_->good_attrs)){?>
                            <div class="form-group">
                                <label for="situation" class="col-xs-3 control-label">参数列表：</label>
                                <div class="col-xs-8">
                                    <ul>
                                        <?php foreach($row_->good_attrs as $k=>$row_good_attr){?>
                                            <li>{$row_good_attr->attr_name}：{$row_good_attr->value}</li>
                                        <?php }?>
                                    </ul>
                                </div>
                            </div>
                        <?php }?>

                    </div>
				<div class="text-center">
                    <a href="javascript:history.back()"><button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回列表 </button></a>
					<button type="submit" class="btn btn-xs btn-green">保 存</button>
				</div>
			</div>
		</div>
</form>

<script>
    $('.index_show').click(function () {
        var index_img = document.getElementById('img_index');
        if($(this).hasClass('yes')){
            index_img.style.display='block';
        }else {
            index_img.style.display='none';
        }
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
                desc: {
                    validators:
                        {
                            notEmpty: {
                                message: '不能为空'
                            }
                        }

                },

                cate_id: {
                    validators: {
                        notEmpty: {
                            message: '请选择分类'
                        }


                    }
                },


            }
        });

    });
</script>

{/block}
