<?php
    namespace app\api\validate;
    use think\Validate;

    class ShopValidate extends Validate{
        protected $rule = [
            'shop_id' => 'require|number',
        ];

        protected $message = [
            'shop_id.require' => 'shop_id 必须',
        ];
    }