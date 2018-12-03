<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DatainitService.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\service;
use app\dataobject_module\working_version\v1\dao\DatainitDao;
use app\dataobject_module\working_version\v1\library\DatainitLibrary;
use app\dataobject_module\working_version\v1\validator\DatainitValidatePost;
use app\dataobject_module\working_version\v1\validator\DatainitValidateGet;
use app\dataobject_module\working_version\v1\validator\DatainitValidatePut;
use app\dataobject_module\working_version\v1\validator\DatainitValidateDelete;

class DatainitService
{
    /**
     * 名  称 : datainitAdd()
     * 功  能 : 初始化数据表逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['module_key']  => '模块秘钥';
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/23 09:09
     */
    public function datainitAdd($post)
    {
        // 实例化验证器代码
        $validate  = new DatainitValidatePost();
        
        // 验证数据
        if (!$validate->scene('edit')->check($post)) {
            return \RSD::returnData($validate->getError(),'',false);
        }

        // 验证秘钥是否正确
        if($post['module_key']!==config("dataobject_v1_config.module_key"))
        {
            return \RSD::returnData(
                'E10004.Module Secret key Error','', false
            );
        }

        // 转换表名为小写
        $post['table_name'] = strtolower($post['table_name']);

        // 验证数据是否正确
        if(!json_decode($post['json_object'],true)){
            return \RSD::returnData(
                'E10002.json_object Parameter Formatting Error','', false
            );
        }
        $post['json_object'] = json_decode($post['json_object'],true);
        
        // 实例化Dao层数据类
        $datainitDao = new DatainitDao();
        
        // 执行Dao层逻辑
        $res = $datainitDao->datainitCreate($post);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }
}