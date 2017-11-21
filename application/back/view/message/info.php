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

    }
</style>
<div class="row msgs_div">
    <div class="col-xs-8 msglist">
        <?php foreach ($list_ as $k => $msg) { ?>
            <p class="<?php echo $msg->type == '1' ? 'from-user' : 'from-me'; ?>">
                <?php if ($msg->type == 1) { ?>{$msg->user_id}:{$msg->username} ({$msg->nickname})<?php } else { ?>{$msg->shop_id}:{$msg->shop_name}<?php } ?>
                ：{$msg->message} 「{$msg->create_time}」<button class="delmsg btn btn-danger btn-xs">删除</button>
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
                <button class="btn btn-white btn-xs " type="submit">提交</button>
            </div>
        </form>
    </div>
    <div class="pagediv">
        {$page_str}
    </div>
    <script>

    </script>
    {/block}