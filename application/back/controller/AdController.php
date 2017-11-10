<?php

namespace app\back\controller;


use app\back\model\Ad;

use app\back\model\Base;
use think\Request;


class AdController extends BaseController {
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {
        $data = $request->param();
//        dump($data);exit;
//        exit;
        $list_ = Ad::getList($data);
        $page_str = $list_->render();
        $page_str = Base::getPageStr($data, $page_str);
        $url = $request->url();
        return $this->fetch('index', ['list_' => $list_, 'page_str' => $page_str, 'url' => $url]);
    }
    /* public function mobile_index(Request $request){
         $data = $request->param();
         $rule = ['position' => 'number'];
         $res = $this->validate($data, $rule);
         if ($res !== true) {
             $this->error($res);
         }
         $m_ = new Ad();
         $list_ = $m_->getListMobile($data);
         $list_position = Ad::getPositions();
         $current = $request->url();
         //dump($current);exit;
         return $this->fetch('', ['list_' => $list_, 'list_position' => $list_position,'current'=>$current]);
     }*/

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create() {


        return $this->fetch('', ['title' => '添加广告图', 'act' => 'save']);

    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
        $data = $request->param();

        $res = $this->validate($data, 'AdValidate');
        if ($res !== true) {
            $this->error($res);
        }
        $file = $request->file('img');

        if (empty($file)) {
            $this->error('请上传图片或检查图片大小！');
        }
        $size = $file->getSize();
        if ($size > config('upload_size')) {
            $this->error('图片大小超过限定！');
        }
        $path_name = 'ad';
        $arr = $this->dealImg($file, $path_name);
        $data['img'] = $arr['save_url_path'];
        //url_to
        $data['url_bianhao'] = $data['url'];
        switch ($data['url_to']) {
            case Ad::URL_TO_ACTIVITY_DETAIL:
                $data['url'] = '/pages/groupPurchase/groupPurchase?activity_id=' .$data['url_bianhao'];
                break;
            case Ad::URL_TO_GOOD_DETAIL:
                $data['url'] = '/pages/bDetail/bDetail?good_id=' . $data['url_bianhao'];
                break;
            case Ad::URL_TO_SHOP_DETAIL:
                $data['url'] = '/pages/store/store?shop_id=' . $data['url_bianhao'];
                break;
            case Ad::URL_TO_SHOP_LIST:
                $data['url'] = '/pages/goods/goods';
                break;
            case Ad::URL_TO_ONLINEGROUP_LIST:
                $data['url'] = '/pages/goodDetail/goodDetail?t_id=' .$data['url_bianhao'];
                break;
            case Ad::URL_TO_CHECKROOM_LIST:
                $data['url'] = '/pages/house/house';
                break;
            default:
                $data['url'] = '';

        }

        $Ad = new Ad();
        $Ad->save($data);
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
        $row_ = $this->findById($data['id'], new Ad());
        return $this->fetch('', ['row_' => $row_, 'referer' => $referer, 'title' => '修改广告图 ' . $row_->name, 'act' => 'update']);
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
        $res = $this->validate($data, 'AdValidate');
        if ($res !== true) {
            $this->error($res);
        }
        $data['url_bianhao'] = $data['url'];
        switch ($data['url_to']) {
            case Ad::URL_TO_ACTIVITY_DETAIL:
				$data['url'] = '/pages/groupPurchase/groupPurchase?activity_id=' .$data['url_bianhao'];
                break;
            case Ad::URL_TO_GOOD_DETAIL:
                $data['url'] = '/pages/bDetail/bDetail?good_id=' . $data['url_bianhao'];
                break;
            case Ad::URL_TO_SHOP_DETAIL:
                $data['url'] = '/pages/store/store?shop_id=' .  $data['url_bianhao'];
                break;
            case Ad::URL_TO_SHOP_LIST:
                $data['url'] = '/pages/goods/goods';
                break;
            case Ad::URL_TO_ONLINEGROUP_LIST:
                $data['url'] = '/pages/goodDetail/goodDetail?t_id=' .$data['url_bianhao'];
                break;
            case Ad::URL_TO_CHECKROOM_LIST:
                $data['url'] = '/pages/house/house';
                break;
            default:
                $data['url'] = '';

        }
        $file = $request->file('img');
        $row_ = $this->findById($data['id'], new Ad());
        if (!empty($file)) {
            $path_name = 'ad';
            $size = $file->getSize();
            if ($size > config('upload_size')) {
                $this->error('图片大小超过限定！');
            }
            $this->deleteImg($row_->img);
            $arr = $this->dealImg($file, $path_name);
            $data['img'] = $arr['save_url_path'];
        }
        if ($this->saveById($data['id'], new Ad(), $data)) {
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

        if ($this->deleteStatusById($data['id'], new Ad())) {
            $this->success('删除成功', $data['url'], '', 1);
        } else {
            $this->error('删除失败', $data['url'], '', 3);
        }
    }


}
