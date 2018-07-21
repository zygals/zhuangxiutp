{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
    .form-group .action-type{
        margin-top: 5px;
    }

</style>
<script>
    function  changeCate(obj){
        var cate_name= $(obj).children('option:selected').attr('data_cate_name');
        $('#cate_name_label').html(cate_name);
    }
</script>
<!--弹出添加用户窗口-->
<form id="addForm" class="form-horizontal" action="{:url($act)}" method="post" enctype="multipart/form-data" >
    <div class="row" >
        <div class="col-xs-8">
            <div class="text-center">
                <!---->
                <h4 class="modal-title" id="gridSystemModalLabel">{$title}</h4>
            </div>
            <div class="">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>选择商家：</label>
                        <div class="col-xs-8">
                            {$row_['shop_name']}
                            <input type="hidden" name="id" value="{$row_['id']}">
                            <input type="hidden" name="referer" value="{$referer}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>选择商品：</label>
                            {$row_['good_name']}
                    </div>


                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>原价：</label>
                        <div class="col-xs-8 ">
                            <label id="price">{$row_['good_price']}</label>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>现价：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='price_group' value="{$row_['price_group']}" id="" placeholder="0.00元">
                        </div>
                    </div>

                    <!--<div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>结束时间：</label>
                        <?php /*if($row_->end_time != 0){ */?>
                            <div class="col-xs-8 ">
                                <input type="date" class="form-control input-sm duiqi" name='end_time' value="<?php /*echo date('Y-m-d',$row_->end_time)*/?>" id="" placeholder="">
                            </div>
                        <?php /*}else{ */?>
                            <div class="col-xs-8 ">
                                <input type="date" class="form-control input-sm duiqi" name='end_time' value="" id="" placeholder="">
                            </div>
                        <?php /*} */?>
                    </div>-->


<!--                    <div class="form-group">-->
<!--                        <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>活动类型：</label>-->
<!--                        <div class="col-xs-4 action-type">-->
<!--                            <label><input type="radio"  class="check_a"  name="type" value="1"  --><?php //echo $row_->type == '限人' ?'checked':''; ?><!-- >限人</label>　　-->
<!--                            <label><input type="radio"  class="check_a"  name="type" value="2"  --><?php //echo $row_->type == '限量' ?'checked':''; ?><!-- >限量团购</label>-->
<!---->
<!--                        </div>-->
<!--                    </div>-->
                    <input type="hidden" name="type" value="1">

                    <div class="form-group" id="div-1" style="display:<?php  echo $row_->type == '限人' ?'block':'none'; ?>;">
                        <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>人数：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='pnum' value="{$row_['pnum']}" id="" placeholder="例如:100">　
                        </div>
                        <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>已参加：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='attend_pnum' value="{$row_['attend_pnum']}" id="" placeholder="人数">　
                        </div>
                        <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>定金：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='deposit' value="{$row_['deposit']}" id="" placeholder="0.00元">　
                        </div>
                    </div>
                    <?php if($row_->st=='下架'){?>
                        <div class="form-group">
                            <label for="situation" class="col-xs-3 control-label">状态：</label>
                            <div class="col-xs-8">
                                <label class="control-label" >
                                    <input type="radio" name="st" id="" value="1" <?php echo $row_->st=='正在进行'?'checked':''?>>正常</label> &nbsp;
                                <label class="control-label">
                                    <input type="radio" name="st" id="" value="2" <?php echo $row_->st=='下架'?'checked':''?>> 下架</label>
                            </div>
                        </div>
                    <?php }?>
                   <!-- <div class="form-group" id="div-2" style="display:<?php /* echo $row_->type == '限量' ?'block':'none'; */?>;" >
                        <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>数量：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='store' value="{$row_['store']}" id="" placeholder="例如:100">　
                        </div>
                    </div>-->



                </div>
                <div class="text-center">
                    <a href="javascript:history.back()">
                        <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回</button>
                    </a>
                    <button type="submit" class="btn btn-xs btn-green">提交修改</button>
                </div>
            </div>
        </div>
</form>

<script>
    $(function () {

        $('#select_shop').change(function(){
            $.ajax({
                url:'{:url("ajax")}',
                type:'post',
                data : {'shop_id':$(this).val()},
                success:function(data){
                    var a  = '<option>--请选择--</option>';

                    $.each(data,function(n,res){
                        a += '<option id="goodPrice" data_price="'+res.price+'" value="'+res.id+'">'+res.id+':'+res.name+'</option>';
                    });
                    $('#foreachGood').html(a);
                }
            });
            $('#foreachGood').change(function(){
                var bprice = $('#goodPrice').attr('data_price')+'元';
                var bid = $('#goodPrice').attr('value');
                $('#no_good_id').val(bid);
                $('#price').html(bprice);
            });

        });
        $(".check_a").click(function(){
            var isType = $('.check_a:checked').val();
            console.log(isType);
            if(isType == 1){
                $("#div-2").hide();
                $('#div-1').show();
            }else{
                $("#div-2").show();
                $('#div-1').hide();
            }
        })
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
                price: {
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
                good_id: {
                    validators: {
                        notEmpty: {
                            message: '请选择'
                        }
                    }
                },
                price_group: {
                    validators: {
                        notEmpty: {
                            message: '请输入现价'
                        }
                    }
                },
                deposit: {
                    validators: {
                        notEmpty: {
                            message: '请输入定金'
                        }
                    }
                },
            }
        });

    });

</script>

{/block}
