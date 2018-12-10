<?php
/**
 *  文件名称 :  KalgorithmValidateGet.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法获取验证器
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\validator;
use think\Validate;

class KalgorithmValidateGet extends Validate
{
    /**
     * 名  称 : $rule
     * 功  能 : 验证规则
     * 输  入 : (Number) $get['k_number']          => 'K值';
     * 输  入 : (String) $get['identifier']        => '标识符';
     * 输  入 : (String) $get['quasi_identifier']  => '准标识符';
     * 创  建 : 2018/12/10 11:07
     */
    protected $rule =   [
        'k_number'         => 'require|number',
    ];

    /**
     * 名  称 : $message()
     * 功  能 : 设置验证信息
     * 创  建 : 2018/12/10 11:07
     */
    protected $message  =   [
        'k_number.require'          => 'E10000.k_number input error',
        'k_number.number'           => 'E10002.k_number input error',
    ];
}