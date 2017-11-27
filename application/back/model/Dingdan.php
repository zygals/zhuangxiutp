<?php

namespace app\back\model;

use app\api\model\Shop;
use think\Model;
use app\back\model\Good;
use app\back\model\OrderGood;

class Dingdan extends model {
    protected $dateFormat='Y-m-d H:i:s';
    const GOODST_WEIFAHUO = 1;
    const GOODST_YIFAHUO = 2;
    const GOODST_BUFEN_FAHUO = 5;

    public static $arrStatus = [1 => '未支付', 2 => '已支付', 3 => '已退款', 4 => '用户取消', 5 => '用户删除',6=>'申请退款',7=>'订金抵扣商品',8=>'订金抵扣全款'];
    public static $arrType = [1 => '普通', 3 => '限人', 4 => '商家订金', 5 => '商家全款', 6 => '限人尾款'];

    public function getStAttr($value) {
        $status = ['0' => '管理员删除', 1 => '未支付', 2 => '已支付', 3 => '已退款', 4 => '用户取消', 5 => '用户删除',6=>'申请退款',7=>'订金抵扣商品',8=>'订金抵扣全款'];
        return $status[$value];
    }

    public function getTypeAttr($value) {
        $status = [1 => '普通',
            3 => '限人', 4 => '商家订金', 5 => '商家全款', 6 => '限人尾款'];
        return $status[$value];
    }

    public function getGoodstAttr($value) {
        $status = [1 => '未发货', 2 => '已发货', 5 => '部分发货', 3 => '已收货', 4 => '已评价'];
        return $status[$value];
    }

    public static function findOne($order_id) {
        $row_ = self::where(['dingdan.id' => $order_id])->join('user', 'dingdan.user_id=user.id')->join('shop', 'shop.id=dingdan.shop_id')->join('address', 'address.id=dingdan.address_id'
            , 'left')->join('order_contact', 'order_contact.id=dingdan.order_contact_id', 'left')->field('dingdan.*,address.truename,address.mobile,address.pcd,address.info,user.username,shop.id shop_id,shop.name shop_name,order_contact.orderno orderno_contact')->find();

        return $row_;
    }

    /*
     * //分页查询
     * */
    public static function getAlldingdans($data) {
        $where = ['dingdan.st' => ['<>', 0]];
        $order = ['create_time desc'];
        //$time_from = isset($data['time_from']) ? $data['time_from'] : '';
       // $time_to = isset($data['time_to']) ? $data['time_from'] : '';
        if (Admin::isShopAdmin()) {
            $where['dingdan.shop_id'] = session('admin_zhx')->shop_id;
        }
        if (!empty($data['time_from'])) {
            $where['dingdan.create_time'] = ['gt', strtotime($data['time_from'])];
        }
        if (!empty($data['time_to'])) {
            $where['dingdan.create_time'] = ['lt', strtotime($data['time_to'])];
        }
        if (!empty($data['time_from']) && !empty($data['time_to'])) {
            $where['dingdan.create_time'] = [['gt', strtotime($data['time_from'])], ['lt', strtotime($data['time_to'])]];
        }
        if (!empty($data['orderno'])) {
            $where['dingdan.orderno'] = ['like', '%' . $data['orderno'] . '%'];
        }
        if (!empty($data['shop_id'])) {
            $where['shop_id'] = $data['shop_id'];
        }
        if (!empty($data['st'])) {
            $where['dingdan.st'] = $data['st'];
        }
        if (!empty($data['type'])) {
            $where['dingdan.type'] = $data['type'];
        }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }

        $list = self::where($where)->join('user', 'user.id=dingdan.user_id')->join('shop', 'dingdan.shop_id=shop.id')->join('order_contact', 'dingdan.order_contact_id=order_contact.id', 'left')->field('dingdan.*,user.username,shop.name shop_name,order_contact.orderno orderno_contact')->order($order)->paginate(10);
        //dump($list);
        if(!empty($data['excel']) && $data['excel']==1){ //导出表格

            $list_ = self::where($where)->join('user', 'user.id=dingdan.user_id')->join('shop', 'dingdan.shop_id=shop.id')->join('order_contact', 'dingdan.order_contact_id=order_contact.id', 'left')->field('dingdan.*,user.username,shop.name shop_name,order_contact.orderno orderno_contact')->order($order)->select();

            $excel=  new \PHPExcel();

            $excel->setActiveSheetIndex(0)
                ->setCellValue('A1', '编号')
                ->setCellValue('B1', '联合编号')
                ->setCellValue('C1', '类型')
                ->setCellValue('D1', '订单编号')
                ->setCellValue('E1', '商户名称')
                ->setCellValue('G1', '用户名')
                ->setCellValue('H1', '总 价');

            foreach ($list_ as $key => $value) {
                $key += 2; //从第二行开始填充
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $key, $value['id']);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $key, $value['orderno_contact']);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $key, $value['type']);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $key, $value['orderno']);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $key, $value['shop_name']);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $key, $value['username']);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $key, $value['sum_price']);
            }
            $excel->getActiveSheet()->setTitle('order_list');
            $excel->setActiveSheetIndex(0);
            $objWriter = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $filename = "order_list.xlsx";

            //ob_end_clean();//清除缓存以免乱码出现
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        }
        return $list;
    }


    /*
     * 更改订单发货状态
     * zhuangiu - zyg
     * */
    public static function updateGoodst($id, $type) {
        $row_ = self::where(['id' => $id])->find();
        if ($type == 'all') {
            $row_->goodst = self::GOODST_YIFAHUO;
        } elseif ($type == 'part') {
            $row_->goodst = self::GOODST_BUFEN_FAHUO;
        }
        $row_->save();
    }

    /*
     *管理员改订单状态为已支付或是已退款
     *
     * zhuangxiu-zyg
     * */
    public static function stPaid($data) {
        $admin = Admin::where(['type' => 1])->find();
        //dump($admin);exit;
        if (Admin::pwdGenerate($data['pass_admin']) !== $admin->pwd) {
            return ['code' => __LINE__, 'msg' => '密码有误！'];
        }
        $row_order = self::where(['id' => $data['order_id']])->find();
        if ($data['st'] == 'paid') {

            $row_order->st = 2;
            self::udpateShouyi($row_order->shop_id,$row_order->sum_price);
        } elseif ($data['st'] == 'tuikuan') {
            $row_order->st = 3;
            self::udpateShouyi($row_order->shop_id,-$row_order->sum_price);
            Shop::incTradenum( $row_order->shop_id ,false);//交易量－
        }
        $row_order->save();

        return ['code' => 0, 'msg' => '状态改好了'];

    }

    public static function udpateShouyi($shop_id,$change){
        //同时增加商家收益
        $admin_shop = Admin::where(['shop_id' => $shop_id, 'st' => 1])->find();
        if (!$admin_shop) {
            return ['code' => __LINE__, 'msg' => '店铺管理员不存在或没有权限'];
        }
        $admin_shop->income += $change;
        $admin_shop->save();
    }
}
