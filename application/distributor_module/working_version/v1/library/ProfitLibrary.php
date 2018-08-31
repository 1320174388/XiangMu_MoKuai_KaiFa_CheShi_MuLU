<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ProfitLibrary.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 13:28
 *  文件描述 :  收益信息自定义类
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\library;
use app\distributor_module\working_version\v1\dao\ProfitDao;
use app\distributor_module\working_version\v1\validator\ProfitValidate;

class ProfitLibrary
{
    /**
     * 名  称 : profitLibGet()
     * 功  能 : 收益信息操作函数类
     * 变  量 : --------------------------------------
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/30 13:31
     */
    public function profitLibGet($get)
    {
        // 实例化验证器代码
        $validate  = new ProfitValidate();

        // 验证数据
        if (!$validate->scene('edit')->check($get)) {
            return ['msg'=>'error','data'=>$validate->getError()];
        }

        // 实例化Dao层数据类
        $profitDao = new ProfitDao();

        // 执行Dao层逻辑
        $res = $profitDao->profitSelect($get);

        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }

    /**
     * 名  称 : profitLibPut()
     * 功  能 : 修改收益函数类
     * 变  量 : --------------------------------------
     * 输  入 : $put['UserToken']    => '提现人UserToken身份标识';
     * 输  入 : $put['ForwardName']  => 'ForwardName提现人名称;
     * 输  入 : $put['ForwardMoney'] => 'ForwardMoney提现金额;
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/30 23:35
     */
    public function profitLibPut($put)
    {
        // 验证数据
        if((empty($put['UserToken']))||(strlen($put['UserToken']) != 32)){
            return returnData('error','请正确发送：提现人UserToken身份标识');
        }
        // 验证数据
        if((empty($put['ForwardName']))){
            return returnData('error','请正确发送：ForwardName提现人名称');
        }
        // 验证数据
        if((empty($put['ForwardMoney']))||(!is_numeric($put['ForwardMoney']))){
            return returnData('error','请正确发送：ForwardMoney提现金额');
        }

        // 实例化Dao层数据类
        $profitDao = new ProfitDao();

        // 执行Dao层逻辑
        $res = $profitDao->profitUpdate($put);

        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }
}
