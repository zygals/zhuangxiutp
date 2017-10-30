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
            return json(['code'=>0,'msg'=>'group/skim','data'=>Tuangou::getlist($t_id)]);
        }

        /**
         * 获取正在进行限人团购活动
         */
        public function goon_pnum(){

            return json(['code'=>0,'msg'=>'group/goon_pnum','data'=>Tuangou::getGoonPnum()]);
        }

        /**
         * 获取历史限人团购活动
         */
        public function history_pnum(){

            return json(['code'=>0,'msg'=>'group/history_pnum','data'=>Tuangou::getHistoryPnum()]);
        }
    }