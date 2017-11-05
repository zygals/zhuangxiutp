<?php

namespace app\api\controller;


use app\api\model\Activity;

use app\back\model\Base;
use think\Db;
use think\Request;


class ActivityController extends BaseController {
    /**
     *前进行的活动
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public function index(Request $request) {
        return json(Activity::getListNow());
    }

    /**
     *前台历史活动
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public function history_activity(Request $request) {
        return json(Activity::getListHistory());
    }

    /**
     *活动内页
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public function read(Request $request) {
        $data = $request->param();
        $rule = ['activity_id' => 'require|number'];
        $res = $this->validate($data, $rule);
        //dump( $res);exit;
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json(Activity::findOne($data['activity_id']));
    }

    /**
     * 添加报名
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public function save(Request $request) {
        $data = $request->param();
        $rule = ['activity_id' => 'require|number', 'truename' => 'require', 'mobile' => 'require', 'zuoji' => 'require', 'xiaoqu' => 'require'];
        $res = $this->validate($data, $rule);
        //dump( $res);exit;
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $data['create_time'] = time();
        $data['update_time'] = time();
        if (!Db::table('activity_attend')->insert($data)) {
            return json(['code' => __LINE__, 'msg' => 'save attend error']);
        }
        //增加活动人数
        (new Activity())->where('id', $data['activity_id'])->setInc('pnum');
        return json(['code' => 0, 'msg' => 'save attend ok']);
    }

}
