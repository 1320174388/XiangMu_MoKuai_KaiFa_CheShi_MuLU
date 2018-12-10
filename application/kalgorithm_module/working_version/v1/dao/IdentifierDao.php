<?php
/**
 *  文件名称 :  IdentifierDao.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法数据层
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\dao;
use app\kalgorithm_module\working_version\v1\model\IdentifierModel;

class IdentifierDao implements IdentifierInterface
{
    /**
     * 名  称 : identifierSelect()
     * 功  能 : 获取标识符列表数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/10 22:14
     */
    public function identifierSelect($get)
    {
        // TODO : 标识符信息
        $lists = config('kalgorithm_v1_config.identifier');

        // 处理函数返回值
        return \RSD::returnModel($lists,'E40000','请求成功','请求失败');
    }
}