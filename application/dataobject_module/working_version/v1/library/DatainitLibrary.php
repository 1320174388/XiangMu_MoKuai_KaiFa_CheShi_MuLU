<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DatainitLibrary.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象自定义类
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\library;

class DatainitLibrary
{
    /**
     * 名  称 : datainitLibPost()
     * 功  能 : 初始化数据表函数类
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/23 09:09
     */
    public function datainitLibPost($post)
    {
        // TODO : 执行函数处理逻辑
        
        // TODO : 返回函数输出数据
        return \RSD::returnData('','',false);
    }
}