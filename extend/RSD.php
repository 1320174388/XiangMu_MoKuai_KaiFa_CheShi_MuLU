<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  RSD.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/15 17:01
 *  文件描述 :  项目开发 ：返回数据函数类
 *  历史记录 :  -----------------------
 */
class RSD extends ExceptionCodeConfig
{
    /**
     * 名 称 : $rsdConfig
     * 功 能 : 返回数据配置信息
     * 创 建 : 2018/08/15 17:02
     */
    private static $rsdConfig = array(
        // Service逻辑层状态
        'Service'  => 'S',
        // Library自定义类状态
        'Lirbrary' => 'L',
        // Function函数状态
        'Function' => 'F',
        // Dao数据层状态
        'Dao'      => 'D'
    );

    /**
     * 名 称 : __construct()
     * 功 能 : 定义配置信息数据
     * 创 建 : 2018/08/15 17:05
     */
    private function __construct()
    {
        // TODO: 禁止外部实例化
    }

    /**
     * 名 称 : __clone()
     * 功 能 : 禁止外部克隆该实例
     * 创 建 : 2018/08/15 17:07
     */
    private function __clone()
    {
        // TODO: 禁止外部克隆该实例
    }

    /**
     * 名  称 : returnData()
     * 功  能 : 返回函数数据
     * 输  入 : (Array)  $Array   => '需要验证数据';
     * 输  入 : (String) $type    => '验证数据类型';
     * 输  入 : (String) $success => '正确提示信息';
     * 输  入 : (String) $error   => '正确提示信息';
     * 创  建 : 2018/08/15 17:10
     */
    public static function wxReponse($Array,$type,$success='',$error='')
    {
        // 验证Service层数据
        if($type==self::$rsdConfig['Service'])
        {
            return self::serviceValidate($Array,$success,$error);
        }
        // 验证Library层数据
        if($type==self::$rsdConfig['Lirbrary'])
        {
            return self::libraryValidate($Array,$success,$error);
        }
        // 验证Function函数数据
        if($type==self::$rsdConfig['Function'])
        {
            return self::functionValidate($Array,$success,$error);
        }
        // 验证Dao层数据
        if($type==self::$rsdConfig['Dao'])
        {
            return self::daoValidate($Array,$success,$error);
        }
    }

    /**
     * 名  称 : serviceValidate()
     * 功  能 : 验证Service层数据
     * 输  入 : (Array)  $Array   => '需要验证数据';
     * 输  入 : (String) $success => '正确提示信息';
     * 输  入 : (String) $error   => '正确提示信息';
     * 创  建 : 2018/08/15 17:10
     */
    private static function serviceValidate($Array,$success='',$error='')
    {
        // 返回错误数据
        if((!is_array($Array))||(!array_key_exists("code",$Array)))
        {
            // 返回异常数据
            return self::returnJson(
                '-1', 'Service逻辑层返回数据异常', false
            );
        }
        // 返回错误数据
        if($Array['code'] != '0')
        {
            if( !empty($error) )
            {
                return self::returnJson(
                    $Array['code'], $error,$Array['data']
                );
            }
            return self::returnJson(
                $Array['code'], $Array['msg'],$Array['data']
            );
        }
        // 返回正确数据
        if($Array['code'] == '0')
        {
            if( !empty($success) )
            {
                return self::returnJson(
                    $Array['code'], $success,$Array['data']
                );
            }
            return self::returnJson(
                $Array['code'], $Array['msg'], $Array['data']
            );
        }
    }

    /**
     * 名  称 : libraryValidate()
     * 功  能 : 验证Library层数据
     * 输  入 : (Array)  $Array   => '需要验证数据';
     * 输  入 : (String) $success => '正确提示信息';
     * 输  入 : (String) $error   => '正确提示信息';
     * 创  建 : 2018/08/15 17:10
     */
    private static function libraryValidate($Array,$success='',$error='')
    {
        // 返回错误数据
        if((!is_array($Array))||(!array_key_exists("code",$Array)))
        {
            // 返回异常数据
            return self::returnData(
                '-1', 'Library类返回数据异常', false
            );
        }
        // 返回错误数据
        if($Array['code'] != '0')
        {
            if( !empty($error) )
            {
                return self::returnData(
                    $Array['code'], $error,$Array['data']
                );
            }
            return self::returnData(
                $Array['code'], $Array['msg'],$Array['data']
            );
        }
        // 返回正确数据
        if($Array['code'] == '0')
        {
            if( !empty($success) )
            {
                return self::returnData(
                    $Array['code'], $success,$Array['data']
                );
            }
            return self::returnData(
                $Array['code'], $Array['msg'], $Array['data']
            );
        }
    }

    /**
     * 名  称 : functionValidate()
     * 功  能 : 验证Function函数数据
     * 输  入 : (Array)  $Array   => '需要验证数据';
     * 输  入 : (String) $success => '正确提示信息';
     * 输  入 : (String) $error   => '正确提示信息';
     * 创  建 : 2018/08/15 17:10
     */
    private static function functionValidate($Array,$success='',$error='')
    {
        // 返回错误数据
        if((!is_array($Array))||(!array_key_exists("code",$Array)))
        {
            // 返回异常数据
            return self::returnData(
                '-1', 'Function函数返回数据异常', false
            );
        }
        // 返回错误数据
        if($Array['code'] != '0')
        {
            if( !empty($error) )
            {
                return self::returnData(
                    $Array['code'], $error,$Array['data']
                );
            }
            return self::returnData(
                $Array['code'], $Array['msg'],$Array['data']
            );
        }
        // 返回正确数据
        if($Array['code'] == '0')
        {
            if( !empty($success) )
            {
                return self::returnData(
                    $Array['code'], $success,$Array['data']
                );
            }
            return self::returnData(
                $Array['code'], $Array['msg'], $Array['data']
            );
        }
    }

    /**
     * 名  称 : daoValidate()
     * 功  能 : 验证Dao层数据
     * 输  入 : (Array)  $Array   => '需要验证数据';
     * 输  入 : (String) $success => '正确提示信息';
     * 输  入 : (String) $error   => '正确提示信息';
     * 创  建 : 2018/08/15 17:10
     */
    private static function daoValidate($Array,$success='',$error='')
    {
        // 返回错误数据
        if((!is_array($Array))||(!array_key_exists("code",$Array)))
        {
            // 返回异常数据
            return self::returnData(
                '-1','Dao数据层返回参数异常', false
            );
        }
        // 返回错误数据
        if($Array['code'] != '0')
        {
            if( !empty($error) )
            {
                return self::returnData(
                    $Array['code'], $error,$Array['data']
                );
            }
            return self::returnData(
                $Array['code'], $Array['msg'],$Array['data']
            );
        }
        // 返回正确数据
        if($Array['code'] == '0')
        {
            if( !empty($success) )
            {
                return self::returnData(
                    $Array['code'], $success,$Array['data']
                );
            }
            return self::returnData(
                $Array['code'], $Array['msg'], $Array['data']
            );
        }
    }

    /**
     * 名  称 : returnModel()
     * 功  能 : 验证Model层数据
     * 输  入 : (Array)  $Array   => '需要验证数据';
     * 输  入 : (Array)  $errcode => '需要验证数据';
     * 输  入 : (String) $success => '正确提示信息';
     * 输  入 : (String) $error   => '正确提示信息';
     * 创  建 : 2018/08/15 17:10
     */
    public static function returnModel($Array,$errcode,$success='',$error='')
    {
        // 返回错误格式信息
        if(!$Array){
            // 判断错误码是否存在
            self::errorcodeVal($errcode,$error);
            return self::returnData(
                $errcode, $error,false
            );
        }
        // 判断错误码是否存在
        if($success){
            $msg = $success;
        }else {
            $msg = 'Success';

        }
        // 返回正确格式信息
        return self::returnData(
            '0', $msg,$Array
        );
    }

    /**
     * 名  称 : returnData()
     * 功  能 : 返回函数数据
     * 输  入 : (string) $code => '错误码'
     * 输  入 : (string) $msg  => '提示信息'
     * 输  入 : ( data ) $data => '任意数据格式内容'
     * 输  出 : [ 'code' => '错误码','msg' => '提示信息', 'data' => '返回数据' ]
     * 创  建 : 2018/08/15 17:10
     */
    public static function returnData($code='',$msg='',$data = false)
    {
        // 判断错误码是否存在
        self::errorcodeVal($code,$msg);
        // 返回数据
        return [
            'code'  => $code,
            'msg'   => $msg,
            'data'  => $data
        ];
    }

    /**
     * 名  称 : returnJson()
     * 功  能 : 返回json数据
     * 输  入 : (int)    $errCode  => '返回状态编号';
     * 输  入 : (string) $retMsg  => '提示信息'
     * 输  入 : (data)   $retData => '任意数据格式内容'
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":"返回数据"}
     * 创  建 : 2018/08/15 17:13
     */
    public static function returnJson($errCode,$retMsg='',$retData=false)
    {
        // 判断错误码是否存在
        self::errorcodeVal($errCode,$retMsg);
        // 返回数据
        return json_encode([
            'errCode' => $errCode,
            'retMsg'  => $retMsg,
            'retData' => $retData
        ], 320);
    }

    /**
     * 名  称 : errorcodeVal()
     * 功  能 : 验证错误码
     * 输  入 : (String)  $code => '错误码';
     * 输  入 : (String)  $msg  => '内容';
     * 创  建 : 2018/08/15 17:10
     */
    private static function errorcodeVal(&$code,&$msg)
    {
        // 判断错误码是否存在
        if(($code!='0')&&($code!='-1')){
            // 拆分错误码
            $codeArr = explode('.',$code);
            if(array_key_exists(1,$codeArr))
            {
                $code = $codeArr[0];
                if(empty($msg))
                {
                    $msg  = $codeArr[1];
                }
            }

            // 判断错误码是否存在
            try{
                if((constant('self::'. $code))&&(empty($msg))) {
                    $msg = constant('self::'. $code);
                }
            }catch (\Exception $e){
                die($e->getMessage().", Error codes need to be defined.");
            }
        }
    }

    /**
     * 名  称 : JsonDie()
     * 功  能 : 强制输出JSON错误
     * 输  入 : (int)    $errCode  => '返回状态编号';
     * 输  入 : (string) $retMsg  => '提示信息'
     * 输  入 : (data)   $retData => '任意数据格式内容'
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":"返回数据"}
     * 创  建 : 2018/08/15 17:13
     */
    public static function JsonDie($errCode,$retMsg='',$retData=false)
    {
        // 判断错误码是否存在
        self::errorcodeVal($errCode,$retMsg);
        // 返回数据
        die(json_encode([
            'errCode' => $errCode,
            'retMsg'  => $retMsg,
            'retData' => $retData
        ], 320));
    }
}

/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ExceptionCodeConfig.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/15 17:01
 *  文件描述 :  项目开发：Api ~ 返回错误码列表
 *  历史记录 :  -----------------------
 */
class ExceptionCodeConfig
{
    // TODO : E10000 -> 某个参数字段不能为空
    const E10000 = 'Invalid parameter.';
    // TODO : E10001 -> 某个参数值超过定义范围
    const E10001 = 'Parameter Beyond The Scope.';
    // TODO : E10002 -> 某个参数值格式错误
    const E10002 = 'Parameter Formatting Error.';
    // TODO : E10003 -> 某个参数值类型错误
    const E10003 = 'Parameter Error In Type.';
    // TODO : E10004 -> 某个秘钥与预定义值不一样
    const E10004 = 'Parameter secret key error';
    // TODO : E20000 -> 权限不足
    const E20000 = 'No Authority.';
    // TODO : E30100 -> 图片大小超过限制
    const E30100 = 'Image Size Exceeds.';
    // TODO : E30102 -> 没有图片上传
    const E30102 = 'No pictures uploaded';
    // TODO : E30101 -> 不支持图片类型
    const E30101 = 'Image Type Is Not Supported.';
    // TODO : E30200 -> 文件大小超过限制
    const E30200 = 'File Size Exceeds Limit.';
    // TODO : E30201 -> 不支持文件类型
    const E30201 = 'File Type Not Supported.';
    // TODO : E30300 -> 音频大小超过限制
    const E30300 = 'Audio Size Exceeds Limitation.';
    // TODO : E30301 -> 不支持音频类型
    const E30301 = 'Audio Type Is Not Supported.';
    // TODO : E30400 -> 视频大小超过限制
    const E30400 = 'Video Size Exceeds Limitation.';
    // TODO : E30401 -> 不支持视频类型
    const E30401 = 'Video Type Is Not Supported.';
    // TODO : E40000 -> 没有查询到数据
    const E40000 = 'Query Failed.';
    // TODO : E40100 -> 某个参数唯一
    const E40100 = 'Parameter Uniqueness, Add Failed.';
    // TODO : E40200 -> 要修改的主键不存在
    const E40200 = 'Primary Key Does Not Exist, Modify Failed.';
    // TODO : E40201 -> 修改数据与原数据没有变化
    const E40201 = 'Data Unchanged, Modify Failed.';
    // TODO : E40300 -> 要删除的主键不存在
    const E40300 = 'Primary Key Does Not Exist, Delete Failed.';
    // TODO : E40400 -> 默认页面找不到错误
    const E40400 = 'Page cannot be found';
    // TODO : S00001 -> 代码执行失败或系统超时
    const S00001 = 'System Error.';
}