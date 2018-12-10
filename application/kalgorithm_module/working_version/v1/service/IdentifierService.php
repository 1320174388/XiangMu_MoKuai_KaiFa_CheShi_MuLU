<?php
/**
 *  文件名称 :  IdentifierService.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\service;
use app\kalgorithm_module\working_version\v1\dao\IdentifierDao;
use app\kalgorithm_module\working_version\v1\library\IdentifierLibrary;
use app\kalgorithm_module\working_version\v1\validator\IdentifierValidatePost;
use app\kalgorithm_module\working_version\v1\validator\IdentifierValidateGet;
use app\kalgorithm_module\working_version\v1\validator\IdentifierValidatePut;
use app\kalgorithm_module\working_version\v1\validator\IdentifierValidateDelete;

class IdentifierService
{
    /**
     * 名  称 : identifierShow()
     * 功  能 : 获取标识符列表数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/10 22:14
     */
    public function identifierShow($get)
    {
        // 实例化验证器代码
        $validate  = new IdentifierValidateGet();
        
        // 验证数据
        if (!$validate->scene('edit')->check($get)) {
            return \RSD::returnData($validate->getError(),'',false);
        }
        
        // 实例化Dao层数据类
        $identifierDao = new IdentifierDao();
        
        // 执行Dao层逻辑
        $res = $identifierDao->identifierSelect($get);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }
}