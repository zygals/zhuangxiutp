<?php

namespace app\back\model;

use think\Model;
use app\back\model\Good;

class GoodAttr extends model {

    public function saveGoodAttr($data) {
        $good_id = $data['good_id'];
        $attr_value = $data['attr_value'];
        //添加属性前，将所有以前的删除
        $list_value = $this->where(['good_id'=>$good_id])->select();
        //dump($list_value);exit;
        foreach($list_value as $k=>$row_){
            $list_value[$k]->st = 0;
            $list_value[$k]->save();
        }
        $data_insert = [];
        $data_insert['good_id'] = $good_id;
        $data_insert['st'] = 1;
        $all = true;
        foreach ($attr_value as $k => $v) { //$k= 1,$v= L级
            $data_insert['attr_id'] = $k;
            $data_insert['value'] = $v;
            if(!$this->insert($data_insert)){
                $all=false;
            }
        }
        if($all){
            (new Good())->updateAddAttr($good_id);
        }
        return $all;

    }
    public function getGoodAttr($good_id){
        return $this->alias('ga')->where(['good_id'=>$good_id,'ga.st'=>1,'value'=>['<>','']])->join('attr','ga.attr_id=attr.id')->field('ga.*,attr.name attr_name')->select();
    }


}
