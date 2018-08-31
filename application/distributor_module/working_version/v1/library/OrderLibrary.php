<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderLibrary.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 10:06
 *  文件描述 :  分销订单自定义类
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\library;
use app\distributor_module\working_version\v1\dao\OrderDao;
use \think\Controller;

class OrderLibrary extends Controller
{
    /**
     * 名  称 : orderLibGet()
     * 功  能 : 订单信息操作接口函数类
     * 变  量 : --------------------------------------
     * 输  入 : $get['UserToken'] => '用户UserToken身份标识';
     * 输  入 : $get['OrderType'] => 'OrderType = no;     获取所有订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = true;   获取以结算订单信息';
     * 输  入 : $get['OrderType'] => 'OrderType = false;  获取未结算订单信息';
     * 输  入 : $get['OrderNumb'] => '现已获取到的订单数量，没有输入0';
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/30 10:04
     */
    public function orderLibGet($get)
    {
        // TODO : 执行函数处理逻辑

        // TODO : 返回函数输出数据
        return ['msg'=>'success','data'=>'返回数据'];
    }

    /**
     * 名  称 : orderLibPost()
     * 功  能 : 添加订单函数类
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
    public function orderLibPost($post)
    {
        // 验证数据
        $validate = $this->libPostvalidate($post);
        if($validate['msg']=='error'){
            return returnData('error',$validate['data']);
        };

        // 实例化Dao层数据类
        $orderDao = new OrderDao();

        // 执行Dao层逻辑
        $res = $orderDao->orderCreate($post);

        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }

    /**
     * 功  能 : 添加订单函数类验证器
     * 输  入 : $post['OrderNumber'] => '订单OrderNumber编号';
     * 输  入 : $post['UserToken']   => '买家UserToken身份标识;
     * 输  入 : $post['JsonBuyer']   => '买家JSON数据，不需要则发送无用JSON格式数据;
     * 输  入 : $post['JsonSeller']  => '卖家JSON数据，不需要则发送无用JSON格式数据
     * 输  入 : $post['JsonOrder']   => '订单JSON数据，不需要则发送无用JSON格式数据
     * 输  入 : $post['ProfitPrice'] => '分销商ProfitPrice收益金额
     */
    private function libPostvalidate($post)
    {
        $result = $this->validate(
            $post,[
            'OrderNumber' => 'require|number',
            'UserToken'   => 'require|min:32|max:32',
            'JsonBuyer'   => 'require',
            'JsonSeller'  => 'require',
            'JsonOrder'   => 'require',
            'ProfitPrice' => 'require',
        ],[
                'OrderNumber.require' => '请正确发送订单OrderNumber编号',
                'OrderNumber.number'  => '请正确发送订单OrderNumber编号',
                'UserToken.require'   => '请正确发送买家UserToken身份标识',
                'UserToken.min'       => '请正确发送买家UserToken身份标识',
                'UserToken.max'       => '请正确发送买家UserToken身份标识',
                'JsonBuyer.require'   => '请正确发送买家JSON数据，不需要则发送无用JSON格式数据',
                'JsonSeller.require'  => '请正确发送卖家JSON数据，不需要则发送无用JSON格式数据',
                'JsonOrder.require'   => '请正确发送订单JSON数据，不需要则发送无用JSON格式数据',
                'ProfitPrice.require' => '分销商ProfitPrice收益金额',
            ]
        );
        if (true !== $result) {
            // 验证失败 输出错误信息
            return returnData('error',$result);
        }
        // 二次验证 JsonBuyer 数据
        if(is_null(json_decode($post['JsonBuyer']))){
            return returnData('error','请正确发送买家JSON数据，不需要则发送无用JSON格式数据');
        }
        // 二次验证 JsonSeller 数据
        if(is_null(json_decode($post['JsonSeller']))){
            return returnData('error','请正确发送卖家JSON数据，不需要则发送无用JSON格式数据');
        }
        // 二次验证 JsonOrder 数据
        if(is_null(json_decode($post['JsonOrder']))){
            return returnData('error','请正确发送订单JSON数据，不需要则发送无用JSON格式数据');
        }

    }
    /**
     * 名  称 : orderSettlement()
     * 功  能 : 分销商订单结算函数
     * 输  入 : $get['order_number'] => '订单OrderNumber编号';
     */
    public function orderSettlement($get)
    {
        $result = $this->validate(
            $get,[
            'order_number' => 'require|number',
        ],[
                'order_number.require' => '请正确发送订单order_number编号',
            ]
        );
        if (true !== $result) {
            // 验证失败 输出错误信息
            return returnData('error',$result);
        }
        // 实例化Dao层数据类
        $orderDao = new OrderDao();
        //执行查询
       $reult = $orderDao->orderSettlementQuery($get['order_number']);

        return \RSD::wxReponse($reult,'D');
    }

}
