{extend name='layout:base' /}
{block name="title"}后台首页-登录记录{/block}

{block name="search"}{/block}
{block name="content"}
<style>
    .pagination li.disabled>a, .pagination li.disabled>span{color:inherit;}
    .pagination li>a, .pagination li>span{color:inherit}
</style>
<!-- 分类管理模块 -->
<div role="tabpanel" class="tab-pane active" id="sour">
    <div class="data-div">
        <div class="row tableHeader">
            <div class="col-xs-1 ">
                编码
            </div>
            <div class="col-xs-3">
                管理员名称
            </div>
            <div class="col-xs-3">
                登录ip
            </div>
            <div class="col-xs-1">
                登录次数
            </div>
            <div class=" col-xs-">
                登录时间
            </div>

        </div>
        <div class="tablebody">
            <?php foreach($list_ as $key=>$row_){?>
            <div class="row" >
                <div class="col-xs-1">
                    <?= $row_['id']?>
                </div>
                <div  class="col-xs-3">
                    <span><?= $row_['admin_name']?></span>
                </div>
                <div class="col-xs-3">
                    <?= $row_['ip']?>
                </div>
                <div class="col-xs-1">
                    <?= $row_['times']?>
                </div>
                <div class="col-xs-">
                    <?= $row_['create_time']?>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</div>
<!-- /.modal -->
<!--页码块-->
<footer class="footer">
    {$list_->render()}
</footer>

<script>


</script>
{/block}