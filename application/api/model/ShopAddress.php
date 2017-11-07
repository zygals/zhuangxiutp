<?php

namespace app\api\model;

use think\Model;

class ShopAddress extends Base {


    public  function saveAddress($data,$act=1){
        if($act==2){
            $this->where(['shop_id'=>$data['shop_id']])->update(['st'=>0]);
        }
        $data_ = [];
          foreach ($data['name_'] as $k=>$val){
              $data_[] = ['shop_id'=>$data['shop_id'],'name_'=>$val,'truename_'=>$data['truename_'][$k],'address_'=>$data['address_'][$k],'mobile_'=>$data['mobile_'][$k]];

          }
        $this->saveAll($data_);

         // dump($data_);exit;
    }


    public static function getAddressByShop($shop_id,$field='id,name_,truename_,mobile_,address_,zuoji'){
        $list_ = self::where(['shop_id'=>$shop_id,'st'=>1])->field($field)->select();
        return $list_;
    }


}
