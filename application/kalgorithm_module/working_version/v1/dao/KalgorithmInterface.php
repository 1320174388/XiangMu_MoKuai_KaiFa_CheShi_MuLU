<?php
/**
 *  文件名称 :  KalgorithmInterface.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法_数据接口声明
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\dao;

interface KalgorithmInterface
{
    /**
     * 名  称 : kalgorithmSelect()
     * 功  能 : 声明:获取K匿名算法数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (Number) $get['k_number']          => 'K值';
     * 输  入 : (String) $get['identifier']        => '标识符';
     * 输  入 : (String) $get['quasi_identifier']  => '准标识符';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/10 11:07
     */
    public function kalgorithmSelect($get);
}