<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderController.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 10:06
 *  文件描述 :  分销订单控制器
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\controller;
use think\Controller;
use app\distributor_module\working_version\v1\service\OrderService;

class OrderController extends Controller
{
// ------ Controller控制器接代码 ------

    /**
     * 名  称 : orderGet()
     * 功  能 : 订单信息操作接口接口
     * 变  量 : --------------------------------------
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  入 : $get['OrderType'] => 'OrderType = no;     获取所有订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = true;   获取以结算订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = false;  获取未结算订单信息';
     * 输  入 : $get['OrderNumb'] => '现已获取到的订单数量，没有输入0';
     * 输  出 : {"errNum":0,"retMsg":"请求成功","retData":"请求数据"}
     * 创  建 : 2018/08/30 10:04
     */
    public function orderGet(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $orderService = new OrderService();

        // 获取传入参数
        $get = $request->get();

        // 执行Service逻辑
        $res = $orderService->orderShow($get);

        // 处理函数返回值
        return \RSD::wxReponse($res,'S','请求成功');
    }
}
