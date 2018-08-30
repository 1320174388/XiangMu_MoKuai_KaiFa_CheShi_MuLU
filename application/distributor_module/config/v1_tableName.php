<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  v1_tableName.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/29 21:08
 *  文件描述 :  分销模块_v1_版本数据表配置文件
 *  历史记录 :  -----------------------
 */

return [
    // 分销模块表
    'distribution_module' => [
        // 分销成员表
        'distribution'     => 'data_distribution_members',
        // 分销订单表
        'OrderTables'      => 'data_distribution_orders',
        // 收益信息表
        'ProfitTables'     => 'data_distribution_profit',
        // 分销提现表
        'PutforwardTables' => 'data_distribution_putforward',
    ]

];
