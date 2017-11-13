<?php
    namespace app\api\model;
    use app\back\model\Base;
    use think\Model;
    use app\api\model\Article;

    class TuanGou extends Base{
        protected $table = 'tuangou';
		public function getGroupStAttr($groupalue){
			$status = [1 => '正在进行' , 2 => '活动成功'/* , 3 => '活动失败'*/];
			return $status[$groupalue];
		}
        /**
         * 查询正在进行的团购活动
         */
        public static function getGoon(){

            $field = 'tuangou.id t_id,good.id good_id,good.img_big good_img,good.name good_name,good.price,good.img';
            $where = ['tuangou.group_st'=>['=',1],'type'=>['=',2],'good.st'=>['=',1],'tuangou.st'=>1];

            $list_ = self::where($where)->join('good','good.id=tuangou.good_id')->field($field)->select();
            return $list_;
        }

        /**
         * 查询历史的团购活动
         */
        public static function getHistory(){
            $field = 'good.id good_id,good.img good_img,good.name good_name,price_group,good.price good_price,tuangou.id,article.id a_id';
            $where = ['tuangou.group_st'=>['=',2],'tuangou.type'=>['=',2],'article_st'=>['=',1]];
            $list_ = self::where($where)->join('good','good.id=tuangou.good_id')->join('article','article.tuangou_id=tuangou.id')->field($field)->paginate();
            return $list_;
        }

        /**
         * 获取限量团购商品列表
         */
        public static function getlist($data){
            $t_id = $data['t_id'];
            $field = 'tuangou.id t_id,img_big,good.price good_price,price_group,end_time,name,already_sales,which_info,desc,imgs,good.img,good.unit';
            $list = self::where(['tuangou.id'=>$t_id])->join('good','good.id=tuangou.good_id')->field($field)->find();
            return $list;
        }
        /**
         * 获取限量团购总结详情
         */
        public static function getArticle($data){
            $a_id = $data;;
            $list = Article::where(['id'=>$a_id])->find();
            return $list;
        }

        /**
         * 获取正在进行限人活动
         */
        public static function getGoonPnum(){
            $field = 'tuangou.id t_id,good.img good_img,good.name good_name,price_group,pnum';
            $where = ['type'=>['=',1],'good.st'=>1,'tuangou.st'=>1];
            $list_ = self::where($where)->join('good','good.id=tuangou.good_id')->field($field)->select();
            if($list_->isEmpty()){
                return ['code'=>__LINE__,'msg'=>'团购数据不存在'];
            }
            return ['code'=>0,'msg'=>'group/goon_pnum','data'=>$list_];
        }

        /**
         * 获取历史限人活动
         */
        public static function getHistoryPnum(){
            $field = 'tuangou.id t_id,good.img good_img,good.name good_name,price_group,pnum,article.id a_id';
            $where = [/*'tuangou.group_st'=>['=',2],*/'tuangou.type'=>['=',1],'article_st'=>['=',1]];
            $list_ = self::where($where)->join('good','good.id=tuangou.good_id')->join('article','article.tuangou_id=tuangou.id')->field($field)->select();
            if($list_->isEmpty()){
                return ['code'=>__LINE__,'msg'=>'历史团购数据不存在'];
            }
            return ['code'=>0,'msg'=>'group/history_pnum','data'=>$list_];
        }


        /**
         * 获取限人商品列表
		 * zyg gai
         */

        public static function getPnumList($t_id){

            $field = 'tuangou.id t_id,tuangou.group_st,good.price good_price,price_group,pnum,attend_pnum,which_info,desc,imgs,good.img,good.unit,good.name good_name,shop.name shop_name,tuangou.deposit,img_big_st,good.id good_id';
            $list = self::where(['tuangou.id'=>$t_id,'tuangou.st'=>1])->join('good','good.id=tuangou.good_id','left')->join('shop','shop.id=tuangou.shop_id','left')->field($field)->find();
            return $list;
        }

        /**
         * 获取多图
         */
        public static function getImg($data){
            $res = self::where(['id'=>$data])->field('good_id')->select();
            $good_id = $res[0]->good_id;
            $imgList = GoodImgBigs::getImg($good_id);
            return $imgList;
        }

        /**
         * 判断是否参加团购
         */
        public static function isAttend($data){
            $res = self::where(['shop_id'=> $data])->find();
            if(!$res){
                return ['code'=>__LINE__,'msg'=>'没参加团购','data'=>'0'];
            }
            return ['code'=>0,'msg'=>'参加团购','data'=>'1'];
        }

    }