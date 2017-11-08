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
         * 查看限量团购历史活动总结详情页
         */
        public function get_article(Request $request){
            $data = $request->param();
            $a_id = $data['a_id'];
            return json(['code'=>0,'msg'=>'group/get_article','data'=>TuanGou::getArticle($a_id)]);
        }

        /**
         * 获取正在进行限人活动
         */
        public function goon_pnum(){
            return json(TuanGou::getGoonPnum());
        }

        /**
         * 获取历史限人活动
         */
        public function history_pnum(){

            return json(TuanGou::getHistoryPnum());
        }

        /**
         * 查看限人详情页
         */
        public function pnuminfo(Request $request){
			$rules = ['t_id' => 'require'];
			$data = $request->param();
			$res = $this->validate($data, $rules);
			if ($res !== true) {
				return json(['code' => __LINE__, 'msg' => $res]);
			}
            $t_id = $request->param('t_id');
//			echo $t_id;exit;
            return json(['code'=>0,'msg'=>'group/pnuminfo','data'=>TuanGou::getPnumList($t_id)]);
        }
    }