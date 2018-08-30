<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DistributorService.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/29 21:08
 *  文件描述 :  分销模块逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\service;
use app\distributor_module\working_version\v1\dao\DistributorDao;
use app\distributor_module\working_version\v1\library\DistributorLibrary;

class DistributorService
{
    /**
     * 名  称 : distributionAdd()
     * 功  能 : 创建分销员接口
     * 变  量 : --------------------------------------
     * 输  入 : (string) $userToken       => `用户token标识`
     * 输  入 : (string) $parentToken     => `上级token标识`
     * 输  入 : (string) $userName        => `用户昵称`
     * 输  入 : (string) $userImage       => `用户头像图片路径`
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/27 18:06
     */
    public function distributionAdd($post)
    {
        //验证数据

        // 实例化Dao层数据类
        $distributionDao = new DistributionDao();

        // 执行Dao层逻辑
        $res = $distributionDao->distributionCreate($post);

        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }
}
