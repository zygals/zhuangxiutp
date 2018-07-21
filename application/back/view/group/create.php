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
                                    <select  class=" form-control select-duiqi" name="shop_id" id="select_shop">
                                        <option value="">--请选择--</option>
                                        <?php foreach($shop as $row_s){  ?>
                                                <option value="{$row_s['id']}" id="shop_">
                                                    {$row_s['id']}.{$row_s['name']}
                                                </option>
                                        <?php }?>


                                    </select>
                                </div>
                        </div>

                        <div class="form-group">
                            <label for="sKnot" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>选择商品：</label>
                            <div class="col-xs-8">
                                <select onchange="changeCate(this)" class=" form-control select-duiqi" name="good_id" id="foreachGood">
                                    <option value="">--请选择--</option>
                                    <input type="hidden" name="good_id" value="" id="no_good_id">
                                </select>

                            </div>
                        </div>


							<div class="form-group ">
                                <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>原价：</label>
								<div class="col-xs-8 ">
                                    <label id="price"></label>
								</div>
							</div>

                        <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>现价：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='price_group' value="" id="" placeholder="0.00元">
                            </div>
                        </div>

                       <!-- <div class="form-group ">
                            <label for="sName" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>结束时间：</label>
                            <div class="col-xs-8 ">
                                <input type="date" class="form-control input-sm duiqi" name='end_time' value="" id="" placeholder="">
                            </div>
                        </div>-->


<!--                        <div class="form-group">-->
<!--                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>活动类型：</label>-->
<!--                            <div class="col-xs-4 action-type">-->
<!--                                <label><input type="radio"  class="check_a"  name="type" value="1"  checked>限人</label>　　-->
<!--                                <label><input type="radio"  class="check_a"  name="type" value="2" >限量团购</label>-->
<!--                            </div>-->
<!--                        </div>-->
                        <input type="hidden" name="type" value="1">
                        <div class="form-group" id="div-1">
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>人数：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='pnum' value="" id="" placeholder="例如:100">　
                            </div>
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>定金：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='deposit' value="" id="" placeholder="0.00元">　
                            </div>

                        </div>
                        <div class="form-group" id="div-2" >
                            <label for="sOrd" class="col-xs-3 control-label"><span style="color:red;">*&nbsp;&nbsp;</span>数量：</label>
                            <div class="col-xs-8 ">
                                <input type="text" class="form-control input-sm duiqi" name='store' value="" id="" placeholder="例如:100">　
                            </div>
                        </div>



                    </div>
				<div class="text-center">
                    <a href="javascript:history.back()">
                        <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回</button>
                    </a>
					<button type="submit" class="btn btn-xs btn-green">提交审核</button>
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
                        a += '<option  data_price="'+res.price+'" value="'+res.id+'">'+res.id+':'+res.name+'</option>';
                    });
                    $('#foreachGood').html(a);
                }
            });
        $('#foreachGood').change(function(){
            var bprice = $('#foreachGood option:selected').attr('data_price')+'元';

            var bid = $('#foreachGood option:selected').attr('value');
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
