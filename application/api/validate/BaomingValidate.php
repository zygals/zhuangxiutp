<?php
    namespace app\api\validate;
    use think\Validate;

    class BaomingValidate extends Validate{
		protected $regex = [ 'mobile' => '^1[34587][0-9]\d{4,8}$'];
        protected $rule = [
            'username'=>'require',
            'truename'=>'require',
            'mobile'=>'require|regex:mobile',
           // 'address'=>'require',
             'username'=>'require',
           // 'time_to'=>'date',
        ];
        protected $message = [

        ];
    }