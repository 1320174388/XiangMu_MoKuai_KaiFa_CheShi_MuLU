<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  distributor_module_route.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/27 16:14
 *  文件描述 :  分销模块路由
 *  历史记录 :  -----------------------
 */
/**
 * 传值方式 : POST
 * 路由功能 : 创建分销员接口
 */
Route::post(
    ':v/distributor_module/distributor_route',
    'distributor_module/:v.controller.DistributorController/distributorPost'
);

