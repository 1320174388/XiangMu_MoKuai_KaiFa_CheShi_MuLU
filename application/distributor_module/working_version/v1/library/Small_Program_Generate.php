<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  AccessTokenRequest.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/15 12:45
 *  文件描述 :  Wx_小程序：小程序码生成类
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\library;
class Small_Program_Generate
{
    /**
     * 名 称 : $SmallProgramConfig
     * 功 能 : 小程序码生成配置
     * 创 建 : 2018/28/29 22:53
     */
    private static $SmallProgramConfig = array(

        'getwxacodeunlimit' => // 请求小程序码地址
        'https://api.weixin.qq.com/wxa/getwxacodeunlimit'

    );

    /**
     * 名 称 : __construct()
     * 功 能 : 定义配置信息数据
     * 创 建 : 2018/08/15 12:17
     */
    private function __construct()
    {
        // TODO: 禁止外部实例化
    }

    /**
     * 名 称 : __clone()
     * 功 能 : 禁止外部克隆该实例
     * 创 建 : 2018/08/15 12:20
     */
    private function __clone()
    {
        // TODO: 禁止外部克隆该实例
    }

    /**
     * 名  称 : SmallRequest()
     * 功  能 : 发送模板消息
     * 输  入 : -------------------------------
     * 输  出 : ['msg'=>'success','data'=>true]
     * 创  建 : 2018/08/15 12:26
     */
    public static function SmallRequest($access_token,$data,$dir,$token)
    {
        // 判断授权令牌是否发送
        if(empty($access_token)){
            return self::returnArray(
                'error',
                '请发送接口调用凭证信息'
            );
        }
        // 获取发送模板信息地址
        $url = self::$SmallProgramConfig['getwxacodeunlimit'];
        $url.= '?access_token='.$access_token;
        // 处理数据
        $data = json_encode($data);
        // 请求小程序码
        $wxData = self::curlPost($url,$data);
        // 解析数据
        $wxArr = json_decode($wxData,true);
        // 返回错误数据
        if(!empty($wxArr['errcode'])) {
            return self::returnArray('error',$wxArr);
        }
        if(!is_dir($dir)){
            mkdir($dir,'777','-r');
        };
        $dir = rtrim($dir,'/');
        file_put_contents($dir.'/'.$token.'.png',$wxData);
        // 返回正确数据
        return self::returnArray('success',$dir.'/'.$token.'.png');
    }

    /**
     * 名  称 : curlPost()
     * 功  能 : Curl请求发送数据
     * 创  建 : 2018/08/15 12:29
     */
    private static function curlPost($url,$data)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检测
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:')); //解决数据包大不能提交
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);
        }
        curl_close($curl); // 关键CURL会话
//            dd($tmpInfo);
        return $tmpInfo; // 返回数据
    }

    /**
     * 名  称 : returnArray()
     * 功  能 : 返回数据
     * 创  建 : 2018/08/15 12:30
     */
    private static function returnArray($msg,$data = false)
    {
        return [ 'msg'=>$msg , 'data'=>$data ];
    }
}