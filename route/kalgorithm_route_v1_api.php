<?php
/**
 *  文件名称 :  kalgorithm_route_v1_api.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法路由文件
 *  历史记录 :  -----------------------
 */

/**
 * 传值方式 : GET
 * 路由功能 : 获取K匿名算法数据
 */
Route::get(
    ':v/kalgorithm_module/kalgorithm_route',
    'kalgorithm_module/:v.controller.KalgorithmController/kalgorithmGet'
);

/**
 * 传值方式 : GET
 * 路由功能 : 获取标识符列表数据
 */
Route::get(
    ':v/kalgorithm_module/identifier_route',
    'kalgorithm_module/:v.controller.IdentifierController/identifierGet'
);
