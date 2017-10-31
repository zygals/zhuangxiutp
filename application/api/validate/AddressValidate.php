<?php
    namespace app\api\validate;
    use think\Validate;

    class AddressValidate extends Validate{
		protected $regex = [ 'mobile' => '^1[34587][0-9]\d{4,8}$'];
        protected $rule = [
            'truename'=>'require',
            'mobile'=>'require|regex:mobile',
            'pcd'=>'require',
             'username'=>'require',
            'is_default'=>'boolean',
        ];
        protected $message = [
            'truename.require'=>'用户真实姓名必须',
            'mobile.require'=>'手机号必须',
            'pcd.require'=>'请选择省份城市县区',

            'is_default.boolean'=>'默认地址类型不对'
        ];
    }