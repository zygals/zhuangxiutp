<?php

namespace app\back\controller;

use app\back\model\Dingdan;
use app\back\model\Shop;
use think\Cache;
use think\Request;
use app\back\model\User;
use app\back\model\AdminLog;
class IndexController extends BaseController
{
   public function index(Request $request){
        $list_ = AdminLog::getLogs();
        return $this->fetch('index',['list_'=>$list_]);
   }
   /*
    * 清理前台缓存
    * */
   public function clear_cache(Request $request){
       Cache::clear();
       $back='index/index';
       if(!empty($request->header()['referer'])){
           $back=$request->header()['referer'];
       }
       $this->success('缓存清理成功',$back,'',1);

   }

    public function gaidd() {
       //all st=1 shop
        /*
         * foreach shop and find dingdan ,sum yishouhuo = jiaoyi ;sum yizhifu= dingdanshu
         * */
        $list_shop = Shop::where(['st'=>1])->select();
        foreach($list_shop as $k=>$shop){
//            $tradenum=0;$ordernum=0;
            $tradenum = Dingdan::where(['shop_id'=>$shop->id,'goodst'=>3,'st'=>['in','2,6,7,8,9,10']])->count('id');
            $ordernum = Dingdan::where(['shop_id'=>$shop->id,'st'=>['in','2,6,7,8,9,10']])->count('id');
            $shop->tradenum = $tradenum;
            $shop->ordernum = $ordernum;
            $shop->save();
            echo $shop->id.'_'.$ordernum,"<br>";
            echo $shop->id.'_'.$tradenum,"<br>";
        }
        $k++;
        return "gai hao le $k ge";

    }

}
