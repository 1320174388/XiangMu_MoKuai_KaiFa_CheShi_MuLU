<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ModuleNameModel.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象模型层
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\model;
use think\Model;

class ModuleNameModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '';

    // 设置当前模型对应数据表的主键
    protected $pk = '主键';

    // 加载配置数据表名
    protected function initialize()
    {
        $this->table = config('dataobject_v1_tableName.数据表下标');
    }
}