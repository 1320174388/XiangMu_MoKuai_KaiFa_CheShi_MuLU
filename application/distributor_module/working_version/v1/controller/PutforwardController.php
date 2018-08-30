<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  PutforwardController.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 14:57
 *  文件描述 :  提现信息控制器
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\controller;
use think\Controller;
use app\distributor_module\working_version\v1\service\PutforwardService;

class PutforwardController extends Controller
{
    /**
     * 名  称 : putforwardGet()
     * 功  能 : 提现信息操作接口
     * 变  量 : --------------------------------------
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  入 : $get['DataNumbE'] => '现已获取到的信息数量，没有输入0';
     * 输  出 : {"errNum":0,"retMsg":"请求成功","retData":"请求数据"}
     * 创  建 : 2018/08/30 15:08
     */
    public function putforwardGet(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $putforwardService = new PutforwardService();

        // 获取传入参数
        $get = $request->get();

        // 执行Service逻辑
        $res = $putforwardService->putforwardShow($get);

        // 处理函数返回值
        return \RSD::wxReponse($res,'S','请求成功');
    }
}
