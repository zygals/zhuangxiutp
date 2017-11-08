<?php

namespace app\back\model;

use think\Model;

class OrderGood extends model {
    const ST_PREPARE = 1; //没发货
    const ST_SENT = 2;//已发货
    const ST_TAKEN = 3;//已收货
    const ST_RETURN = 4;
   public function getStAttr($value){
	   $status = [1 => '没发货', 2 => '已发货',3=>'已收货'];
	   return $status[$value];
   }
    public static function getGood($order_id) {

        $where = ['order_id' => $order_id];
        $list_ = self::where($where)->order('create_time asc')->field('id,name good_name,good_id,price,num,img,st,price_group,group_deposit,unit')->select();
        return $list_;
    }

    public static  function getGoodOn($good_id){
        $list_ = self::where("good_id=:good_id  and (st=1 or st=2)",['good_id'=>$good_id])->find();
        return $list_;
    }

	public function saveSt($id){
		$row_ = $this->find($id);
		if(!$row_){
			return false;
		}
		$row_->st = self::ST_SENT;
		$row_->save();
		//
		$row_order_good_prepare = self::where(['order_id'=>$row_->order_id,'st'=>self::ST_PREPARE])->find();
        if($row_order_good_prepare){
			Dingdan::updateGoodst($row_->order_id,'part');
		}else{
			Dingdan::updateGoodst($row_->order_id,'all');
		}
		return true;
	}


}
