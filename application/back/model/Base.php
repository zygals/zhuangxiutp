<?php

namespace app\back\model;

use think\Model;

class Base extends model {
    public static function getPageStr($data,$page_str) {
        if(isset($data['page'])){
            unset($data['page']);
        }
        if(count($data)>0){

            $query_str = '';
            foreach($data as $k=>$v){
                $query_str.= $k.'='.$v.'&';
            }
            $page_str = preg_replace("/(page=)/im", $query_str.'page=', $page_str);
        }
        return $page_str;
    }
    protected static function getListCommon($data=[],$where = ['st' => ['<>', 0]]){
        $order = "create_time desc";
        if (!empty($data['name'])) {
            $where['name'] = ['like', '%' . $data['name'] . '%'];
        }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }
        $list_ = self::where($where)->order($order)->paginate();

        return $list_;
    }

    //wx
    public static function getById($id,$model,$field='*',$where=['st'=>1]){

        $row = $model->field($field)->where($where)->find($id);
        if(!$row){
           return [];
        }
        return $row;
    }

}