<?php
/**
 *  文件名称 :  KalgorithmModel.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法模型层
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\model;
use think\Model;

class KalgorithmModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '';

    // 设置当前模型对应数据表的主键
    protected $pk = 'id';

    // 加载配置数据表名
    protected function initialize()
    {
        $this->table = config('kalgorithm_v1_tableName.LicensePlate');
    }
}