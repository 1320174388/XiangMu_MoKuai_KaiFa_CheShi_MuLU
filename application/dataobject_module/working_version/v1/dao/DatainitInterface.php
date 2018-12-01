<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DatainitInterface.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象_数据接口声明
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\dao;

interface DatainitInterface
{
    /**
     * 名  称 : datainitCreate()
     * 功  能 : 声明:初始化数据表数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/23 09:09
     */
    public function datainitCreate($post);
}