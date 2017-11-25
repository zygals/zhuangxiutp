<?php

namespace app\api\controller;


use app\api\model\Activity;

use app\api\model\ActivityAttend;
use app\api\model\User;
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
     *前台正在验房
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public function activity_yanfang(Request $request) {
        return json(Activity::getListYanfangNow());
    }

    /**
     *前台lishi验房
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public function activity_yanfang_lishi(Request $request) {
        return json(Activity::getListYanfangHistory());
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

        $res = $this->validate($data, 'AttendValidate');
        //dump( $res);exit;
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $user_id = User::getUserIdByName($data['username']);
        if (is_array($user_id)) {
            return json($user_id);
        }
        $data['user_id'] = $user_id;
        unset($data['username']);
        if (!empty($data['time_to'])) {

            $data['time_to'] = strtotime($data['time_to']);
        }

        //is add ?
        $row_attend = ActivityAttend::where(['user_id' => $user_id, 'activity_id' => $data['activity_id']])->find();
        if ($row_attend) {//not add
            $row_attend->save($data);
            return json(['code' => '0', 'msg' => 'update attend ok']);
        }
        if (!(new ActivityAttend())->save($data)) {
            return json(['code' => __LINE__, 'msg' => 'save attend error']);
        }
        //增加实际活动人数
        (new Activity())->where('id', $data['activity_id'])->setInc('pnum');
        return json(['code' => 0, 'msg' => 'save attend ok']);
    }

    /**
     * 取我的报名
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public function read_attend(Request $request) {
        $data = $request->param();
        $rule = ['activity_id' => 'require|number', 'username' => 'require'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $user_id = User::getUserIdByName($data['username']);
        if (is_array($user_id)) {
            return json($user_id);
        }
        $row_attend = ActivityAttend::where(['user_id' => $user_id, 'activity_id' => $data['activity_id']])->find();

        if ($row_attend) {
            $row_attend->time_to = date('Y-m-d H:i:s', $row_attend->time_to);
            return json(['code' => 0, 'msg' => '数据成功', 'data' => $row_attend]);
        }
        return json(['code' => __LINE__]);
    }

    /*
     * 取我的报名列表
     * zhuangxiu-zyg
     * */

    public function my_attend(Request $request) {
        $data = $request->param();
        $rule = ['username' => 'require'];
        $res = $this->validate($data, $rule);
        //dump( $res);exit;
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json(ActivityAttend::getMyAttend($data['username']));
    }


}
