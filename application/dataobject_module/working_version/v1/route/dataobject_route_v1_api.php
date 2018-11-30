<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  dataobject_route_v1_api.php
 *  开发人员 :  Feng Tian Shui
 *  联系电话 :  15731709183
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象路由文件
 *  历史记录 :  -----------------------
 */

/**
 * 传值方式 : POST
 * 路由功能 : 初始化数据表
 */
Route::post(
    ':v/dataobject_module/datainit_route',
    'dataobject_module/:v.controller.DatainitController/datainitPost'
);

/**
 * 传值方式 : POST
 * 路由功能 : 添加数据
 */
Route::post(
    ':v/dataobject_module/dataobject_route',
    'dataobject_module/:v.controller.DataobjectController/dataobjectPost'
);

/**
 * 传值方式 : GET
 * 路由功能 : 查询数据
 */
Route::get(
    ':v/dataobject_module/dataobject_route',
    'dataobject_module/:v.controller.DataobjectController/dataobjectGet'
);
