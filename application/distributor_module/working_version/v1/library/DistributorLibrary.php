<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  DistributorLibrary.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/29 21:08
 *  文件描述 :  分销模块自定义类
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\library;
use app\distributor_module\working_version\v1\dao\DistributorDao;

class DistributorLibrary
{
    /**
     * 名  称 : relationshipGet()
     * 功  能 : 获取分销商的关系 获取三级关系
     * 变  量 : --------------------------------------
     * 输  入 : (srting) $user_token          =>  `用户token`
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/27 18:06
     */
    public function relationshipGet($user_token)
    {
        //实例化Dao层
        $opject = new DistributorDao();
        $data = '';
        //查询上级分销商
        $result =  $opject->querySingle($user_token);
        $parent_token = $result['data']['parent_token'];
        if ($parent_token){
            $data = "有父击".$parent_token;
            $result =  $opject->querySingle($parent_token);
            $parent_token1 = $result['data']['parent_token'];
            if ($parent_token){
                $data .= "有父击".$parent_token.'yeyou'.$parent_token1;
                return $data;
            }
            return $data;
        }else{
            return "meiyou".$user_token;
        }
    }
}
