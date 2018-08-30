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
use think\Validate;

class DistributorService
{
    /**
     * 名  称 : distributorAdd()
     * 功  能 : 创建分销员接口
     * 变  量 : --------------------------------------
     * 输  入 : (string) $user_token          => `用户token标识`
     * 输  入 : (string) $parent_token        => `上级token标识`
     * 输  入 : (string) $member_user         => `用户昵称`
     * 输  入 : (string) $member_image        => `用户头像图片路径`
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/27 18:06
     */
    public function distributorAdd($post)
    {
        //验证数据
        $validate = new Validate([
            'user_token'     => 'require',
            'parent_token'   => 'require',
            'member_user'    => 'require',
            'member_image'   => 'require'
        ],[
            'user_token.require'     => '用户user_token不能为空',
            'parent_token.require'   => '上级parent_token不能为空',
            'member_user.require'    => '用户member_user不能为空',
            'member_image.require'   => '用户member_image不能为空'
        ]);
        //返回数据错误
       if (!$validate->check($post)){
           return returnData('error',$validate->getError());
       }

        // 实例化Dao层数据类
        $distributorDao = new DistributorDao();

        //判断用户是否存在
        $res = $distributorDao->querySingle($post['user_token']);
        //返回错误信息
        if ($res['msg'] !== 'error'){
            return returnData('error','用户已存在');
        }
        //输入创建时间
        $post['created_time'] = ''.time().'';
        // 执行Dao层逻辑
        $res = $distributorDao->distributorCreate($post);

        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }
    /**
     * 名  称 : promoterAdd()
     * 功  能 : 注册推客员接口逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (srting) $user_token          =>  `用户token`
     * 输  入 : (srting) $member_name         =>  `用户真实姓名`
     * 输  入 : (srting) $member_phone        =>  `用户手机号`
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/30 13:06
     */
    public function promoterAdd($post)
    {
        //验证数据
        $validate = new Validate([
            'user_token'        => 'require',
            'member_name'       => 'require',
            'member_phone'      => 'require'
        ],[
            'user_token.require'     => '用户user_token不能为空',
            'member_name.require'    => '真实姓名member_name不能为空',
            'member_phone.require'   => '手机号member_phone不能为空'
        ]);
        //返回数据错误
        if (!$validate->check($post)){
            return returnData('error',$validate->getError());
        }
        // 实例化Dao层数据类
        $promoterDao = new DistributorDao();

        //判断用户是否存在
        $res = $promoterDao->querySingle($post['user_token']);
        //返回错误信息
        if ($res['msg'] == 'error'){
            return returnData('error','用户不存在');
        }
        //更改推客状态
        $post['member_status'] = 1;
        //创建修改时间
        $post['undated_time'] = ''.time().'';
        // 执行Dao层逻辑
        $res = $promoterDao->promoterUpdate($post);

        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }
    /**
     * 名  称 : promoterPut()
     * 功  能 : 修改推客员信息接口
     * 变  量 : --------------------------------------
     * 输  入 : (srting) $user_token          =>  `用户token`
     * 输  入 : (srting) $member_name         =>  `用户真实姓名`
     * 输  入 : (srting) $member_phone        =>  `用户手机号`
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/30 13:06
     */
    public function promoterPut($put)
    {
        //验证数据
        $validate = new Validate([
            'user_token'        => 'require',
        ],[
            'user_token.require'     => '用户user_token不能为空',
        ]);
        //返回数据错误
        if (!$validate->check($put)){
            return returnData('error',$validate->getError());
        }
        // 实例化Dao层数据类
        $promoterDao = new DistributorDao();

        //判断用户是否存在
        $res = $promoterDao->querySingle($put['user_token']);

        //返回错误信息
        if ($res['msg'] == 'error'){
            return returnData('error','用户不存在');

        }
        // 执行Dao层逻辑
        $res = $promoterDao->promoterModify($put);

        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }
    /**
     * 名  称 : distributorGet()
     * 功  能 : 获取分销商数据接口
     * 变  量 : --------------------------------------
     * 输  入 : (srting) $user_token  =>  `用户token`
     * 输  入 : (srting) $type   =>  `获取分销商类型`
     * 输  入 : (int)    $num         =>  `分页页码`
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/30 13:06
     */
    public function distributorGet($get)
    {
        //验证数据
        $validate = new Validate([
            'type'        => 'require',
        ],[
            'type.require'     => '查询分销商类型type不能为空',
        ]);
        //返回数据错误
        if (!$validate->check($get)){
            return returnData('error',$validate->getError());
        }
        // 实例化Dao层数据类
        $promoterDao = new DistributorDao();
        isset($get['num']) or $get['num'] = 0;
        //控制流程执行数据操作
        switch ($get['type'])
        {
            //获取全部分销商数据
            case 'all':
                //查询
                $res = $promoterDao->queryAll($get['num']);
                //返回结果
                return \RSD::wxReponse($res,'D');
                break;
            //获取佣金下级分销商信息
            case 'son':
                //查询
                $res = $promoterDao->querySon($get);
                //返回结果
                return \RSD::wxReponse($res,'D');
                break;
            //获取推客下级分销商信息
            case 'push':
                //查询
                $res = $promoterDao->queryPush($get);
                //返回结果
                return \RSD::wxReponse($res,'D');
                break;
            //返回类型错误
            default:
                return returnData('error','type类型错误');
        }
    }
}
