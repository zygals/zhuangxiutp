<?php

namespace app\api\model;

use think\Model;

class Activity extends Base {


    /**
     *前进行的活动
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public static function getListNow($data = []) {
        $where = ['type'=>1,'st' => ['=', 1], 'start_time' => ['<', time()], 'end_time' => ['>', time()]];

        $list_ = self::where($where)->field('id,name,img,img_big,charm')->order('create_time desc')->select();

        if ($list_->isEmpty()) {
            return ['code' => __LINE__];
        }
        return ['code' => 0, 'msg' => '数据成功', 'data' => $list_];

    }
    /**
     *前台历史活动
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public static function getListHistory($data = []) {
        $where = ['type'=>1,'st' => ['=', 1], 'end_time' => ['<', time()]];

        $list_ = self::where($where)->field('id,name,img,charm')->order('create_time desc')->select();

        if ($list_->isEmpty()) {
            return ['code' => __LINE__];
        }
        return ['code' => 0, 'msg' => '数据成功', 'data' => $list_];

    }
    /**
     *前台正在验房
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public static function getListYanfangNow() {
        $where = ['type'=>2,'st' => ['=', 1], 'start_time' => ['<', time()], 'end_time' => ['>', time()]];

        $list_ = self::where($where)->field('id,name,img_big,info,attend_num,imgs')->order('create_time desc')->find();

        if (!$list_) {
            return ['code' => __LINE__];
        }
        return ['code' => 0, 'msg' => '数据成功', 'data' => $list_];

    }

    /**
     *前台lishi验房
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public static function getListYanfangHistory($data = []) {
        $where = ['type'=>2,'st' => ['=', 1], 'end_time' => ['<', time()]];

        $list_ = self::where($where)->field('id,name,img_big,charm')->order('create_time desc')->select();

        if ($list_->isEmpty()) {
            return ['code' => __LINE__];
        }
        return ['code' => 0, 'msg' => '数据成功', 'data' => $list_];

    }

    /**
     *活动内页
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public static function findOne($id) {

        if (!$row_ = self::getById($id, new self)) {
            return ['code' => __LINE__];
        }
        $row_->start_time = date('Y-m-d');
        $row_->end_time = date('Y-m-d');
        return ['code' => 0, 'msg' => '数据成功', 'data' => $row_];
    }


}
