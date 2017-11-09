<?php

namespace app\back\model;

use think\Model;

class Tuangou extends model{

	public static $type_ = [
		['type_id'=>1,'name'=>'限人'],
		['type_id'=>2,'name'=>'限量'],
	];
    public function getTypeAttr($groupalue){
		$type = [1 => '限人' , '2' => '限量'];
		return $type[$groupalue];
	}
    public function getStAttr($groupalue){
		$status = [0 => '删除' , 1 => '正在进行' , 2 => '下架'];
		return $status[$groupalue];
	}
	//默认失败,当人数达到则成功.
    public function getGroupStAttr($groupalue){
		$status = [1 => '正在进行' , 2 => '活动成功'/* , 3 => '活动失败'*/];
		return $status[$groupalue];
	}
    public static function getListAll(){
		$where = ['st' => ['=' , 1] , 'type' => ['=' , 2]];
		$order = "create_time asc";
		$list_ = self::where( $where )->order( $order )->select();

		return $list_;
	}
    public static function getList($data = [] , $field = 'tuangou.*,shop.name shop_name,good.name good_name' , $where = ['tuangou.st' => [['<>' , 0] , ['<>' , 2]]]){
		$order = "tuangou.create_time desc";
      if(!empty($data['type_id'])){
           $where['tuangou.st'] = $data['type_id'];
       }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }
		if(!empty($data['group_price'])){
			$order = 'tuangou'.$data['price_group'].'asc';
		}
		if(!empty($data['st']) ){
			$where['tuangou.st']= ['=',2];
		}
		$list_group = self::select();
//        dump($row);
		foreach ( $list_group as $key => $group ) {
			switch ( $group['type'] ) {
				case '限人':
					//判断条件:活动正在进行,团购人数已满足最低要求
					if ( /*$group['end_time'] > time() &&*/ $group['attend_pnum'] >= $group['pnum'] ) {
						self::where( 'id' , $group['id'] )->update( ['group_st' => 2] );
						//判断条件:活动已结束,团购人数不满足最低要求
					} elseif ( /*$group['end_time'] <= time() &&*/ $group['attend_pnum'] < $group['pnum'] ) {
						self::where( 'id' , $group['id'] )->update( ['group_st' => 1] );
					}
					break;
//				case '限量':
//					//判断条件:活动正在进行,但团购数量已满足最大值
//					if ( $group['end_time'] > time() && $group['already_sales'] >= $group['store'] ) {
//						self::where( 'id' , $group['id'] )->update( ['group_st' => 2] );
//						//判断条件:活动已结束
//					} elseif ( $group['end_time'] <= time() ) {
//						self::where( 'id' , $group['id'] )->update( ['group_st' => 2] );
//					}
//					break;
			}
		}
		$list_ = self::where( $where )->join( 'shop' , 'shop.id=tuangou.shop_id' )->join( 'good' , 'good.id=tuangou.good_id' )->field( $field )->order( $order )->paginate(10);
		return $list_;
	}

    public static function findByCateId($cate_id , $limit){
		$where['status'] = ['=' , 1];
		if ( $cate_id ) {
			$where['cate_id'] = $cate_id;
		}
		if ( $limit == 0 ) {
			$list_ = self::where( $where )->order( 'create_time desc' )->select();
		} else {
			$list_ = self::where( $where )->order( 'create_time desc' )->limit( $limit )->select();
		}

		return $list_;
	}
    public static function getIndexShow(){
		$where['good_new.status'] = ['=' , 1];
		$where['good_new.index_show'] = 1;
		$list_ = self::where( $where )->alias( 'good' )->join( 'cate' , 'good.cate_id=cate.id' , 'left' )->field( 'good.*,cate.name cate_name' )->order( 'sort asc,create_time asc' )->limit( 2 )->select();

		return $list_;
	}

    /* 查询单条团购信息
     *
     * @param: $id
     *
     * */

    public static function findById($id , $field = 'tuangou.*,shop.name shop_name,good.name good_name,good.price good_price'){
		$where['tuangou.id'] = ['=' , $id];
		$list_ = self::where( $where )->join( 'shop' , 'shop.id=tuangou.shop_id' )->join( 'good' , 'good.id=tuangou.good_id' )->field( $field )->find();
		return $list_;
	}


}
