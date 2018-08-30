<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  v1_config.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/29 21:08
 *  文件描述 :  分销模块_v1_版本配置文件
 *  历史记录 :  -----------------------
 */

return [
    // 小程序 Wx_AppId
    'Wx_AppId'     => 'wx6516385261fa963a',
    // 小程序秘钥  Wx_AppSecret
    'Wx_AppSecret' => 'dc9823245780a506e679a121bb535e0b',
    // 三级分销模块，比例
    'distribution_module' => [
        // 以及分销商抽成比例
        'class1price' => 0.5,
        'class2price' => 0.3,
        'class3price' => 0.2,
    ]
];
