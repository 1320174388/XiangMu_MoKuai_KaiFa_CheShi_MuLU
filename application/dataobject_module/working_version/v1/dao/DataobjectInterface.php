<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DataobjectInterface.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象_数据接口声明
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\dao;

interface DataobjectInterface
{
    /**
     * 名  称 : dataobjectCreate()
     * 功  能 : 声明:添加数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/22 22:15
     */
    public function dataobjectCreate($post);

    /**
     * 名  称 : dataobjectSelect()
     * 功  能 : 声明:查询数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['table_name']  => '数据表名';
     * 输  入 : (String) $get['json_field']  => '查询内容';
     * 输  入 : (String) $get['json_where']  => '查询条件';
     * 输  入 : (String) $get['json_order']  => '排序字段';
     * 输  入 : (String) $get['json_limit']  => '分页字段';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/30 19:45
     */
    public function dataobjectSelect($get);

    /**
     * 名  称 : dataobjectUpdate()
     * 功  能 : 声明:更新数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $put['table_name']  => '数据表名';
     * 输  入 : (String) $put['json_obj_id'] => '对象ID';
     * 输  入 : (String) $put['json_object'] => '更新内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/01 14:13
     */
    public function dataobjectUpdate($put);

    /**
     * 名  称 : dataobjectDelete()
     * 功  能 : 声明:删除数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['table_name']  => '数据表名';
     * 输  入 : (String) $delete['json_obj_id'] => '对象ID';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/01 14:53
     */
    public function dataobjectDelete($delete);
}