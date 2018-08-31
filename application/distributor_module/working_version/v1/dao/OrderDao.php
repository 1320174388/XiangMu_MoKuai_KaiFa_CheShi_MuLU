<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderDao.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 10:06
 *  文件描述 :  分销订单数据层
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\dao;
use app\distributor_module\working_version\v1\model\OrderModel;
use app\distributor_module\working_version\v1\library\DistributorLibrary;
use app\distributor_module\working_version\v1\model\ProfitModel;

class OrderDao implements OrderInterface
{
    /**
     * 名  称 : orderSelect()
     * 功  能 : 订单信息操作接口数据处理
     * 变  量 : --------------------------------------
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  入 : $get['OrderType'] => 'OrderType = 0;  获取所有订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = 1;  获取以结算订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = 2;  获取未结算订单信息';
     * 输  入 : $get['OrderNumb'] => '现已获取到的订单数量，没有输入0';
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/30 10:04
     */
    public function orderSelect($get)
    {
        // TODO :  初始条件
        $orderModel = OrderModel::where('user_token',$get['UserToken']);
        // TODO :  查询状态
        if($get['OrderType']!='0'){
            $orderModel = $orderModel->where('order_status',$get['OrderType']);
        }
        // TODO :  查询数量
        $orderData = $orderModel->limit(
            $get['OrderNumb'],12
        )->select()->toArray();
        // 处理函数返回值
        return \RSD::wxReponse($orderData,'M',$orderData,'请求失败');
    }

    /**
     * 名  称 : orderCreate()
     * 功  能 : 添加订单数据处理
     * 变  量 : --------------------------------------
     * 输  入 : $post['OrderNumber'] => '订单OrderNumber编号';
     * 输  入 : $post['UserToken']   => '买家UserToken身份标识;
     * 输  入 : $post['JsonBuyer']   => '买家JSON数据，不需要则发送无用JSON格式数据;
     * 输  入 : $post['JsonSeller']  => '卖家JSON数据，不需要则发送无用JSON格式数据
     * 输  入 : $post['JsonOrder']   => '订单JSON数据，不需要则发送无用JSON格式数据
     * 输  入 : $post['ProfitPrice'] => '分销商ProfitPrice收益金额
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/31 01:24
     */
    public function orderCreate($post)
    {
        // TODO : 实例化 DistributorLibrary 类
        $distributorLibrary = new DistributorLibrary();
        // 获取分销信息
        $res = $distributorLibrary->relationshipGet($post['UserToken']);
        // 验证
        if($res['msg']=='error'){
            return returnData('error',$res['data']);
        }

        // 导数据
        $data = $res['data'];

        //  获取比例
        $class1B = config('v1_config.distribution_module.class1price');
        $class2B = config('v1_config.distribution_module.class2price');
        $class3B = config('v1_config.distribution_module.class3price');

        // 处理数据
        $class1price = math_mul($post['ProfitPrice'],$class1B, 2);
        $class2price = math_mul($post['ProfitPrice'],$class2B,2);
        $class3price = math_mul($post['ProfitPrice'],$class3B, 2);

        // 启动事务
        \think\Db::startTrans();
        try {
            // 判断用户上级是否是本人
            if($data['user']['user_token']==$data['user']['parent_token']){
                $res = $this->OrderModelCreate(
                    $post,$data['user']['parent_token'],
                    $post['ProfitPrice'],'100%'
                );
                // 提交事务
                \think\Db::commit();
                return \RSD::wxReponse($res,'M','订单添加成功','订单添加失败');
            }

            // 判断三级分销的上级是否是本人
            if($data['class3']['user_token']==$data['class3']['parent_token']){
                $res = $this->OrderModelCreate(
                    $post,$data['class3']['parent_token'],
                    $post['ProfitPrice'],'100%'
                );
                // 提交事务
                \think\Db::commit();
                return \RSD::wxReponse($res,'M','订单添加成功','订单添加失败');
            }else{
                $res = $this->OrderModelCreate(
                    $post,$data['class3']['user_token'],
                    $class3price,($class3B*100).'%'
                );
                if(!$res) return returnData('error','订单添加失败');
            }

            // 判断二级分销的上级是否是本人
            if($data['class2']['user_token']==$data['class2']['parent_token']){
                $res = $this->OrderModelCreate(
                    $post,$data['class2']['parent_token'],
                    math_mul($post['ProfitPrice'] ,((100-($class3B*100))/100),2),
                    (100-($class3B*100)).'%'
                );
                // 提交事务
                \think\Db::commit();
                return \RSD::wxReponse($res,'M','订单添加成功','订单添加失败');
            }else{
                $res = $this->OrderModelCreate(
                    $post,$data['class2']['user_token'],
                    $class2price,($class2B*100).'%'
                );
                if(!$res) return returnData('error','订单添加失败');
            }

            $res = $this->OrderModelCreate(
                $post,$data['class1']['user_token'],
                $class1price,($class1B*100).'%'
            );
            // 提交事务
            \think\Db::commit();
            return \RSD::wxReponse($res,'M','订单添加成功','订单添加失败');
        } catch (\Exception $e) {
            // 回滚事务
            \think\Db::rollback();
            return \RSD::wxReponse(false,'M','','订单添加失败');
        }


        // TODO :  返回正确数据
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : OrderModelCreate()
     * 功  能 : 添加订单数据处理辅助函数
     * 输  入 : $post['OrderNumber'] => '订单OrderNumber编号';
     * 输  入 : $post['UserToken']   => '买家UserToken身份标识;
     * 输  入 : $post['JsonBuyer']   => '买家JSON数据，不需要则发送无用JSON格式数据;
     * 输  入 : $post['JsonSeller']  => '卖家JSON数据，不需要则发送无用JSON格式数据
     * 输  入 : $post['JsonOrder']   => '订单JSON数据，不需要则发送无用JSON格式数据
     * 输  入 : $post['ProfitPrice'] => '分销商ProfitPrice收益金额
     * 创  建 : 2018/08/31 02:04
     */
    private function OrderModelCreate($post,$token,$price,$ratio)
    {
        // TODO :  实例化 OrderModel 模型
        $orderModel = new OrderModel();
        // TODO :  处理数据
        $orderModel->order_number = $post['OrderNumber'];
        $orderModel->user_token   = $token;
        $orderModel->json_buyer   = $post['JsonBuyer'];
        $orderModel->json_buyer   = $post['JsonBuyer'];
        $orderModel->json_seller  = $post['JsonSeller'];
        $orderModel->json_order   = $post['JsonOrder'];
        $orderModel->profit_price = $price;
        $orderModel->profit_ratio = $ratio;
        $orderModel->order_status = 1;
        $orderModel->order_time   = time();
        // TODO :  返回处理结果
        return $orderModel->save();
    }
    /**
     * 名  称 : orderSettlementQuery()
     * 功  能 : 分销商订结算
     * 输  入 : $get['order_number'] => '订单order_number编号';
     */
    public function orderSettlementQuery($order_number)
    {
        //实例化模型
        $opject = new OrderModel();
        //执行查询
        $res = $opject->where('order_number',$order_number)
                    ->field( 'user_token,profit_price')
                     ->select();
        //插入收益表
        $profit = new ProfitModel();
        //启动事务
        \think\Db::startTrans();
        foreach ($res->toArray() as $value){
            //查询余额
           $sum = $profit->where('user_token',$value['user_token'])
                        ->field( 'profit_price')
                        ->find();
           //余额+佣金= 总价格
            $price = $value['profit_price'] + $sum['profit_price'];
            //更新余额
            $profit->save([
                'profit_price'  => $price
            ],['user_token' =>  $value['user_token']]);

        }
        //更新订单结算状态
       $res = $opject->where('order_number',$order_number)
                ->setField('order_status',0);
        if ($res){
            //提交事务
            \think\Db::commit();
            return \RSD::wxReponse($res,'M','订单结算成功','订单结算失败');
        }
        //事务回滚
        \think\Db::rollback();
        return \RSD::wxReponse($res,'M','订单结算成功','订单结算失败');

    }
}
