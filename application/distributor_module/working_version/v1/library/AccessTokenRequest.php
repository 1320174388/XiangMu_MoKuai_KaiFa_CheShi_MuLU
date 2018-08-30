<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  AccessTokenRequest.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/15 12:45
 *  文件描述 :  Wx_小程序：请求授权令牌类
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\library;
class AccessTokenRequest
{
    /**
     * 名 称 : $AccessTokenConfig
     * 功 能 : 请求授权令牌类_配置数组
     * 创 建 : 2018/08/15 15:50
     */
    private static $AccessTokenConfig = array(

        'AccessTokenUrl' => // 请求授权令牌类地址
        'https://api.weixin.qq.com/cgi-bin/token'

    );

    /**
     * 名 称 : __construct()
     * 功 能 : 定义配置信息数据
     * 创 建 : 2018/08/15 12:53
     */
    private function __construct()
    {
        // TODO: 禁止外部实例化
    }

    /**
     * 名 称 : __clone()
     * 功 能 : 禁止外部克隆该实例
     * 创 建 : 2018/08/15 12:54
     */
    private function __clone()
    {
        // TODO: 禁止外部克隆该实例
    }

    /**
     * 名  称 : wxRequest()
     * 功  能 : 请求Access_Token令牌信息
     * 输  入 : (String) $wxAppId     => '小程序AppId';
     * 输  入 : (String) $wxAppSecret => '小程序AppSecret秘钥';
     * 输  入 : (String) $tokenDir    => '文件保存位置';
     * 输  出 : ['msg'=>'success','data'=>true]
     * 创  建 : 2018/08/15 13:03
     */
    public static function wxRequest($wxAppId,$wxAppSecret,$tokenDir)
    {
        // 验证返回数据
        if(!$wxAppId) return self::returnArray(
            'error', '请发送小程序AppId'
        );
        if(!$wxAppSecret) return self::returnArray(
            'error', '请发送小程序AppSecret秘钥'
        );
        if(file_exists($tokenDir.'access_token.text')){
            // 获取文件内access_token令牌信
            $access_token_Str = file_get_contents(
                $tokenDir.'access_token.text'
            );
            // 解析数据
            $access_token_Arr = json_decode($access_token_Str,true);
            // 判断令牌失效期
            if( (time() - $access_token_Arr['time']) < 3600 )
            {
                return self::returnArray('success', $access_token_Arr);
            }
        }
        // 获取请求授权令牌类地址
        $url = self::$AccessTokenConfig['AccessTokenUrl'];
        // 拼接URL地址
        $url.= '?grant_type=client_credential';
        $url.= '&appid='.$wxAppId;
        $url.= '&secret='.$wxAppSecret;
        // 发送UTL请求,获取accessToken值
        $res = self::curlGet($url);
        // 解析返回数据
        $resArr = json_decode($res,true);
        // 判断数据是否正确
        if(!$resArr) return self::returnArray(
            'error', '请求数据失败'
        );
        // 判断数据是否正确
        if(!empty($resArr['errcode'])) return self::returnArray(
            'error', json_encode($resArr)
        );
        $resArr['time'] = time();
        // 判断是否有令牌保存目录，如果没有执行创建
        if(!is_dir($tokenDir)) mkdir($tokenDir);
        // 将数据写入text文件
        file_put_contents(
            $tokenDir.'access_token.text',
            json_encode($resArr)
        );
        return self::returnArray('success', $resArr);
    }

    /**
     * 名  称 : curlGet()
     * 功  能 : Curl请求发送数据
     * 创  建 : 2018/08/15 13:05
     */
    private static function curlGet($push_url,$post_data=[])
    {
        // 创建一个新cURL资源
        $ch = curl_init();

        // 设置URL和相应的选项
        curl_setopt($ch,CURLOPT_URL,$push_url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        // 不做证书效验，部署在Linux环境改为true
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);

        $file_contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);

        // 返回结果
        return $file_contents;
    }

    /**
     * 名  称 : returnArray()
     * 功  能 : 返回数据
     * 创  建 : 2018/08/15 13:06
     */
    private static function returnArray($msg,$data = false)
    {
        return [ 'msg'=>$msg , 'data'=>$data ];
    }
}