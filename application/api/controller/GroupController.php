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

        /**
         * 查看限量团购详情页
         */
        public function skim(Request $request){
            $t_id = $request->param();
            $aa = Tuangou::getlist($t_id);
            dump($aa);exit;
        }
    }