<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DataobjectService.php
 *  开发人员 :  Feng Tian Shui
 *  联系电话 :  15731709183
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\service;
use app\dataobject_module\working_version\v1\dao\DataobjectDao;
use app\dataobject_module\working_version\v1\library\DataobjectLibrary;
use app\dataobject_module\working_version\v1\validator\DataobjectValidatePost;
use app\dataobject_module\working_version\v1\validator\DataobjectValidateGet;
use app\dataobject_module\working_version\v1\validator\DataobjectValidatePut;
use app\dataobject_module\working_version\v1\validator\DataobjectValidateDelete;

class DataobjectService
{
    /**
     * 名  称 : dataobjectAdd()
     * 功  能 : 添加数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/22 22:15
     */
    public function dataobjectAdd($post)
    {
        // 实例化验证器代码
        $validate  = new DataobjectValidatePost();

        // 验证数据
        if (!$validate->scene('edit')->check($post)) {
            return \RSD::returnData($validate->getError(),'',false);
        }

        // 验证数据是否正确
        if(!json_decode($post['json_object'],true)){
            return \RSD::returnData(
                'E10002.json_object Parameter Formatting Error','', false
            );
        }
        $post['json_object'] = json_decode($post['json_object'],true);
        
        // 实例化Dao层数据类
        $dataobjectDao = new DataobjectDao();
        
        // 执行Dao层逻辑
        $res = $dataobjectDao->dataobjectCreate($post);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }

    /**
     * 名  称 : dataobjectShow()
     * 功  能 : 查询数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['table_name']  => '数据表名';
     * 输  入 : (String) $get['json_field']  => '查询内容';
     * 输  入 : (String) $get['json_where']  => '查询条件';
     * 输  入 : (String) $get['json_order']  => '排序字段';
     * 输  入 : (String) $get['json_limit']  => '分页字段';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/30 19:45
     */
    public function dataobjectShow($get)
    {
        // 实例化验证器代码
        $validate  = new DataobjectValidateGet();
        
        // 验证数据
        if (!$validate->scene('edit')->check($get)) {
            return \RSD::returnData($validate->getError(),'',false);
        }

        // 验证 json_field 数据是否正确
        $this->isSetJson('json_field',$get);

        // 验证 json_where 数据是否正确
        if(strtoupper($get['json_where'])!=='ALL'){
            $this->isSetJson('json_where',$get);
        }else{
            $get['json_where'] = 'ALL';
        }

        // 验证 json_order 数据是否正确
        if(strtoupper($get['json_order'])!=='NOT'){
            $this->isSetJson('json_order',$get);
        }else{
            $get['json_order'] = 'NOT';
        }

        // 验证 json_limit 数据是否正确
        if(strtoupper($get['json_limit'])!=='NOT'){
            $this->isSetJson('json_limit',$get);
        }else{
            $get['json_limit'] = 'NOT';
        }
        
        // 实例化Dao层数据类
        $dataobjectDao = new DataobjectDao();
        
        // 执行Dao层逻辑
        $res = $dataobjectDao->dataobjectSelect($get);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }

    /**
     * 验证 json 数据是否正确
     */
    private function isSetJson($jsonName,&$get)
    {
        if(!json_decode($get[$jsonName],true)){
            die(\RSD::wxReponse(
                \RSD::returnData(
                    'E10002.'.$jsonName.' Parameter Formatting Error','', false
                ),'S'
            ));
        }
        $get[$jsonName] = json_decode($get[$jsonName],true);
    }
}