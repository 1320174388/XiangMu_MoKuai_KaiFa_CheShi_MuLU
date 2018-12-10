<?php
/**
 *  文件名称 :  KalgorithmController.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法控制器
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\controller;
use think\Controller;
use app\kalgorithm_module\working_version\v1\service\KalgorithmService;

class KalgorithmController extends Controller
{
    /**
     * 名  称 : kalgorithmGet()
     * 功  能 : 获取K匿名算法数据接口
     * 变  量 : --------------------------------------
     * 输  入 : (Number) $get['k_number']          => 'K值';
     * 输  入 : (String) $get['identifier']        => '标识符';
     * 输  入 : (String) $get['quasi_identifier']  => '准标识符';
     * 输  出 : {"errCode":0,"retMsg":"请求成功","retData":"请求数据"}
     * 创  建 : 2018/12/10 11:07
     */
    public function kalgorithmGet(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $kalgorithmService = new KalgorithmService();
        
        // 获取传入参数
        $get = $request->get();
        
        // 执行Service逻辑
        $res = $kalgorithmService->kalgorithmShow($get);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'S');
    }
}