<?php
/**
 *  文件名称 :  KalgorithmService.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\service;
use app\kalgorithm_module\working_version\v1\dao\KalgorithmDao;
use app\kalgorithm_module\working_version\v1\library\KalgorithmLibrary;
use app\kalgorithm_module\working_version\v1\validator\KalgorithmValidatePost;
use app\kalgorithm_module\working_version\v1\validator\KalgorithmValidateGet;
use app\kalgorithm_module\working_version\v1\validator\KalgorithmValidatePut;
use app\kalgorithm_module\working_version\v1\validator\KalgorithmValidateDelete;

class KalgorithmService
{
    /**
     * 名  称 : kalgorithmShow()
     * 功  能 : 获取K匿名算法数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (Number) $get['k_number']          => 'K值';
     * 输  入 : (String) $get['identifier']        => '标识符';
     * 输  入 : (String) $get['quasi_identifier']  => '准标识符';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/10 11:07
     */
    public function kalgorithmShow($get)
    {
        // 实例化验证器代码
        $validate  = new KalgorithmValidateGet();
        
        // 验证数据
        if (!$validate->scene('edit')->check($get)) {
            return \RSD::returnData($validate->getError(),'',false);
        }
        
        // 实例化Dao层数据类
        $kalgorithmDao = new KalgorithmDao();
        
        // 执行Dao层逻辑
        $res = $kalgorithmDao->kalgorithmSelect($get);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }
}