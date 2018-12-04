<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ImageobjectLibrary.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象自定义类
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\library;

class ImageobjectLibrary
{
    /**
     * 名  称 : imageobjectLibPost()
     * 功  能 : 添加图片函数类
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']    => '数据表名';
     * 输  入 : (String) $post['picture_data']  => '图片数据';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/03 20:00
     */
    public function imageobjectLibPost($post)
    {
        // TODO : 执行函数处理逻辑
        
        // TODO : 返回函数输出数据
        return \RSD::returnData('','',false);
    }

    /**
     * 名  称 : imageobjectLibGet()
     * 功  能 : 获取图片函数类
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['table_name']  => '数据表名';
     * 输  入 : (String) $get['json_limit']  => '分页字段';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/04 09:42
     */
    public function imageobjectLibGet($get)
    {
        // TODO : 执行函数处理逻辑
        
        // TODO : 返回函数输出数据
        return \RSD::returnData('','',false);
    }

    /**
     * 名  称 : imageobjectLibDelete()
     * 功  能 : 删除图片函数类
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['table_name'] => '数据表名';
     * 输  入 : (String) $delete['images_id']  => '图片ID';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/04 09:53
     */
    public function imageobjectLibDelete($delete)
    {
        // TODO : 执行函数处理逻辑
        
        // TODO : 返回函数输出数据
        return \RSD::returnData('','',false);
    }
}