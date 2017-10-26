<?php
    namespace app\api\validate;
    use think\Validate;

    class AddressValidate extends Validate{
        protected $regex = [ 'mobile' => '^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\\d{8}$'];
        protected $rule = [
            'truename'=>'require',
            'mobile'=>'require|regex:mobile',
            'pcd'=>'require',
             'username'=>'require',
            'is_default'=>'require|boolean',
        ];
        protected $message = [
            'truename.require'=>'用户真实姓名必须',
            'mobile.require'=>'手机号必须',
            'pcd.require'=>'请选择省份城市县区',

            'is_default.require'=>'默认地址必须'
        ];
    }