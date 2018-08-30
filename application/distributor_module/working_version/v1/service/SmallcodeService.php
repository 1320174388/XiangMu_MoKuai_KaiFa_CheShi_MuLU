<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  SmallcodeService.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 22:04
 *  文件描述 :  小程序码管理逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\service;
use app\distributor_module\working_version\v1\dao\SmallcodeDao;
use app\distributor_module\working_version\v1\library\AccessTokenRequest;
use app\distributor_module\working_version\v1\library\Small_Program_Generate;
use app\distributor_module\working_version\v1\validator\SmallcodeValidate;

class SmallcodeService
{
    /**
     * 名  称 : smallcodeAdd()
     * 功  能 : 管理小程序码逻辑
     * 变  量 : --------------------------------------
     * 输  入 : $post['scene']      => '发送携带的参数';
     * 输  入 : $post['page']       => '页面地址;
     * 输  入 : $post['width']      => '二维码尺寸;
     * 输  入 : $post['auto_color'] => '是否自动配置线条颜色 true / false;
     * 输  入 : $post['line_color'] => '使用 rgb 设置颜色：{"r":"0","g":"0","b":"0"}
     * 输  入 : $post['is_hyaline'] => '是否需要透明底色 true / false;
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/30 22:13
     */
    public function smallcodeAdd($post)
    {
        // 实例化验证器代码
        $validate  = new SmallcodeValidate();

        // 验证数据
        if (!$validate->scene('edit')->check($post)) {
            return ['msg'=>'error','data'=>$validate->getError()];
        }

        // 1.去掉 page 首字符 /
        // 2.判断 line_color 是不是ＪＳＯＮ数据
        // 3.判断传值 auto_color 是 true 或 false
        // 4.判断传值 is_hyaline 是 true 或 false
        $post['page'] = trim($post['page'],'/');
        if(is_null(json_decode($post['line_color']))){
            return returnData('error','line_color：{"r":"0","g":"0","b":"0"}');
        }
        $post['auto_color'] = ($post['auto_color']=='true')? true : false;
        $post['is_hyaline'] = ($post['is_hyaline']=='true')? true : false;

        // 解析line_color数据
        $post['line_color'] = json_decode($post['line_color'],true);

        // 获取接口调用凭证
        $accessTokenArr = AccessTokenRequest::wxRequest(
            config('v1_config.Wx_AppId'),
            config('v1_config.Wx_AppSecret'),
            './project_access_token/'
        );
        // 获取二维码
        $wx_code = Small_Program_Generate::SmallRequest(
            $accessTokenArr['data']['access_token'],
            [
                'scene'      => $post['scene'],
                'page'       => $post['page'],
                'width'      => $post['width'],
                'auto_color' => $post['auto_color'],
                'line_color' => $post['line_color'],
                'is_hyaline' => $post['is_hyaline'],
            ],
            './uploads/wx_code/',$post['scene']
        );

        // 返回数据
        return \RSD::wxReponse($wx_code,'L',trim($wx_code['data'],'.'));
    }
}
