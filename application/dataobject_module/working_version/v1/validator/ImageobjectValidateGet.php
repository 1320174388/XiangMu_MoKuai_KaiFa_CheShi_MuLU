<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ImageobjectValidateGet.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象获取验证器
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\validator;
use think\Validate;

class ImageobjectValidateGet extends Validate
{
    /**
     * 名  称 : $rule
     * 功  能 : 验证规则
     * 输  入 : (String) $get['table_name']  => '数据表名';
     * 输  入 : (String) $get['json_limit']  => '分页字段';
     * 创  建 : 2018/12/04 09:42
     */
    protected $rule =   [
        'name'  => 'require|max:25',
        'age'   => 'number|between:1,120',
        'email' => 'email',
    ];

    /**
     * 名  称 : $message()
     * 功  能 : 设置验证信息
     * 创  建 : 2018/12/04 09:42
     */
    protected $message  =   [
        'name.require' => 'E10000',
        'name.max'     => 'E10001',
        'age.number'   => 'E10002',
        'age.between'  => 'E10001',
        'email'        => 'E10002',
    ];
}