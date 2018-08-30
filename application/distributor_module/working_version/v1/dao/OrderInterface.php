<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderInterface.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 10:06
 *  文件描述 :  分销订单_数据接口声明
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\dao;

interface OrderInterface
{
    /**
     * 名  称 : orderSelect()
     * 功  能 : 声明:订单信息操作接口数据处理
     * 变  量 : --------------------------------------
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  入 : $get['OrderType'] => 'OrderType = 0;  获取所有订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = 1;  获取以结算订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = 2;  获取未结算订单信息';
     * 输  入 : $get['OrderNumb'] => '现已获取到的订单数量，没有输入0';
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/30 10:04
     */
    public function orderSelect($get);

    /**
     * 名  称 : orderCreate()
     * 功  能 : 声明:添加订单数据处理
     * 变  量 : --------------------------------------
     * 输  入 : $post['OrderNumber'] => '订单OrderNumber编号';
     * 输  入 : $post['UserToken']   => '买家UserToken身份标识;
     * 输  入 : $post['JsonBuyer']   => '买家JSON数据，不需要则发送无用JSON格式数据;
     * 输  入 : $post['JsonSeller']  => '卖家JSON数据，不需要则发送无用JSON格式数据
     * 输  入 : $post['JsonOrder']   => '订单JSON数据，不需要则发送无用JSON格式数据
     * 输  入 : $post['ProfitPrice'] => '分销商ProfitPrice收益金额
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/31 01:24
     */
    public function orderCreate($post);
}
