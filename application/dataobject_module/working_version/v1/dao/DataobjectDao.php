<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DataobjectDao.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
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

    /**
     * 名  称 : dataobjectSelect()
     * 功  能 : 查询数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['table_name']  => '数据表名';
     * 输  入 : (String) $get['json_field']  => '查询内容';
     * 输  入 : (String) $get['json_where']  => '查询条件';
     * 输  入 : (String) $get['json_order']  => '排序字段';
     * 输  入 : (String) $get['json_limit']  => '分页字段';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/30 19:45
     */
    public function dataobjectSelect($get)
    {
        // TODO : 实例化数据模型
        $dataObject = new DataobjectModel();
        // TODO : 配置模型表名
        $dataObject->setTableName($get['table_name']);
        // TODO : 定义需要查询字段
        if($get['json_field']!=='ALL'){
            $dataObject = $dataObject->field(implode(',',$get['json_field']));
        }
        // TODO : 定义查询条件
        if($get['json_where']!=='ALL'){
            foreach($get['json_where'] as $k => $v)
            {
                $dataObject = $dataObject->where($k,'like','%'.$v.'%');
            }
        }
        // TODO : 定义排序条件
        if($get['json_order']!=='NOT'){
            foreach($get['json_order'] as $k => $v)
            {
                $dataObject = $dataObject->order("{$k} {$v}");
            }
        }
        // TODO : 定义分页字段
        if($get['json_limit']!=='NOT'){
            $this->isSetLimit(0,'offset',$get);
            $this->isSetLimit(1,'length',$get);
            $dataObject = $dataObject->limit(
                $get['json_limit'][0],$get['json_limit'][1]
            );
        }

        // TODO : 执行查询数据
        try{
            $res = $dataObject->select()->toArray();
        }catch (\Exception $e){
            die(\RSD::wxReponse(
                \RSD::returnData(
                    'E40000.Query parameter error','', false
                ),'S'
            ));
        }
        // 处理函数返回值
        return \RSD::returnModel($res,'E40000');
    }

    /**
     * 验证分页数据是否存在
     */
    private function isSetLimit($key,$str = '',$get)
    {
        if(
            (!array_key_exists($key,$get['json_limit'])) ||
            (!is_numeric($get['json_limit'][$key]))
        ){
            die(\RSD::wxReponse(
                \RSD::returnData(
                    'E40000.json_limit '.$str.' Query parameter error','', false
                ),'S'
            ));
        }
    }

    /**
     * 名  称 : dataobjectUpdate()
     * 功  能 : 更新数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $put['table_name']  => '数据表名';
     * 输  入 : (String) $put['json_obj_id'] => '对象ID';
     * 输  入 : (String) $put['json_object'] => '更新内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/01 14:13
     */
    public function dataobjectUpdate($put)
    {
        // TODO : 实例化数据模型
        $dataObject = new DataobjectModel();
        // TODO : 配置模型表名
        $dataObject->setTableName($put['table_name']);
        // TODO : 执行修改数据
        try{
            // save方法第二个参数为更新条件
            $dataObject->save(
                $put['json_object'], [
                    $put['table_name'].'_id' => $put['json_obj_id']
                ]
            );
        }catch (\Exception $e){
            return \RSD::returnModel(
                false,'E10002.[json_object] Parameter Formatting Error'
            );
        }
        // 处理函数返回值
        return \RSD::returnModel(true,'E10002');
    }

    /**
     * 名  称 : dataobjectDelete()
     * 功  能 : 删除数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['table_name']  => '数据表名';
     * 输  入 : (String) $delete['json_obj_id'] => '对象ID';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/01 14:53
     */
    public function dataobjectDelete($delete)
    {
        // TODO : 实例化数据模型
        $dataObject = new DataobjectModel();
        // TODO : 配置模型表名
        $dataObject->setTableName($delete['table_name']);
        // TODO : 执行删除数据
        try{
            // save方法第二个参数为更新条件
            $dataObject->where(
                $delete['table_name'].'_id',$delete['json_obj_id']
            )->delete();
        }catch (\Exception $e){
            return \RSD::returnModel(
                false,'E10002.[json_object] Parameter Formatting Error'
            );
        }
        // 处理函数返回值
        return \RSD::returnModel(true,'E10002');
    }
}