<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  SmallcodeValidator.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 22:04
 *  文件描述 :  小程序码管理验证器
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\validator;
use think\Validate;

class SmallcodeValidate extends Validate
{
    /**
     * 名  称 : $rule
     * 功  能 : 验证规则
     * 输  入 : $post['scene']      => '发送携带的参数';
     * 输  入 : $post['page']       => '页面地址;
     * 输  入 : $post['width']      => '二维码尺寸;
     * 输  入 : $post['auto_color'] => '是否自动配置线条颜色 true / false;
     * 输  入 : $post['line_color'] => '使用 rgb 设置颜色：{"r":"0","g":"0","b":"0"}
     * 输  入 : $post['is_hyaline'] => '是否需要透明底色 true / false;
     * 创  建 : 2018/08/30 22:13
     */
    protected $rule =   [
        'scene'      => 'require|max:32',
        'page'       => 'require',
        'width'      => 'require|number',
        'auto_color' => 'require',
        'line_color' => 'require',
        'is_hyaline' => 'require',
    ];

    /**
     * 名  称 : $message()
     * 功  能 : 设置验证信息
     * 创  建 : 2018/08/30 22:13
     */
    protected $message  =   [
        'scene.require'      => '请正确发送携带的参数',
        'scene.max'          => '请正确发送携带的参数',
        'page.require'       => '请正确输入页面地址',
        'width.require'      => '请正确输入二维码尺寸',
        'width.number'       => '请正确输入二维码尺寸',
        'auto_color.require' => '是否自动配置线条颜色 true / false',
        'line_color.require' => '使用 rgb 设置颜色：{"r":"0","g":"0","b":"0"}',
        'is_hyaline.require' => '是否需要透明底色 true / false',
    ];
}
