<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  distributor_module_route.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/27 16:14
 *  文件描述 :  分销模块路由
 *  历史记录 :  -----------------------
 */

// ----- 分销成员路由 -----

/**
 * 传值方式 : POST
 * 路由功能 : 创建分销员接口
 */
Route::post(
    ':v/distributor_module/distributor_post',
    'distributor_module/:v.controller.DistributorController/distributorPost'
);
/**
 * 传值方式 : POST
 * 路由功能 : 注册推客员接口
 */
Route::post(
    ':v/distributor_module/promoter_post',
    'distributor_module/:v.controller.DistributorController/promoterPost'
);
/**
 * 传值方式 : PUT
 * 路由功能 : 修改推客员信息接口
 */
Route::put(
    ':v/distributor_module/promoter_put',
    'distributor_module/:v.controller.DistributorController/promoterPut'
);
/**
 * 传值方式 : GET
 * 路由功能 : 修改推客员信息接口
 */
Route::get(
    ':v/distributor_module/distributor_get',
    'distributor_module/:v.controller.DistributorController/distributorGet'
);


// ----- 订单接口路由 -----

/**
 * 传值方式 : GET
 * 路由功能 : 订单信息操作接口
 */
Route::get(
    ':v/distributor_module/order_route',
    'distributor_module/:v.controller.OrderController/orderGet'
);

// ----- 收益信息接口 -----

/**
 * 传值方式 : GET
 * 路由功能 : 收益信息操作
 */
Route::get(
    ':v/distributor_module/profit_route',
    'distributor_module/:v.controller.ProfitController/profitGet'
);

// ----- 提现信息接口 -----

/**
 * 传值方式 : GET
 * 路由功能 : 提现信息操作
 */
Route::get(
    ':v/distributor_module/putforward_route',
    'distributor_module/:v.controller.PutforwardController/putforwardGet'
);