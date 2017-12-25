<?php

namespace app\back\controller;


use app\back\model\Activity;

use app\back\model\ActivityAttend;
use app\back\model\Base;
use think\Request;


class ActivityController extends BaseController {
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {
        $data = $request->param();

        $list_ = Activity::getList($data);
        $page_str = $list_->render();
        $page_str = Base::getPageStr($data, $page_str);
        $url = $request->url();
        return $this->fetch('index', ['list_' => $list_, 'page_str' => $page_str, 'url' => $url]);
    }

    /**
     *  查看报名
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public function index_attend(Request $request) {

        $data = $request->param();
        $rule = ['activity_id' => 'require'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            $this->error($res);
        }
        $list_ = ActivityAttend::getList($data);
        if ($list_->isEmpty()) {
            $this->error('暂无数据', 'index', '', 1);
        }
        $page_str = $list_->render();
        $page_str = Base::getPageStr($data, $page_str);
        $url = $request->url();
        return $this->fetch('index_attend', ['list_' => $list_, 'page_str' => $page_str, 'url' => $url]);
    }


    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create() {


        return $this->fetch('', ['title' => '添加活动', 'act' => 'save']);

    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
        $data = $request->param();

        /* $res = $this->validate($data, 'ActivityValidate');
         if ($res !== true) {
             $this->error($res);
         }*/
        $Activity = new Activity();
        $file2 = $request->file('img_big');
        $path_name = 'activity';
        if (!empty($file2)) {
            $size = $file2->getSize();
            if ($size > config('upload_size')) {
                $this->error('图片大小超过限定！');
            }
            $arr = $this->dealImg($file2, $path_name);

            $data['img_big'] = $arr['save_url_path'];
        }
        $file = $request->file('img');
        if (empty($file)) {
            //$this->error('请上传图片或检查图片大小！');
        }
        if (!empty($file)) {
            $size = $file->getSize();
            if ($size > config('upload_size')) {
                $this->error('图片大小超过限定！');
            }
            $arr = $this->dealImg($file, $path_name);

            $data['img'] = $arr['save_url_path'];
        }
        $file = $request->file('imgs');
        if (empty($file)) {
            //$this->error('请上传图片或检查图片大小！');
        }
        if (!empty($file)) {
            $size = $file->getSize();
            if ($size > config('upload_size')) {
                $this->error('图片大小超过限定！');
            }

            $arr = $this->dealImg($file, $path_name);
            $data['imgs'] = $arr['save_url_path'];
        }
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $Activity->save($data);
        $this->success('添加成功', 'index', '', 1);

    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit(Request $request) {
        $data = $request->param();
        $referer = $request->header()['referer'];
        $row_ = $this->findById($data['id'], new Activity());
        return $this->fetch('', ['row_' => $row_, 'referer' => $referer, 'title' => '修改活动 ' . $row_->name, 'act' => 'update']);
    }


    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request) {
        //dump($request->param());exit;
        $data = $request->param();
        $referer = $data['referer'];
        unset($data['referer']);
        /*$res = $this->validate($data, 'ActivityValidate');
        if ($res !== true) {
            $this->error($res);
        }*/

        $file2 = $request->file('img_big');
        $path_name = 'activity';
        $row_ = $this->findById($data['id'], new Activity());

        if (!empty($file2)) {
            $size = $file2->getSize();
            if ($size > config('upload_size')) {
                $this->error('图片大小超过限定！');
            }
            $this->deleteImg($row_->img_big);
            $arr = $this->dealImg($file2, $path_name);
            $data['img_big'] = $arr['save_url_path'];

        }
        $file = $request->file('img');
        if (!empty($file)) {

            $size = $file->getSize();
            if ($size > config('upload_size')) {
                $this->error('图片大小超过限定！');
            }
            $this->deleteImg($row_->img);
            $arr = $this->dealImg($file, $path_name);
            $data['img'] = $arr['save_url_path'];
        }
        $file = $request->file('imgs');
        if (empty($file)) {
            //$this->error('请上传图片或检查图片大小！');
        }
        if (!empty($file)) {
            $size = $file->getSize();
            if ($size > config('upload_size')) {
                $this->error('图片大小超过限定！');
            }
            $this->deleteImg($row_->imgs);
            $arr = $this->dealImg($file, $path_name);
            $data['imgs'] = $arr['save_url_path'];
        }
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        if ($this->saveById($data['id'], new Activity(), $data)) {
            $this->success('编辑成功', $referer, '', 1);
        } else {
            $this->error('没有修改', $referer, '', 1);
        }


    }


    /**
     * soft-delete 指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete(Request $request) {
        $data = $request->param();

        if ($this->deleteStatusById($data['id'], new Activity())) {
            $this->success('删除成功', $data['url'], '', 1);
        } else {
            $this->error('删除失败', $data['url'], '', 3);
        }
    }

    /**
     * 导出excle
     *
     */
    public function export(Request $request) {
        $data = $request->param();
        $activity_id = $data['activity_id'];
        $fields = 'activity.name,activity.type,activity_attend.*,FROM_UNIXTIME( activity_attend.time_to, "%Y-%m-%d %H:%i:%S" ) time_to';
        $res = ActivityAttend::where('activity_id', $activity_id)->join('activity', 'activity.id=activity_attend.activity_id')->field($fields)->select();
//        dump(date('Y-m-d H:i:s',$res[0]['create_time']));exit;
        $excel = new \PHPExcel();
        if ($res[0]->type == 1) {
            $excel->setActiveSheetIndex(0)
                ->setCellValue('A1', '编号')
                ->setCellValue('B1', '标题')
                ->setCellValue('C1', '姓名')
                ->setCellValue('D1', '电话')
                ->setCellValue('E1', '小区名称')
                ->setCellValue('G1', '报名时间');
            foreach ($res as $key => $value) {
                $key += 2; //从第二行开始填充
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $key, $value['id']);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $key, $value['name']);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $key, $value['truename']);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $key, $value['mobile']);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $key, $value['xiaoqu']);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $key, $value['create_time']);
            }
        } else {
            $excel->setActiveSheetIndex(0)
                ->setCellValue('A1', '编号')
                ->setCellValue('B1', '标题')
                ->setCellValue('C1', '姓名')
                ->setCellValue('D1', '电话')
                ->setCellValue('E1', '地址')
                ->setCellValue('F1', '验房时间')
                ->setCellValue('G1', '报名时间');
            foreach ($res as $key => $value) {
                $key += 2; //从第二行开始填充
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $key, $value['id']);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $key, $value['name']);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $key, $value['truename']);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $key, $value['mobile']);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $key, $value['xiaoqu']);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $key, $value['time_to']);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $key, $value['create_time']);
            }
        }

        $excel->getActiveSheet()->setTitle('活动报名');
        $excel->setActiveSheetIndex(0);

        $objWriter = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $filename = $res[0]->name . " 活动报名.xlsx";
        ob_end_clean();//清除缓存以免乱码出现
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }


}
