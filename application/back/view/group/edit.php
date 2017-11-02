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
    #div-2{
        display: none;
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

                    <div class="form-group ">
                        <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>结束时间：</label>
                        <div class="col-xs-8 ">
                            <input type="date" class="form-control input-sm duiqi" name='end_time' value="<?php echo date('Y-m-d',$row_->end_time)?>" id="" placeholder="">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>活动类型：</label>
                        <div class="col-xs-4 action-type">
                            <label><input type="radio"  class="check_a"  name="type" value="1"  checked>限人团购</label>　　
                            <label><input type="radio"  class="check_a"  name="type" value="2" >限量团购</label>

                        </div>
                    </div>
                    <div class="form-group" id="div-1">
                        <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>人数：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='pnum' value="{$row_['pnum']}" id="" placeholder="例如:100">　
                        </div>
                        <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>定金：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='deposit' value="{$row_['deposit']}" id="" placeholder="0.00元">　
                        </div>

                    </div>
                    <div class="form-group" id="div-2" >
                        <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>数量：</label>
                        <div class="col-xs-8 ">
                            <input type="text" class="form-control input-sm duiqi" name='store' value="{$row_['store']}" id="" placeholder="例如:100">　
                        </div>
                    </div>



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

                img: {
                    validators: {
                        notEmpty: {
                            message: '请添加缩略图'
                        }
                    }
                },
                img_big: {
                    validators: {
                        notEmpty: {
                            message: '请添加详情页图'
                        }
                    }
                },

            }
        });

    });

</script>

{/block}
