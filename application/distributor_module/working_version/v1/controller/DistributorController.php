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
use app\distributor_module\working_version\v1\library\DistributorLibrary;
class DistributorController extends Controller
{
    /**
     * 名  称 : distributorPost()
     * 功  能 : 创建分销员接口
     * 变  量 : --------------------------------------
     * 输  入 : (string) $user_token          => `用户token标识`
     * 输  入 : (string) $parent_token        => `上级token标识`
     * 输  入 : (string) $member_user         => `用户昵称`
     * 输  入 : (string) $member_image        => `用户头像图片路径`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/27 18:06
     */
    public function distributorPost(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $distributionService = new DistributorService();

        // 获取传入参数
        $post = $request->post();

        // 执行Service逻辑
        $res = $distributionService->distributorAdd($post);

        // 处理函数返回值
        return \RSD::wxReponse($res,'S','请求成功');
    }
    /**
     * 名  称 : promoterPost()
     * 功  能 : 注册推客员接口
     * 变  量 : --------------------------------------
     * 输  入 : (srting) $user_token          =>  `用户token`
     * 输  入 : (srting) $member_name         =>  `用户真实姓名`
     * 输  入 : (srting) $member_phone        =>  `用户手机号`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/30 13:06
     */
    public function promoterPost(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $promoterService = new DistributorService();

        // 获取传入参数
        $post = $request->post();

        // 执行Service逻辑
        $res = $promoterService->promoterAdd($post);

        // 处理函数返回值
        return \RSD::wxReponse($res,'S','请求成功');
    }
    /**
     * 名  称 : promoterPut()
     * 功  能 : 修改推客员信息接口
     * 变  量 : --------------------------------------
     * 输  入 : (srting) $user_token          =>  `用户token`
     * 输  入 : (srting) $member_name         =>  `用户真实姓名`
     * 输  入 : (srting) $member_phone        =>  `用户手机号`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/30 13:06
     */
    public function promoterPut(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $promoterService = new DistributorService();

        // 获取传入参数
        $put = $request->put();

        // 执行Service逻辑
        $res = $promoterService->promoterPut($put);

        // 处理函数返回值
        return \RSD::wxReponse($res,'S','请求成功');
    }
    /**
     * 名  称 : distributorGet()
     * 功  能 : 获取分销商数据接口
     * 变  量 : --------------------------------------
     * 输  入 : (srting) $user_token  =>  `用户token`
     * 输  入 : (srting) $type        =>  `获取分销商类型`
     * 输  入 : (int)    $num         =>  `分页页码`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/30 13:06
     */
    public function distributorGet(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $distributorService = new DistributorService();

        // 获取传入参数
        $get = $request->get();

        // 执行Service逻辑
        $res = $distributorService->distributorGet($get);

        // 处理函数返回值
        return \RSD::wxReponse($res,'S','请求成功');
    }
}