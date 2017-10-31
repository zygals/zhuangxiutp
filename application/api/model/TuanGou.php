<?php
    namespace app\api\model;
    use app\back\model\Base;
    use think\Model;

    class TuanGou extends Base{
        protected $table = 'tuangou';

        /**
         * 查询正在进行的团购活动
         */
        public static function getGoon(){
            $field = 'tuangou.id t_id,good.id good_id,good.img_big good_img,good.name good_name';
            $where = ['tuangou.st'=>['=',1],'type'=>['=',2]];
            $list_ = self::where($where)->join('good','good.id=tuangou.good_id')->field($field)->select();
            return $list_;
        }

        /**
         * 查询历史的团购活动
         */
        public static function getHistory(){
            $field = 'good.id good_id,good.img good_img,good.name good_name,price_group,good.price good_price,tuangou.id';
            $where = ['tuangou.st'=>['=',3],'type'=>['=',2]];
            $list_ = self::where($where)->join('good','good.id=tuangou.good_id')->field($field)->paginate();
            return $list_;
        }

        /**
         * 获取限量团购商品列表
         */
        public static function getlist($data){
            $t_id = $data['t_id'];
            $field = 'tuangou.id t_id,img_big,good.price good_price,price_group,end_time,name,already_sales,which_info,desc,imgs';
            $list = self::where(['tuangou.id'=>$t_id])->join('good','good.id=tuangou.good_id')->field($field)->find();
            return $list;
        }

        /**
         * 获取正在进行限人团购活动
         */
        public static function getGoonPnum(){
            $field = 'tuangou.id t_id,good.img good_img,good.name good_name,price_group,pnum';
            $where = ['tuangou.st'=>['=',1],'type'=>['=',1]];
            $list_ = self::where($where)->join('good','good.id=tuangou.good_id')->field($field)->select();
            return $list_;
        }

        /**
         * 获取历史限人团购活动
         */
        public static function getHistoryPnum(){
            $field = 'tuangou.id t_id,good.img good_img,good.name good_name,price_group,pnum';
            $where = ['tuangou.st'=>['=',3],'type'=>['=',1]];
            $list_ = self::where($where)->join('good','good.id=tuangou.good_id')->field($field)->select();
            return $list_;
        }


        /**
         * 获取限人团购商品列表
         */
        public static function getPnumList($data){
            $t_id = $data['t_id'];
            $field = 'tuangou.id t_id,img_big,good.price good_price,price_group,end_time,name,pnum,attend_pnum,which_info,desc,imgs';
            $list = self::where(['tuangou.id'=>$t_id])->join('good','good.id=tuangou.good_id')->field($field)->find();
            return $list;
        }
    }