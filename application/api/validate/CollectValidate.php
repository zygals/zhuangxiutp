<?php
namespace app\api\validate;

use think\Validate;

class CollectValidate extends Validate{
    protected $rule = [
        'username' =>  'require',

        //'desc' =>  'require',


    ];
    protected $message  =   [
        'username.require' => '名称必须',

        //'desc'   => '描述必须',


    ];
    protected $scene = [


    ];

}