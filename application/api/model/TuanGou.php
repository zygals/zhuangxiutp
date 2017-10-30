<?php
    namespace app\api\model;
    use app\back\model\Base;
    use think\Model;

    class Tuangou extends Base{
        /**
         * 查询正在进行的团购活动
         */
        public static function getGoon(){
            $field = 'good.id good_id,good.img good_img,good.name good_name,tuangou.id t_id';
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
            $list_ = self::where($where)->join('good','good.id=tuangou.good_id')->field($field)->select();
            return $list_;
        }

        /**
         * 获取团购商品列表
         */
        public static function getlist($data){
            $t_id = $data['t_id'];
            $field = 'tuangou.id t_id,img_big,good.price good_price,price_group,end_time,name,already_sales,which_info,desc,imgs';
            $list = self::where(['tuangou.id'=>$t_id])->join('good','good.id=tuangou.good_id')->field($field)->find();
            return $list;
        }
    }