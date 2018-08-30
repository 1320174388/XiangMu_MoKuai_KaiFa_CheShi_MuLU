<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderValidator.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 10:06
 *  文件描述 :  分销订单验证器
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\validator;
use think\Validate;

class OrderValidate extends Validate
{
    /**
     * 名  称 : $rule
     * 功  能 : 验证规则
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  入 : $get['OrderType'] => 'OrderType = 0;  获取所有订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = 1;  获取以结算订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = 2;  获取未结算订单信息';
     * 输  入 : $get['OrderNumb'] => '现已获取到的订单数量，没有输入0';
     * 创  建 : 2018/08/30 10:04
     */
    protected $rule =   [
        'UserToken' => 'require|min:32|max:32',
        'OrderType' => 'require|number',
        'OrderNumb' => 'require|number',
    ];

    /**
     * 名  称 : $message()
     * 功  能 : 设置验证信息
     * 创  建 : 2018/08/30 10:04
     */
    protected $message  =   [
        'UserToken.require' => '请正确发送用户身份标识',
        'UserToken.min'     => '请正确发送用户身份标识',
        'UserToken.max'     => '请正确发送用户身份标识',
        'OrderType.require' => '请正确发送订单获取状态',
        'OrderType.number'  => '请正确发送订单获取状态',
        'OrderNumb.require' => '请正确发送现有订单数量',
        'OrderNumb.number'  => '请正确发送现有订单数量',
    ];
}
