<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DataobjectDao.php
 *  开发人员 :  Feng Tian Shui
 *  联系电话 :  15731709183
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象数据层
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\dao;
use app\dataobject_module\working_version\v1\model\DataobjectModel;

class DataobjectDao implements DataobjectInterface
{
    /**
     * 名  称 : dataobjectCreate()
     * 功  能 : 添加数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/22 22:15
     */
    public function dataobjectCreate($post)
    {
        // TODO : 实例化数据模型
        $dataObject = new DataobjectModel();
        // TODO : 配置模型表名
        $dataObject->setTableName($post['table_name']);
        // TODO : 执行写入数据
        try{
            $dataObject->save($post['json_object']);
        }catch (\Exception $e){
            return \RSD::returnModel(
                false,'E10002.[json_object] Parameter Formatting Error'
            );
        }
        // 处理函数返回值
        return \RSD::returnModel(true,'E10002');
    }
}