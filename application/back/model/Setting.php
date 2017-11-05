<?php

namespace app\back\model;

use think\Model;

class Setting extends Base {


    public  function findSets() {

        $row_= self::where('id',1)->find();
        if(!$row_){
        $arr= [
                'nums_pro'=>12,
                'nums_pro_detail'=>10,
                'nums_new'=>3,

            ];
            $this->save($arr);
        }
        $row_= self::where('id',1)->find();
        return $row_;

    }

    public static function getMinBenefit(){
        $minBenefit = self::find();
        return $minBenefit['withdraw_limit'];
    }

    public static function  getSet(){
        $list = self::where('')->order('create_time asc')->find();
        return $list;
    }


}
