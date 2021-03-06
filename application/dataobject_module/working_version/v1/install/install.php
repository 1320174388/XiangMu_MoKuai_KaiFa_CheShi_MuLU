<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  install.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/15 20:27
 *  文件描述 :  Wx_小程序：执行函数生成类
 *  历史记录 :  -----------------------
 */
include('./library/Function_Create_Library.php');

Function_Create_Library::execCreateFunction([
    // 传值类型 : (GET/POST/PUT/DELETE)
    'dataType' => 'DELETE',
    // 函数名称 : 默认 __function
    'name'     => 'imageobject',
    // 函数说明 : 默认 新创建函数
    'explain'  => '删除图片',
    // 函数输入 : 示例 [
    //  '$get['UserName']  => '用户名称';',
    //]
    'input'    => [
//        '(String) $post[\'module_key\']  => \'模块秘钥\';',
        '(String) $delete[\'table_name\'] => \'数据表名\';',
//        '(String) $get[\'picture_data\']  => \'图片数据\';',
//        '(String) $post[\'json_field\']  => \'查询内容\';',
        '(String) $delete[\'images_id\']  => \'图片ID\';',
//        '(String) $post[\'json_object\'] => \'更新内容\';',
//        '(String) $post[\'json_order\']  => \'排序字段\';',
//        '(String) $get[\'json_limit\']  => \'分页字段\';'
    ],
]);
