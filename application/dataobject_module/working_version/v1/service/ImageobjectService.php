<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ImageobjectService.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\service;
use app\dataobject_module\working_version\v1\dao\ImageobjectDao;
use app\dataobject_module\working_version\v1\library\ImageobjectLibrary;
use app\dataobject_module\working_version\v1\validator\ImageobjectValidatePost;
use app\dataobject_module\working_version\v1\validator\ImageobjectValidateGet;
use app\dataobject_module\working_version\v1\validator\ImageobjectValidatePut;
use app\dataobject_module\working_version\v1\validator\ImageobjectValidateDelete;

class ImageobjectService
{
    /**
     * 名  称 : imageobjectAdd()
     * 功  能 : 添加图片逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']    => '数据表名';
     * 输  入 : (String) $post['picture_data']  => '图片数据';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/03 20:00
     */
    public function imageobjectAdd($post)
    {
        // 实例化验证器代码
        $validate  = new ImageobjectValidatePost();
        
        // 验证数据
        if (!$validate->scene('edit')->check($post)) {
            return \RSD::returnData($validate->getError(),'',false);
        }

        // 转换表名为小写
        $post['table_name'] = strtolower($post['table_name']);

        // 处理文件上传数据
        $post['picture_data'] = $this->imageIsFileUpdate(
            'picture_data',
            '/'.config('dataobject_v1_config.web_img_dir').
            '/'.config('dataobject_v1_config.web_images').$post['table_name']
        );
        
        // 实例化Dao层数据类
        $imageobjectDao = new ImageobjectDao();
        
        // 执行Dao层逻辑
        $res = $imageobjectDao->imageobjectCreate($post);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }

    /**
     * 处理文件上传方法
     */
    private function imageIsFileUpdate($fileName, $fileDir)
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($fileName);

        // 判断文件是否上传
        if(empty($file)) \RSD::JsonDie(
            'E30102.picture_data No pictures uploaded'
        );

        // 判断图片是否操作大小限制
        if($file->getInfo('size')>=500000) \RSD::JsonDie(
            'E30200.picture_data File Size Exceeds Limit'
        );

        // 获取图片类型数，拆分成数组
        $typeArr = explode('/',$file->getInfo('type'));

        // 判断图片类型是否正确
        if($typeArr[0]!=='image') \RSD::JsonDie(
            'E30201.picture_data File Type Not Supported'
        );

        // 定义图片类型
        $typeCon = ['jpg', 'jpeg', 'png'];

        // 判断图片类型是否正确
        if(!in_array($typeArr[1],$typeCon)) \RSD::JsonDie(
            'E30201.picture_data File Support jpg|jpeg|png'
        );

        // 处理路劲
        $fileDir = trim($fileDir,'./');
        $fileDir = trim($fileDir,'/');
        $fileDir = rtrim($fileDir,'/');

        // 移动到框架应用根目录/uploads/ 目录下 ，
        $info = $file->move('./'.$fileDir.'/');

        // 获取 20160820/42a79759f284b767dfcb2a0197904287.jpg
        return '/'.$fileDir.'/'.$info->getSaveName();
    }
}