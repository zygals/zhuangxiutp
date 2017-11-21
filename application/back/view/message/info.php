{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label {
        padding-right: 10px;
    }
    .from-user {

    }
    .from-me {
        text-align: right;
    }
    .msgs_div{

    }
    .msglist{

    }  .huifu{

    }  .pagediv{
        display: flex;
        justify-content: flex-end;
    }
    .msgs_div {
        width: 70%;
        margin: 50px auto;
    }
</style>
<div class="msgs_div">
    <div class="row msglist">
        <?php foreach ($list_ as $k => $msg) { ?>
            <p class="<?php echo $msg->type == '1' ? 'from-user ' : 'from-me'; ?>">
                <?php if ($msg->type == 1) { ?>{$msg->user_id}:{$msg->username} ({$msg->nickname})<?php } else { ?>{$msg->shop_id}:{$msg->shop_name}<?php } ?>
                ：{$msg->message} 「{$msg->create_time}」
                <?php if($msg->type==2){?>
                <button onclick="delMsg('{$msg->id}')" class="delmsg btn btn-danger btn-xs">删除</button>
                <?php }?>
            </p>
        <?php } ?>
    </div>
    <div class="huifu row">
        <form method="post" action="{:url('save')}" id="searchForm">
            <div class="col-xs-8">
                <input type="hidden" name="shop_id" value="{$list_[0]->shop_id}">
                <input type="hidden" name="user_id" value="{$list_[0]->user_id}">
                <input type="hidden" name="url" value="{$url}">
                <input type="text" name="message" class="form-control input-sm">
            </div>
            <div class="col-xs-4">
                <button class="btn btn-white btn-xs " type="submit">提交</button><a href="{:url('index')}"><button type="button" class="btn btn-xs btn-white" data-dismiss="modal">返回列表 </button></a>
            </div>
        </form>
    </div>
    <div class="pagediv">
        {$page_str}
    </div>
    <script>
function delMsg($msg_id) {
    if(confirm('确定删除么？')){
        $.ajax({
            url:"{:url('delete')}",
            data:{
                id:$msg_id,
             },
            success:function (res) {
                if(res.code==0){
                    window.location.reload()
                }else {
                    alert(res.msg)
                }
            }
        })
    }
}
    </script>
    {/block}