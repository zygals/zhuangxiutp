<?php

namespace app\wx\controller;

use app\common\model\Article;
use app\common\model\Cate;
use app\common\model\Good;
use app\common\model\School;
use app\common\model\SchoolRec;
use think\Request;
use app\common\model\Ad;
class IndexController extends BaseController
{

   public function index() {
        $list_ad=Ad::getList(['paixu'=>'sort'],['st'=>1]);

        return json(['code'=>0,'msg'=>'index','data'=>$list_ad]);

   }
   public function school_rec(){
       $list_school_rec_top = SchoolRec::getList(['type'=>1,'paixu'=>'sort']);
       $list_school_rec_bottom = SchoolRec::getList(['type'=>2,'paixu'=>'sort']);
       return json(['code'=>0,'msg'=>'school_rec','data'=>['list_school_rec_top'=>$list_school_rec_top,'list_school_rec_bottom'=>$list_school_rec_bottom]]);
   }
   public function book_rec(){
       return json(['code'=>0,'msg'=>'book_rec','data'=>Good::getBookRec()]);
   }
   public function article_new(){
       return json(['code'=>0,'msg'=>'article_new','data'=>Article::getNew()]);
   }
   public function article_detail(Request $request){
       $data = $request->param();
       $rule = ['article_id'=>'require|number'];
       $res = $this->validate($data,$rule);
       if(true !== $res){
           return ['code'=>__LINE__,'msg'=>$res];
       }
       return json(['code'=>0,'msg'=>'article_detail','data'=>Article::read($data['article_id'])]);
   }


}
