<?php

namespace app\api\model;

use think\Model;

class Setting extends model {


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


}
