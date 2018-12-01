<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DatainitDao.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象数据层
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\dao;
use app\dataobject_module\working_version\v1\model\DatainitModel;

class DatainitDao implements DatainitInterface
{
    /**
     * 名  称 : datainitCreate()
     * 功  能 : 初始化数据表数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/23 09:09
     */
    public function datainitCreate($post)
    {
        // 获取字段值
        $keyArray = $this->alterCreate($post);
        // 验证是否有修改
        if(!$keyArray) return \RSD::returnModel(true,'E40201');
        // 处理SQL语句
        $keyString = '';
        foreach($post['json_object'] as $k=>$v)
        {
            // 验证数据是否输入
            if(empty($v))return \RSD::returnModel(false,'E10000.json_object '.$k);
            // 处理SQL语句
            $keyString.= ",`{$k}` {$v}";
        }
        $keyString = ltrim($keyString,',');

        // TODO :  创建数据表/自段
        $res = $this->tableCreate($keyString,$post);

        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }

    /**
     * 名  称 : tableCreate()
     * 功  能 : 执行创建数据表
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/22 22:15
     */
    private function tableCreate($keyString='',$post)
    {
        // 获取表前缀
        $web = config('dataobject_v1_config.table_name');
        try {
            // TODO :  执行删除数据表
            \think\Db::execute("DROP TABLE IF EXISTS {$web}{$post['table_name']}");
            // TODO :  执行创建数据表
            \think\Db::execute(<<<sql
                CREATE TABLE IF NOT EXISTS `{$web}{$post['table_name']}` (
                    `{$post['table_name']}_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    {$keyString}
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
sql
            );
            // 处理函数返回值
            return \RSD::returnModel(true,'E10002');
        } catch (\Exception $e) {
            // 处理函数返回值
            return \RSD::returnModel(false,'E10002');
        }
    }

    /**
     * 名  称 : alterCreate()
     * 功  能 : 处理字段数据
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']  => '数据表名';
     * 输  入 : (String) $post['json_object'] => '数据内容';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/11/22 22:15
     */
    private function alterCreate($post)
    {
        // 获取表前缀
        $web = config('dataobject_v1_config.table_name');
        // 获取配置表名
        $con = config('dataobject_v1_config.web_config');
        $nam = config('dataobject_v1_config.config_name');
        try {// TODO :  执行创建数据表
            \think\Db::execute(<<<sql
                CREATE TABLE IF NOT EXISTS `{$con}{$nam}` (
                    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `table_name` varchar(32) UNIQUE,
                    `json_object` varchar(8000)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
sql
            );
        } catch (\Exception $e) {}
        // 处理字段数据
        ksort($post['json_object']);
        // 获取字段数据
        $keys = json_encode($post['json_object']);
        // 获取web_config表中的字段数据
        $cache = \think\Db::table($con.$nam)->where(
            'table_name',$web.$post['table_name']
        )->find();
        // 判断此表是否存在
        if($cache){
            // 对比原字段内容
            if($keys == $cache['json_object']) {
                return false;
            }else{
                // 保存字段数据
                \think\Db::name($con.$nam)->where(
                    'table_name', $web.$post['table_name']
                )->update([
                    'json_object' => $keys
                ]); return true;
            }
        }else{
            // 添加表字段数据
            \think\Db::name($con.$nam)->data([
                'table_name'  => $web.$post['table_name'],
                'json_object' => $keys
            ])->insert(); return true;
        }
    }
}