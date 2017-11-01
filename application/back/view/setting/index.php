{extend name='layout:base' /}
{block name="title"}商品列表{/block}
{block name="content"}
<style>
    .pagination li.disabled > a, .pagination li.disabled > span {
        color: inherit;
    }

    .pagination li > a, .pagination li > span {
        color: inherit
    }
</style>
<script>
    function getGoodsByType() {
        $('#sel_cate_id').val('');
        $('#searchForm').submit();
    }
    ;
</script>
<div role="tabpanel" class="tab-pane" id="user" style="display:block;">
    <div class="data-div">
        　
    </div>
    <div class="data-div">
        <div class="row tableHeader">
            <div class="col-xs-2 ">
                商户申请最低提现金额
            </div>
            <div class="col-xs-1 ">
                平台联系人
            </div>
            <div class="col-xs-1">
                公司地址
            </div>
            <div class="col-xs-1">
                平台电话
            </div>
            <div class="col-xs-1">
                平台列表图片
            </div>
            <div class="col-xs-">
                操 作
            </div>
        </div>
    </div>
</div>
{/block}