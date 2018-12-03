<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ImageobjectDao.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象数据层
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\dao;
use app\dataobject_module\working_version\v1\model\ImageobjectModel;

class ImageobjectDao implements ImageobjectInterface
{
    /**
     * 名  称 : imageobjectCreate()
     * 功  能 : 添加图片数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']    => '数据表名';
     * 输  入 : (String) $post['picture_data']  => '图片数据';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/03 20:00
     */
    public function imageobjectCreate($post)
    {
        // TODO :  ImageobjectModel 模型
        
        // 处理函数返回值
        return \RSD::returnModel(true,'E40000','请求成功','请求失败');
    }
}