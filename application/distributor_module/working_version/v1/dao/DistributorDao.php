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
     * 输  入 : (string) $user_token          => `用户token标识`
     * 输  入 : (string) $parent_token        => `上级token标识`
     * 输  入 : (string) $member_user         => `用户昵称`
     * 输  入 : (string) $member_image        => `用户头像图片路径`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/27 18:06
     */
    public function distributorCreate($post)
    {
        //执行添加模型
        $res = DistributorModel::create($post,true);
        //返回结果
        return \RSD::wxReponse($res,'M','创建成功','创建失败');
    }
    /**
     * 名  称 : promoterUpdate()
     * 功  能 : 注册推客员接口逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (srting) $user_token          =>  `用户token`
     * 输  入 : (srting) $member_name         =>  `用户真实姓名`
     * 输  入 : (srting) $member_phone        =>  `用户手机号`
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/27 18:06
     */
    public function promoterUpdate($post)
    {
        $opject = new DistributorModel();
        //执行模型操作
        $res = $opject->save($post,['user_token' => $post['user_token']]);
        //返回结果
        return \RSD::wxReponse($res,'M','成功','失败');
    }
    /**
     * 名  称 : promoterModify()
     * 功  能 : 注册推客员接口逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (srting) $user_token          =>  `用户token`
     * 输  入 : (srting) $member_name         =>  `用户真实姓名`
     * 输  入 : (srting) $member_phone        =>  `用户手机号`
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/27 18:06
     */
    public function promoterModify($put)
    {
        $opject = new DistributorModel();
        //执行模型操作
        $res = $opject->save($put,['user_token' => $put['user_token']]);
        //返回结果
        return \RSD::wxReponse($res,'M','成功','失败');
    }
    /**
     * 名  称 : querySingle()
     * 功  能 : 查询单个分销成员信息
     * 变  量 : --------------------------------------
     * 输  入 : (string) $user_token          => `用户token标识`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/27 18:06
     */
    public function querySingle($user_token)
    {
        //执行查询
        $res = (new DistributorModel())->where('user_token',$user_token)->find();
        //返回结果
        return \RSD::wxReponse($res,'M',$res,'没有数据');
    }
    /**
     * 名  称 : queryAll()
     * 功  能 : 查询所有分销成员信息
     * 变  量 : --------------------------------------
     * 输  入 : (int) $num          => `页码`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/27 18:06
     */
    public function queryAll($num)
    {
        //创建模型对象
        $opject = new DistributorModel();
        //执行查询
       $res = $opject->where('member_status',1)
                    ->limit(12*$num,12)
                    ->select();
       //返回结果
        return \RSD::wxReponse($res->toArray(),'M',$res,'没有数据');
    }
    /**
     * 名  称 : querySon()
     * 功  能 : 查询佣金下级分销商信息
     * 变  量 : --------------------------------------
     * 输  入 : (string)  $user_token     =>  `用户token标识`
     * 输  入 : (int)     $num            => `页码`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/27 18:06
     */
    public function querySon($get)
    {
        //创建模型对象
        $opject = new DistributorModel();

        //执行查询
       $res = $opject->where(['parent_token'=>$get['user_token'],'member_status'=>0])
                ->limit(12*$get['num'],12)
                ->select();
        //返回结果
        return \RSD::wxReponse($res->toArray(),'M',$res,'没有数据');
    }
    /**
     * 名  称 : queryPush()
     * 功  能 : 查询推客下级分销商信息
     * 变  量 : --------------------------------------
     * 输  入 : (string)  $user_token     =>  `用户token标识`
     * 输  入 : (int)     $num            => `页码`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/27 18:06
     */
    public function queryPush($get)
    {
        //创建模型对象
        $opject = new DistributorModel();

        //执行查询
        $res = $opject->where(['parent_token'=>$get['user_token'],'member_status'=>1])
            ->limit(12*$get['num'],12)
            ->select();
        //返回结果
        return \RSD::wxReponse($res->toArray(),'M',$res,'没有数据');
    }
    /**
     * 名  称 : querySuperior()
     * 功  能 : 查询上级分销商信息
     * 变  量 : --------------------------------------
     * 输  入 : (string)  $user_token     =>  `用户token标识`
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/27 18:06
     */
    public function querySuperior($user_token)
    {
        // 获取买家信息
        $user = DistributorModel::where(
            'user_token',$user_token
        )->find();

        // 验证数据
        if(!$user){
            return returnData('error','不存在此UserToken标识买家');
        }

        // 获取三级级分销商
        $class3 = DistributorModel::where(
            'user_token',$user['parent_token']
        )->find()->toArray();

        // 获取二级级分销商
        $class2 = DistributorModel::where(
            'user_token',$class3['parent_token']
        )->find()->toArray();

        // 获取一级级级分销商
        $class1 = DistributorModel::where(
            'user_token',$class2['parent_token']
        )->find()->toArray();

        // 处理数据
        $data = [
            'user'   =>  $user,
            'class1' =>  $class1,
            'class2' =>  $class2,
            'class3' =>  $class3,
        ];

        return \RSD::wxReponse($data,'M',$data,'请求失败');
    }
}
