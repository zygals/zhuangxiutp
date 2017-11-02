<?php

    namespace app\api\controller;
    use app\api\controller\BaseController;
    use think\Request;
    use app\api\model\TuanGou;
    use app\api\model\Article;

    class GroupController extends BaseController{
        /**
         * 正在进行的团购活动
         */
        public function goon(){
            return json(['code'=>0,'msg'=>'group/goon','data'=>TuanGou::getGoon()]);
        }

        /**
         * 历史团购活动
         */
        public function history()
        {
            return json(['code'=>0,'msg'=>'group/history','data'=>TuanGou::getHistory()]);
        }

        /**
         * 查看限量团购详情页
         */
        public function skim(Request $request){
            $t_id = $request->param();
            return json(['code'=>0,'msg'=>'group/skim','data'=>TuanGou::getlist($t_id)]);
        }

        /**
         * 获取正在进行限人团购活动
         */
        public function goon_pnum(){

            return json(['code'=>0,'msg'=>'group/goon_pnum','data'=>TuanGou::getGoonPnum()]);
        }

        /**
         * 获取历史限人团购活动
         */
        public function history_pnum(){

            return json(['code'=>0,'msg'=>'group/history_pnum','data'=>TuanGou::getHistoryPnum()]);
        }

        /**
         * 查看限人团购详情页
         */
        public function pnuminfo(Request $request){
            $t_id = $request->param();
            return json(['code'=>0,'msg'=>'group/pnuminfo','data'=>TuanGou::getPnumList($t_id)]);
        }
    }