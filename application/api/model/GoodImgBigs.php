<?php

namespace app\api\model;
use think\Model;

class GoodImgBigs extends Base{
    protected $table = 'good_img_bigs';
    /**
     * 获取商品多图接口模型
     */
    public static function getImg($data){
        $imgList = self::where(['good_id'=>$data,'st'=>1])->select();
        if($imgList->isEmpty()){
            return ['code'=>__LINE__];
        }
        return ['code'=>0,'msg'=>'good/images','data'=>$imgList];
    }


}