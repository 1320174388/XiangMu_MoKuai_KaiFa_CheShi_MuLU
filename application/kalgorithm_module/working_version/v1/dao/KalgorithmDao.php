<?php
/**
 *  文件名称 :  KalgorithmDao.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法数据层
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\dao;
use app\kalgorithm_module\working_version\v1\model\KalgorithmModel;

class KalgorithmDao implements KalgorithmInterface
{

    /**
     * 名  称 : kalgorithmSelect()
     * 功  能 : 获取K匿名算法数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (Number) $get['k_number']          => 'K值';
     * 输  入 : (String) $get['identifier']        => '标识符';
     * 输  入 : (String) $get['quasi_identifier']  => '准标识符';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/10 11:07
     */
    public function kalgorithmSelect($get)
    {
        // TODO : 获取数据
        $dataArr = $this->dataSelect();
        
        // TODO : 返回数据
        return \RSD::returnModel(
            $dataArr,'E40000','请求成功','请求失败'
        );
    }

    /**
     * 名  称 : dataSelect()
     * 功  能 : 获取数据库数据
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : $arr => '汽车数据'
     * 创  建 : 2018/12/13 09:58
     */
    private function dataSelect()
    {
        return KalgorithmModel::field(
            config('kalgorithm_v1_tableName.LicensePlate') . '.plate_number,' .
            config('kalgorithm_v1_tableName.LicensePlate') . '.plate_type,' .
            config('kalgorithm_v1_tableName.LicensePlate') . '.issuing_unit,' .
            config('kalgorithm_v1_tableName.LicensePlate') . '.payment_time,' .
            config('kalgorithm_v1_tableName.LicensePlate') . '.license_number,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.license_name,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.license_type,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.license_color,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.production_plant,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.displacement,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.id_number,' .
            config('kalgorithm_v1_tableName.Customers') . '.user_name,' .
            config('kalgorithm_v1_tableName.Customers') . '.user_sex,' .
            config('kalgorithm_v1_tableName.Customers') . '.user_phone,' .
            config('kalgorithm_v1_tableName.Customers') . '.user_address'
        )->leftJoin(
            config('kalgorithm_v1_tableName.Vehicle'),
            config('kalgorithm_v1_tableName.LicensePlate').'.license_number = '.
            config('kalgorithm_v1_tableName.Vehicle').'.license_number'
        )->leftJoin(
            config('kalgorithm_v1_tableName.Customers'),
            config('kalgorithm_v1_tableName.Vehicle').'.id_number = '.
            config('kalgorithm_v1_tableName.Customers').'.id_number'
        )->select()->toArray();
    }
}