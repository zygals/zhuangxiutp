<?php

namespace app\api\model;

use think\Model;
use app\api\model\GoodAttr;
use app\api\model\Collect;

class Good extends Base {

    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常', 2 => '下架'];
        return $status[$value];
    }

   public function getToTopAttr($value) {
        $status = [0 => '否', 1 => '是'];
        return $status[$value];
    }
    //using zyg
    public static function findOne($data){
        $row_ = self::where(['id'=>$data['good_id'],'st'=>1])->find();
        $user_id = User::getUserIdByName($data['username']);
        if(!$row_){
            return ['code'=>__LINE__,'msg'=>'商品不存在'];
        }
        $res = Collect::getByDivId(new Collect,$where=['st'=>1,'collect_id'=>$data['good_id'],'user_id'=>$user_id,'type'=>1]);
        if($res){
            return ['code'=>0,'is_collect'=>'true','data'=>$row_];
        }else{
            return ['code'=>0,'is_collect'=>'false','data'=>$row_];
        }

    }
    public function updateAddAttr($good_id){
        $row_good = $this->where(['id'=>$good_id])->find();
        $row_good->is_add_attr =1 ;
        $row_good->save();

    }
    public static function getListByCateId($cate_id){
        $row_ = self::where(['cate_id'=>$cate_id,'st'=>['<>',0]])->find();
        if($row_){
            return true;
        }
        return false;
    }
    public static function getListByshopId($shop_id){
        $row_ = self::where(['shop_id'=>$shop_id,'st'=>['<>',0]])->find();
        if($row_){
            return true;
        }
        return false;
    }
    public static function getList($data=[],$field='good.*,cate.name cate_name,shop.name shop_name',$where=['good.st' => ['=', 1]]) {
        //$where = ['good.st' => ['<>', 0], 'cate.st' => ['<>', 0]];
        $order = "create_time desc";
        if(Admin::isShopAdmin()){
            $where['good.shop_id'] = session('admin_zhx')->shop_id;
        }
        if (!empty($data['to_top'])) {
            $where['good.to_top'] = $data['to_top'];
        }
        if (!empty($data['cate_id'])) {
            $where['shop.cate_id'] = $data['cate_id'];
        }
        if (!empty($data['shop_id'])) {
            $where['shop_id'] = $data['shop_id'];
        }
        if (!empty($data['name'])) {
            $where['good.name'] = ['like','%'.$data['name'].'%'];
        }
        if(!empty($data['index_show'])){
            $where['index_show'] = $data['index_show'];
        }
        if (!empty($data['paixu'])) {
            $order = 'good.'.$data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = 'good.'.$data['paixu'] . ' desc';
        }
        if(!empty($data['st']) ){
            $where['good.st']= ['=',2];
        }
        $list_ = self::where($where)->join('shop','shop.id=good.shop_id')->join('cate', 'shop.cate_id=cate.id', 'left')->field($field)->order($order)->paginate();
//        dump($list_);exit;
        return $list_;
    }

    //wx
    public static function getBookRec(){
        $list_ = self::where(['type'=>1,'index_show'=>1,'st'=>1])->field('id,img,name,price')->limit(5)->order('sort asc')->select();
        return $list_;
    }

    //wx
    public static function updateStore($order_id){
        $list_order_good = OrderGood::getGood($order_id);
        foreach($list_order_good as $item){
            $row_good = Good::read($item->good_id);
            $row_good->store = $row_good->store - $item->nums;
            $row_good->sales = $row_good->sales + $item->nums;
            $row_good->save();
        }
    }

    /**
     * 根据shop_id查询该店铺下的所有商品
     * @param $shop_id
     * @return \think\Paginator
     */
    public static function read($shop_id){
        $list_ = self::where(['st'=>1,'shop_id'=>$shop_id])->field('id,name,price,img,unit')->order('sales desc')->cache()->paginate();
        return $list_;
    }
}
