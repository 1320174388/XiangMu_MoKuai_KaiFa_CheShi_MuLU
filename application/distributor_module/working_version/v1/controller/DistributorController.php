<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DistributorController.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/29 21:08
 *  文件描述 :  分销模块控制器
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\controller;
use think\Controller;
use app\distributor_module\working_version\v1\service\DistributorService;

class DistributorController extends Controller
{
    /**
     * 名  称 : distributionPost()
     * 功  能 : 创建分销员接口
     * 变  量 : --------------------------------------
     * 输  入 : (string) $userToken       => `用户token标识`
     * 输  入 : (string) $parentToken     => `上级token标识`
     * 输  入 : (string) $userName        => `用户昵称`
     * 输  入 : (string) $userImage       => `用户头像图片路径`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/27 18:06
     */
    public function distributionPost(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $distributionService = new DistributorService();

        // 获取传入参数
        $post = $request->post();

        // 执行Service逻辑
        $res = $distributionService->distributionAdd($post);

        // 处理函数返回值
        return \RSD::wxReponse($res,'S','');
    }
}
