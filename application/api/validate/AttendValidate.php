<?php
    namespace app\api\validate;
    use think\Validate;

    class AttendValidate extends Validate{
		protected $regex = [ 'mobile' => '^1[34587][0-9]\d{4,8}$'];
        protected $rule = [
            'activity_id'=>'require',
            'truename'=>'require',
            'mobile'=>'require|regex:mobile',
            'xiaoqu'=>'require',
             'username'=>'require',

        ];
        protected $message = [
            'truename.require'=>'真实姓名必须',
            'mobile.require'=>'手机号必须',
            'mobile.regex'=>'手机号不正确',
            'xiaoqu.require'=>'小区必须',
        ];
    }