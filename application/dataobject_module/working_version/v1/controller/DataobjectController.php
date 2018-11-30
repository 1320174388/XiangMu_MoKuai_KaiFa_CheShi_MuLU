<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DataobjectController.php
 *  开发人员 :  Feng Tian Shui
 *  联系电话 :  15731709183
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象控制器
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\controller;
use think\Controller;
use app\dataobject_module\working_version\v1\service\DataobjectService;

class DataobjectController extends Controller
{
    /**
     * 名  称 : dataobjectPost()
     * 功  能 : 添加数据接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/11/22 22:15
     */
    public function dataobjectPost(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $dataobjectService = new DataobjectService();
        
        // 获取传入参数
        $post = $request->post();
        
        // 执行Service逻辑
        $res = $dataobjectService->dataobjectAdd($post);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'S');
    }
}