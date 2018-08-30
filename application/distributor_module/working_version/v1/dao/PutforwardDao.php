<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  PutforwardDao.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 14:57
 *  文件描述 :  提现信息数据层
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\dao;
use app\distributor_module\working_version\v1\model\PutforwardModel;

class PutforwardDao implements PutforwardInterface
{
    /**
     * 名  称 : putforwardSelect()
     * 功  能 : 提现信息操作数据处理
     * 变  量 : --------------------------------------
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  入 : $get['DataNumbE'] => '现已获取到的信息数量，没有输入0';
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/30 15:08
     */
    public function putforwardSelect($get)
    {
        // TODO :  PutforwardModel 模型
        $putforwardModel = PutforwardModel::where(
            'user_token',$get['UserToken']
        )->order(
            'forward_time','desc'
        )->limit(
            $get['DataNumbE'],'12'
        )->select()->toArray();
        // 处理函数返回值
        return \RSD::wxReponse($putforwardModel,'M',$putforwardModel,'请求失败');
    }
}
