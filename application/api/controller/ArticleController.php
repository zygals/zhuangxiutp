<?php

namespace app\api\controller;

use app\api\model\Article;

use think\Request;


class ArticleController extends BaseController {

    /*public function index(Request $request ) {
        $data = $request->param();
        $rule = ['cate_article_id' => 'require|number','school_id'=>'number'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        if(!isset($data['school_id'])){
            $data['school_id'] = 0 ;
        }
        if(empty($data['title'])){
            $data['title']='';
        }
        return json(['code' => 0, 'msg' => 'Article/index', 'data' => Article::getList(['paixu' => 'create_time','sort_type'=>'desc','cate_article_id'=>$data['cate_article_id'],'school_id'=>$data['school_id'],'title'=>$data['title']], 'article.id,article.title,article.cont', ['article.st' => 1])]);
    }*/
    /*
     * index article list
     * zhuangxiu-zyg
     * */
    public function index_show(Request $request) {

        return json(Article::getListIndex());
    }
	/*
	 * 验房 article list
	 * zhuangxiu-zyg
	 * */
	public function article_yanfang(Request $request) {
		return json(Article::getListYanfang());
	}
    /**
     * 装修百科详情页
     */
    public function read(Request $request){
        $art_id = $request->param();
        return json(['code'=>0,'msg'=>'article/read','data'=>Article::read($art_id)]);
    }


}
