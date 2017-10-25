<?php
    namespace app\api\validate;
    use think\Validate;

    class AddressValidate extends Validate{
        protected $regex = [ 'mobile' => '^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\\d{8}$'];
        protected $rule = [
            'user_id'=>'require|number',
            'truename'=>'require',
            'mobile'=>'require|regex:mobile',
            'pcd'=>'require',
            'info'=>'require',
            'is_default'=>'require|number',
        ];
        protected $message = [
            'user_id.require'=>'用户id必须',
            'truename.require'=>'用户真实姓名必须',
            'mobile.require'=>'手机号必须',
            'pcd.require'=>'请选择省份城市县区',
            'info.require'=>'详细地址必须',
            'is_default.require'=>'默认地址必须'
        ];
    }