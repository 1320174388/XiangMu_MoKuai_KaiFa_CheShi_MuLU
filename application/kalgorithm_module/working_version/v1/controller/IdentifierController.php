<?php
/**
 *  文件名称 :  IdentifierController.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法控制器
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\controller;
use think\Controller;
use app\kalgorithm_module\working_version\v1\service\IdentifierService;

class IdentifierController extends Controller
{
    /**
     * 名  称 : identifierGet()
     * 功  能 : 获取标识符列表数据接口
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : {"errCode":0,"retMsg":"请求成功","retData":"请求数据"}
     * 创  建 : 2018/12/10 22:14
     */
    public function identifierGet(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $identifierService = new IdentifierService();
        
        // 获取传入参数
        $get = $request->get();
        
        // 执行Service逻辑
        $res = $identifierService->identifierShow($get);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'S');
    }
}