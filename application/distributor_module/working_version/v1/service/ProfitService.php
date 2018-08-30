<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ProfitService.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 13:28
 *  文件描述 :  收益信息逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\service;
use app\distributor_module\working_version\v1\dao\ProfitDao;
use app\distributor_module\working_version\v1\library\ProfitLibrary;
use app\distributor_module\working_version\v1\validator\ProfitValidate;

class ProfitService
{
    /**
     * 名  称 : profitShow()
     * 功  能 : 收益信息操作逻辑
     * 变  量 : --------------------------------------
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/30 13:31
     */
    public function profitShow($get)
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
}
