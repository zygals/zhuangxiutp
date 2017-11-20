{extend name='layout:base' /}
{block name="title"}资讯列表{/block}
{block name="content"}
<style>
    .pagination li.disabled>a, .pagination li.disabled>span{color:inherit;}
    .pagination li>a, .pagination li>span{color:inherit}
    .big-container{
        width: 1000px;
        height: 800px;
        margin-top: 50px;
        margin-left: 300px;
    }

    .reply-info{
        display: none;
        width:300px;
        margin: 0 auto;
    }
</style>

    <div class="big-container">
        <?php foreach($list as $value){?>
        <?php if($value->type=='1'){?>
            <div class="user_left">
                <div class="user-name">
                    买家名:{$value->nickname}  　　　时间:{$value->create_time}
                </div>
                <div class="msg">
                    　{$value->message}
                </div>
                <div>
<!--                    <button onclick="modalShow('{:url(\'reply\')}','{$value->id}')" >回复</button>-->
                    <a data-id="{$value->id}" class="reply"><button>回复</button></a>
                </div>
            </div>
            <?php }else{ ?>
                <div class="user_left">
                    <div class="user-name">
                        店铺名:{$value->name}  　　　时间:{$value->create_time}
                    </div>
                    <div class="msg">
                        　{$value->message}
                    </div>
                </div>
            <?php }?>
        <?php }?>
    </div>
<div class="reply-info">
    <form action="{:url('reply')}" method="post">
    <input type="hidden" name="pid" value="">
    <input type="hidden" name="user_id" value="{$value->user_id}">
    <input type="hidden" name="shop_id" value="{$value->shop_id}">
    <input type="hidden" name="type" value="2">
    <input type="text" name="message" value="">
    <input type="submit" value="提交回复">
    </form>
</div>
<script>
    function del_(obj) {
        var id = $(obj).attr('data-id');
        $('#del_id').val(id);
    }
    $('.reply').click(function(){
        $('.reply-info').toggle();
        $("input[name='pid']").val($(this).attr('data-id'))
    })
</script>

{/block}