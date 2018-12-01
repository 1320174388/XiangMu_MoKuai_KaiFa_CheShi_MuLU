<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DataobjectLibrary.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象自定义类
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\library;

class DataobjectLibrary
{
    /**
     * 名  称 : dataobjectLibPost()
     * 功  能 : 添加数据函数类
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/22 22:15
     */
    public function dataobjectLibPost($post)
    {
        // TODO : 执行函数处理逻辑
        
        // TODO : 返回函数输出数据
        return \RSD::returnData('','',false);
    }

    /**
     * 名  称 : dataobjectLibGet()
     * 功  能 : 查询数据函数类
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['table_name']  => '数据表名';
     * 输  入 : (String) $get['json_field']  => '查询内容';
     * 输  入 : (String) $get['json_where']  => '查询条件';
     * 输  入 : (String) $get['json_order']  => '排序字段';
     * 输  入 : (String) $get['json_limit']  => '分页字段';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/30 19:45
     */
    public function dataobjectLibGet($get)
    {
        // TODO : 执行函数处理逻辑
        
        // TODO : 返回函数输出数据
        return \RSD::returnData('','',false);
    }

    /**
     * 名  称 : dataobjectLibPut()
     * 功  能 : 更新数据函数类
     * 变  量 : --------------------------------------
     * 输  入 : (String) $put['table_name']  => '数据表名';
     * 输  入 : (String) $put['json_obj_id'] => '对象ID';
     * 输  入 : (String) $put['json_object'] => '更新内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/01 14:13
     */
    public function dataobjectLibPut($put)
    {
        // TODO : 执行函数处理逻辑
        
        // TODO : 返回函数输出数据
        return \RSD::returnData('','',false);
    }

    /**
     * 名  称 : dataobjectLibDelete()
     * 功  能 : 删除数据函数类
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['table_name']  => '数据表名';
     * 输  入 : (String) $delete['json_obj_id'] => '对象ID';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/01 14:53
     */
    public function dataobjectLibDelete($delete)
    {
        // TODO : 执行函数处理逻辑
        
        // TODO : 返回函数输出数据
        return \RSD::returnData('','',false);
    }
}