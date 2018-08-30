<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ProfitInterface.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 13:28
 *  文件描述 :  收益信息_数据接口声明
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\dao;

interface ProfitInterface
{
    /**
     * 名  称 : profitSelect()
     * 功  能 : 声明:收益信息操作数据处理
     * 变  量 : --------------------------------------
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/30 13:31
     */
    public function profitSelect($get);
}
