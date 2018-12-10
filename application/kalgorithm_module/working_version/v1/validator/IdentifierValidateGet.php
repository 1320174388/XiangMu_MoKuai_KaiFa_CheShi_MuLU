<?php
/**
 *  文件名称 :  IdentifierValidateGet.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法获取验证器
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\validator;
use think\Validate;

class IdentifierValidateGet extends Validate
{
    /**
     * 名  称 : $rule
     * 功  能 : 验证规则
     * 输  入 : --------------------------------------
     * 创  建 : 2018/12/10 22:14
     */
    protected $rule =   [
//        'name'  => 'require|max:25',
//        'age'   => 'number|between:1,120',
//        'email' => 'email',
    ];

    /**
     * 名  称 : $message()
     * 功  能 : 设置验证信息
     * 创  建 : 2018/12/10 22:14
     */
    protected $message  =   [
//        'name.require' => 'E10000',
//        'name.max'     => 'E10001',
//        'age.number'   => 'E10002',
//        'age.between'  => 'E10001',
//        'email'        => 'E10002',
    ];
}