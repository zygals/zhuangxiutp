<?php

namespace app\gshpc\controller;

use think\Request;
use app\common\model\Ad;
use app\common\model\SeoSet;
class WxController extends BaseController
{
   public function index(){
       $row_ad = Ad::getAdByPosition(4);
       $list_ad = Ad::getAdsByPosition(7);
       $seo = SeoSet::getSeoByNavId(8);
        return $this->fetch('',['row_ad'=>$row_ad,'list_ad'=>$list_ad,'seo'=>$seo]);
   }
}
