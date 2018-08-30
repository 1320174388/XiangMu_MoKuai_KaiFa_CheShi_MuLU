<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  PutforwardValidator.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 14:57
 *  文件描述 :  提现信息验证器
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\validator;
use think\Validate;

class PutforwardValidate extends Validate
{
    /**
     * 名  称 : $rule
     * 功  能 : 验证规则
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  入 : $get['DataNumbE'] => '现已获取到的信息数量，没有输入0';
     * 创  建 : 2018/08/30 15:08
     */
    protected $rule =   [
        'UserToken' => 'require|min:32|max:32',
        'DataNumbE' => 'require|number',
    ];

    /**
     * 名  称 : $message()
     * 功  能 : 设置验证信息
     * 创  建 : 2018/08/30 15:08
     */
    protected $message  =   [
        'UserToken.require' => '请正确发送用户身份标识',
        'UserToken.min'     => '请正确发送用户身份标识',
        'UserToken.max'     => '请正确发送用户身份标识',
        'DataNumbE.require' => '请正确发送现有提现数量',
        'DataNumbE.number'  => '请正确发送现有提现数量',
    ];
}
