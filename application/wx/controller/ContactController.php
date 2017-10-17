<?php

namespace app\gshpc\controller;

use app\common\model\Seller;
use app\common\model\SeoSet;
use think\Request;
class ContactController extends BaseController
{
 public function index(){
     $seo = SeoSet::getSeoByNavId(9);
     $list_seller = Seller::getList();
     return $this->fetch('',['seo'=>$seo,'list_seller'=>$list_seller]);
 }


}
