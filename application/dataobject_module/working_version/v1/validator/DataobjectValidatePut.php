<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DataobjectValidatePut.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象修改验证器
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\validator;
use think\Validate;

class DataobjectValidatePut extends Validate
{
    /**
     * 名  称 : $rule
     * 功  能 : 验证规则
     * 输  入 : (String) $put['table_name']  => '数据表名';
     * 输  入 : (String) $put['json_obj_id'] => '对象ID';
     * 输  入 : (String) $put['json_object'] => '更新内容';
     * 创  建 : 2018/12/01 14:13
     */
    protected $rule =   [
        'table_name'  => 'require|min:1|max:32|alphaDash',
        'json_obj_id' => 'require|number',
        'json_object' => 'require|min:1|max:8000',
    ];

    /**
     * 名  称 : $message()
     * 功  能 : 设置验证信息
     * 创  建 : 2018/12/01 14:13
     */
    protected $message  =   [
        'table_name.require'  => 'E10000.table_name Invalid parameter',
        'table_name.min'      => 'E10000.table_name Invalid parameter',
        'table_name.max'      => 'E10001.table_name Parameter Beyond The Scope',
        'table_name.alphaDash'=> 'E10002.table_name Parameter Formatting Error',
        'json_obj_id.require' => 'E10000.json_obj_id Parameter Formatting Error',
        'json_obj_id.number'  => 'E10002.json_obj_id Parameter Formatting Error',
        'json_object.require' => 'E10000.json_object Invalid parameter',
        'json_object.min'     => 'E10000.json_object Invalid parameter',
        'json_object.max'     => 'E10001.json_object Parameter Beyond The Scope',
    ];
}