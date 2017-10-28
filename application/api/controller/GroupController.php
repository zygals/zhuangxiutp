<?php

    namespace app\api\controller;
    use app\api\controller\BaseController;
    use think\Request;
    use app\api\model\Tuangou;

    class GroupController extends BaseController{
        /**
         * 正在进行的团购活动
         */
        public function goon(){
            return json(['code'=>0,'msg'=>'group/goon','data'=>Tuangou::getGoon()]);
        }

        /**
         * 历史团购活动
         */
        public function history()
        {
            return json(['code'=>0,'msg'=>'group/history','data'=>Tuangou::getHistory()]);
        }
    }