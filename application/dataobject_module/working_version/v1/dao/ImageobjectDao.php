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
        // TODO : 实例化数据模型
        $imageObject = new ImageobjectModel();
        // TODO : 配置模型表名
        $imageObject->setTableName($post['table_name']);
        // TODO : 执行写入数据
        try{
            $imageObject->image_url  = $post['picture_data'];
            $imageObject->image_time = time();
            $imageObject->save();
        }catch (\Exception $e){
            return \RSD::returnModel(
                false,'E10002.$post[\'picture_data\'] Parameter Formatting Error'
            );
        }
        // 处理函数返回值
        return \RSD::returnModel(true,'E10002');
    }

    /**
     * 名  称 : imageobjectSelect()
     * 功  能 : 获取图片数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['table_name']  => '数据表名';
     * 输  入 : (String) $get['json_limit']  => '分页字段';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/04 09:42
     */
    public function imageobjectSelect($get)
    {
        // TODO :  ImageobjectModel 模型
        
        // 处理函数返回值
        return \RSD::returnModel(true,'E40000','请求成功','请求失败');
    }
}