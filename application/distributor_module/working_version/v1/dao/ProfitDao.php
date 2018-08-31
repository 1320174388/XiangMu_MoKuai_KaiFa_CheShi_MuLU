<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ProfitDao.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 13:28
 *  文件描述 :  收益信息数据层
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\dao;
use app\distributor_module\working_version\v1\model\ProfitModel;
use app\distributor_module\working_version\v1\model\PutforwardModel;

class ProfitDao implements ProfitInterface
{
    /**
     * 名  称 : profitSelect()
     * 功  能 : 收益信息操作数据处理
     * 变  量 : --------------------------------------
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/30 13:31
     */
    public function profitSelect($get)
    {
        // TODO :  ProfitModel 模型
        $profitData = ProfitModel::where(
            'user_token',$get['UserToken']
        )->select()->toArray();
        // TODO :  返回数据
        return \RSD::wxReponse($profitData,'M',$profitData,'请求失败');
    }

    /**
     * 名  称 : profitUpdate()
     * 功  能 : 修改收益数据处理
     * 变  量 : --------------------------------------
     * 输  入 : $put['UserToken']    => '提现人UserToken身份标识';
     * 输  入 : $put['ForwardName']  => 'ForwardName提现人名称;
     * 输  入 : $put['ForwardMoney'] => 'ForwardMoney提现金额;
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/30 23:35
     */
    public function profitUpdate($put)
    {
        // TODO :  初始化条件
        $profitModel = ProfitModel::where('user_token',$put['UserToken']);
        // TODO :  判断提现人是否存在
        $data = $profitModel->select()->toArray();
        if(!$data){
            return returnData('error','不存在此UserToken标识提现人');
        }
        if( $put['ForwardMoney'] > $data[0]['profit_price'] ){
            return returnData('error','提现金额超出拥有金额啦');
        }
        // 启动事务
        \think\Db::startTrans();
        try {
            // 写入订单
            $putforwardModel = new PutforwardModel();
            $putforwardModel->user_token    = $put['UserToken'];
            $putforwardModel->forward_name  = $put['ForwardName'];
            $putforwardModel->forward_money = $put['ForwardMoney'];
            $putforwardModel->forward_time  = time();
            $save = $putforwardModel->save();
            if(!$save){
                return returnData('error','提现订单信息错误');
            };
            // 修改金额
            $profitModel = $profitModel->find();
            $profitModel->profit_price = math_sub(
                $data[0]['profit_price'],
                $put['ForwardMoney'],
                2
            );
            $profitModel->updated_time = time();
            $save = $profitModel->save();
            if(!$save){
                return returnData('error','收益金额修改失败');
            };
            // 提交事务
            \think\Db::commit();
            // TODO :  返回数据
            return \RSD::wxReponse(true,'M','收益金额修改成功','');
        } catch (\Exception $e) {
            // 回滚事务
            \think\Db::rollback();
            // TODO :  返回数据
            return \RSD::wxReponse(false,'M','','收益金额修改失败');
        }
    }
}
