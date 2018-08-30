<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  SmallcodeDao.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/30 22:04
 *  文件描述 :  小程序码管理数据层
 *  历史记录 :  -----------------------
 */
namespace app\distributor_module\working_version\v1\dao;
use app\distributor_module\working_version\v1\model\SmallcodeModel;

class SmallcodeDao implements SmallcodeInterface
{
    /**
     * 名  称 : smallcodeCreate()
     * 功  能 : 管理小程序码数据处理
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
    public function smallcodeCreate($post)
    {
        // TODO :  SmallcodeModel 模型
    }
}
