<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DatainitController.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象控制器
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\controller;
use think\Controller;
use app\dataobject_module\working_version\v1\service\DatainitService;

class DatainitController extends Controller
{
    /**
     * 名  称 : datainitPost()
     * 功  能 : 初始化数据表接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['module_key']  => '模块秘钥';
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/11/23 09:09
     */
    public function datainitPost(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $datainitService = new DatainitService();
        
        // 获取传入参数
        $post = $request->post();
        
        // 执行Service逻辑
        $res = $datainitService->datainitAdd($post);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'S');
    }
}