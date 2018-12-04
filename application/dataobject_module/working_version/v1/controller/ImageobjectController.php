<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ImageobjectController.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象控制器
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\controller;
use think\Controller;
use app\dataobject_module\working_version\v1\service\ImageobjectService;

class ImageobjectController extends Controller
{
    /**
     * 名  称 : imageobjectPost()
     * 功  能 : 添加图片接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']    => '数据表名';
     * 输  入 : (String) $post['picture_data']  => '图片数据';
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/12/03 20:00
     */
    public function imageobjectPost(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $imageobjectService = new ImageobjectService();
        
        // 获取传入参数
        $post = $request->post();
        
        // 执行Service逻辑
        $res = $imageobjectService->imageobjectAdd($post);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'S');
    }

    /**
     * 名  称 : imageobjectGet()
     * 功  能 : 获取图片接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['table_name']  => '数据表名';
     * 输  入 : (String) $get['json_limit']  => '分页字段';
     * 输  出 : {"errNum":0,"retMsg":"请求成功","retData":"请求数据"}
     * 创  建 : 2018/12/04 09:42
     */
    public function imageobjectGet(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $imageobjectService = new ImageobjectService();
        
        // 获取传入参数
        $get = $request->get();
        
        // 执行Service逻辑
        $res = $imageobjectService->imageobjectShow($get);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'S');
    }

    /**
     * 名  称 : imageobjectDelete()
     * 功  能 : 删除图片接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['table_name'] => '数据表名';
     * 输  入 : (String) $delete['images_id']  => '图片ID';
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/12/04 09:53
     */
    public function imageobjectDelete(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $imageobjectService = new ImageobjectService();
        
        // 获取传入参数
        $delete = $request->delete();
        
        // 执行Service逻辑
        $res = $imageobjectService->imageobjectDel($delete);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'S');
    }
}