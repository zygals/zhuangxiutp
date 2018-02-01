<?php

namespace app\api\controller;

use app\api\model\AccessToken;
use app\api\model\Shop;
use app\api\model\ShopAddress;
use app\api\model\TuanGou;
use think\Request;
class ShopController extends BaseController
{
    /*
     * 商家列表：可以根据分类查询，根据销量等排序
     * */
   public function index(Request $request){

       $data = $request->param();
       $rule = ['cate_id' => 'number'];
       $res = $this->validate($data, $rule);
       if ($res !== true) {
           return json(['code' => __LINE__, 'msg' => $res]);
       }
       return json(Shop::getList($data));

   }

    /**
     * 商家详情:获取商家的详细信息
     * @return \think\response\Json
     *
     */
   public function read(Request $request){
       $data = $request->param();
       $rule = ['shop_id' => 'require|number','username'=>'require'];
       $res = $this->validate($data, $rule);
       if ($res !== true) {
           return json(['code' => __LINE__, 'msg' => $res]);
       }
       return json(Shop::read($data));
   }

    /**
     * 店铺详情-查询门店地址列表
     * @return \think\response\Json
     */
   public function addr(Request $request){
       $data = $request->param();
       $rule = ['shop_id' => 'require|number'];
       $res = $this->validate($data, $rule);
       if ($res !== true) {
           return json(['code' => __LINE__, 'msg' => $res]);
       }

       return json(['code' => 0, 'msg' => 'shop/addr', 'data' =>ShopAddress::getAddressByShop($data['shop_id'])]);
   }

    /**
     * 是否参加团购
     */
    public function isGroup(Request $request){
        $data = $request->param();
        return json(TuanGou::isAttend($data['shop_id']));
    }

    /**
     * 获取二维码
     */
    public function at(Request $request){
        //判断该商户是否已生成微信二维码
        $data = $request->param();
        $shop_id = $data['shop_id'];
        $res = (new Shop())->where(['id'=>$shop_id])->find();
        //储存到static下的qrcode目录,并将名称保存至数据库
        if($res->wx_qrcode == ""){
            //获取access_token
            $ac =  (new AccessToken())->getToken();
            $path="pages/store/store?shop_id=".$shop_id;
            $width=430;
            $post_data='{"path":"'.$path.'","width":'.$width.'}';
            $url="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$ac;
            $result=$this->api_notice_increment($url,$post_data);
            $name = ROOT_PATH . 'public/upload/qrcode/temp.jpg';
            $newname = ROOT_PATH . 'public/upload/qrcode/'.md5(md5(rand(0,999))).'.jpg';
            file_put_contents($name,$result);
            rename($name,$newname);
            $tmp = stripos($newname,'/upload');
            $wx_qrcode = substr($newname,$tmp);
            $shop = new Shop();
            $shop->where('id',$shop_id)->update(['wx_qrcode'=>$wx_qrcode]);
            return json(['wx_qrcode'=>$wx_qrcode]);
        }else{
            $wx_qrcode = $res->wx_qrcode;
            return json(['wx_qrcode'=>$wx_qrcode]);
        }
    }
}
