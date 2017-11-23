<?php

namespace app\api\model;

use think\Model;

class Shop extends Base{
	public function getToTopAttr($value){
		$status = [0 => '否' , 1 => '是'];
		return $status[$value];
	}

	public function getStAttr($value){
		$status = [0 => 'deleted' , 1 => '正常'];
		return $status[$value];
	}

	public static function getListAll(){
		$where = ['shop.st' => ['=' , 1]];
		$order = "create_time asc";
		$list_ = self::where( $where )->join( 'cate' , 'shop.cate_id=cate.id' )->field( 'shop.*,cate.name cate_name' )->order( $order )->select();

		return $list_;
	}

	// 1,2,3   1
	public static function getListByCateId($cate_id){
		$row_ = self::where( ['cate_id' => $cate_id , 'st' => ['=' , 1]] )->find();
		if ( $row_ ) {
			return true;
		}
		return false;
	}

	/*
	 * 取商家列表 zhuangxiu-zyg
	 * */
	public static function getList($data = []){
		$field = 'shop.id shop_id,shop.name shop_name,shop.ordernum,shop.tradenum,shop.img,shop.logo,cate.name cate_name';
		$where = ['shop.st' => 1];
		$order = "shop.sort asc,shop.ordernum desc,shop.tradenum desc,shop.create_time asc";//默认销量排序,否则按时间
		if ( !empty( $data['cate_id'] ) ) {
			$where['cate_id'] = $data['cate_id'];
		}
		if ( !empty( $data['name_'] ) ) {
			$where['shop.name|shop.truename|city'] = ['like' , '%' . $data['name_'] . '%'];
		}
		if ( !empty( $data['paixu'] ) ) {
			$order = 'shop.' . $data['paixu'] . ' desc, shop.create_time desc';
		}
		if ( !empty( $data['paixu'] ) && $data['paixu'] == 'hot' ) {
			$where['shop.to_top'] = 1;
			$order = "shop.update_time desc";
		}
		$list_ = self::where( $where )->join( 'cate' , 'shop.cate_id=cate.id' )->order( $order )->field( $field )->cache()->paginate(8);
		if ( $list_->isEmpty() ) {
			return ['code' => __LINE__ , 'msg' => '暂无数据'];
		}
		return ['code' => 0 , 'msg' => 'shop list ok' , 'data' => $list_];
	}

	public static function getIndexList(){
		$where = ['st' => ['=' , 1]];
		$list_ = self::where( $where )->order( 'create_time asc' )->select();

		return $list_;
	}

	//wx

	public static function read($data){
		$shop_id = $data['shop_id'];
		$row_ = self::getById( $shop_id , new self() , 'id shop_id,name,city,addr,truename,phone,ordernum,tradenum,fankuinum,img,logo,info,brand,zuoji,deposit,youhui,money_all,youhui_all' );
		$user_id = User::getUserIdByName( $data['username'] );
		if ( !$row_ ) {
			return ['code' => __LINE__ , 'msg' => 'good not exist'];
		}
		$row_['isGroup'] = TuanGou::isAttend($shop_id);
		$res = Collect::getByDivId( new Collect , $where = ['st' => 1 , 'collect_id' => $data['shop_id'] , 'user_id' => $user_id , 'type' => 2] );
		if ( $res ) {
			return ['code' => 0 , 'is_collect' => 'true' , 'data' => $row_];
		} else {
			return ['code' => 0 , 'is_collect' => 'false' , 'data' => $row_];
		}

	}

	/*
	 *给商家订单量增加一个
	 * zhuangxiu-zyg
	 * */
	public static function increaseOrdernum($shop_id,$add=true){
		$row_shop = self::where( ['id' => $shop_id , 'st' => 1] )->find();
		if($add){

            $row_shop->setInc('ordernum');
        }else{
            $row_shop->setDec('ordernum');
        }
	}
	/*
	 *给商家增加交易量
	 * zhuangxiu-zyg
	 * */
	public static function incTradenum($shop_id,$add=true){
		$row_shop = self::where( ['id' => $shop_id , 'st' => 1] )->find();
		if($add){
            $row_shop->setInc('tradenum');
        }else{
            $row_shop->setDec('tradenum');
        }
	}
}
