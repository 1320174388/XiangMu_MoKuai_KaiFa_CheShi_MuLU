<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DistributorDao.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/29 21:08
 *  文件描述 :  分销模块数据层
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\dao;
use app\distributor_module\working_version\v1\model\DistributorModel;

class DistributorDao implements DistributorInterface
{
    /**
     * 名  称 : distributionPost()
     * 功  能 : 添加分销员接口
     * 变  量 : --------------------------------------
     * 输  入 : (string) $userToken       => `用户token标识`
     * 输  入 : (string) $parentToken     => `上级token标识`
     * 输  入 : (string) $userName        => `用户昵称`
     * 输  入 : (string) $userImage       => `用户头像图片路径`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/27 18:06
     */
    public function distributorCreate($post)
    {
        // TODO :  DistributorModel 模型
      $res =  DistributorModel::get(1);
        return \RSD::wxReponse($res,'M',$res,'没有数据');
    }
}
