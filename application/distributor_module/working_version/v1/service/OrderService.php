<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderService.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 10:06
 *  文件描述 :  分销订单逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\service;
use app\distributor_module\working_version\v1\dao\OrderDao;
use app\distributor_module\working_version\v1\library\OrderLibrary;
use app\distributor_module\working_version\v1\validator\OrderValidate;

class OrderService
{
    /**
     * 名  称 : orderShow()
     * 功  能 : 订单信息操作接口逻辑
     * 变  量 : --------------------------------------
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识
     * 输  入 : $get['OrderType'] => 'OrderType = 0;  获取所有订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = 1;  获取以结算订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = 2;  获取未结算订单信息';';
     * 输  入 : $get['OrderNumb'] => '现已获取到的订单数量，没有输入0';
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/30 10:04
     */
    public function orderShow($get)
    {
        // 实例化验证器代码
        $validate  = new OrderValidate();

        // 验证数据
        if (!$validate->scene('edit')->check($get)) {
            return ['msg'=>'error','data'=>$validate->getError()];
        }

        // 验证订单类型是否正确
        if(
            ($get['OrderType'] != '0') &&
            ($get['OrderType'] != '1') &&
            ($get['OrderType'] != '2')
        ){
            return ['msg'=>'error','data'=>'请正确发送订单获取状态'];
        }

        // 实例化Dao层数据类
        $orderDao = new OrderDao();

        // 执行Dao层逻辑
        $res = $orderDao->orderSelect($get);

        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }
}
