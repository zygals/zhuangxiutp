{extend name='layout:base' /}
{block name="title"}{$title}{/block}
{block name="content"}
<style>
    .control-label{
        padding-right:10px;
    }
    .from-me{
        text-align: right;
    }
</style>
<div class="row">
    <div class="col-xs-10">
<?php foreach($list_ as $k=>$msg){?>
        <p class="<?php echo $msg->type=='1'?'from-user':'from-me';?>">
            <?php if($msg->type==1){?>{$msg->user_id}:{$msg->username} ({$msg->nickname})<?php }else{?>{$msg->shop_id}:{$msg->shop_name}<?php }?>：{$msg->message} [{$msg->create_time}]
        </p>
        <?php }?>
          </div>
    <div class="huifu">
        <form method="post" action="{:url('save')}" id="searchForm">
            <div class="col-xs-6">
<input type="hidden" name="shop_id" value="{$list_[0]->shop_id}">
<input type="hidden" name="user_id" value="{$list_[0]->user_id}">
<input type="hidden" name="url" value="{$url}">
                <input type="text" name="message"  class="form-control input-sm">

            <div class="col-xs-">
            <button class="btn btn-white btn-xs " type="submit">提交</button>
            </div>
        </form>
    </div>
</div>
<div>
    {$page_str}
</div>
<script>

</script>
{/block}