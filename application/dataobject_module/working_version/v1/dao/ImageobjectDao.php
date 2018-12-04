<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ImageobjectDao.php
 *  开发人员 :  Shi Guang Yu
 *  联系电话 :  18646731096
 *  创建日期 :  2018/11/22 22:07
 *  文件描述 :  数据操作对象数据层
 *  历史记录 :  -----------------------
 */
namespace app\dataobject_module\working_version\v1\dao;
use app\dataobject_module\working_version\v1\model\ImageobjectModel;

class ImageobjectDao implements ImageobjectInterface
{
    /**
     * 名  称 : imageobjectCreate()
     * 功  能 : 添加图片数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['table_name']    => '数据表名';
     * 输  入 : (String) $post['picture_data']  => '图片数据';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/03 20:00
     */
    public function imageobjectCreate($post)
    {
        // TODO : 实例化数据模型
        $imageObject = new ImageobjectModel();
        // TODO : 配置模型表名
        $imageObject->setTableName($post['table_name']);
        // TODO : 执行写入数据
        try{
            $imageObject->image_url  = $post['picture_data'];
            $imageObject->image_time = time();
            $imageObject->save();
        }catch (\Exception $e){
            return \RSD::returnModel(
                false,'E10002.$post[\'picture_data\'] Parameter Formatting Error'
            );
        }
        // 处理函数返回值
        return \RSD::returnModel($imageObject,'E10002');
    }

    /**
     * 名  称 : imageobjectSelect()
     * 功  能 : 获取图片数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['table_name']  => '数据表名';
     * 输  入 : (String) $get['json_limit']  => '分页字段';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/04 09:42
     */
    public function imageobjectSelect($get)
    {
        // TODO : 实例化数据模型
        $imageObject = new ImageobjectModel();
        // TODO : 配置模型表名
        $imageObject->setTableName($get['table_name']);
        // TODO : 定义分页字段
        if($get['json_limit']!=='NOT'){
            $this->isSetLimit(0,'offset',$get);
            $this->isSetLimit(1,'length',$get);
            $imageObject = $imageObject->limit(
                $get['json_limit'][0],$get['json_limit'][1]
            );
        }
        // TODO : 执行查询数据
        try{
            $res = $imageObject->select()->toArray();
        }catch (\Exception $e){
            die(\RSD::wxReponse(
                \RSD::returnData(
                    'E40000.Query parameter error','', false
                ),'S'
            ));
        }
        // 处理函数返回值
        return \RSD::returnModel($res,'E40000');

    }

    /**
     * 验证分页数据是否存在
     */
    private function isSetLimit($key,$str = '',$get)
    {
        if(
            (!array_key_exists($key,$get['json_limit'])) ||
            (!is_numeric($get['json_limit'][$key]))
        ){
            die(\RSD::wxReponse(
                \RSD::returnData(
                    'E40000.json_limit '.$str.' Query parameter error','', false
                ),'S'
            ));
        }
    }

    /**
     * 名  称 : imageobjectDelete()
     * 功  能 : 删除图片数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['table_name'] => '数据表名';
     * 输  入 : (String) $delete['images_id']  => '图片ID';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/04 09:53
     */
    public function imageobjectDelete($delete)
    {
        // TODO : 实例化数据模型
        $imageObject = new ImageobjectModel();
        // TODO : 配置模型表名
        $imageObject->setTableName($delete['table_name']);
        // TODO : 执行删除数据
        try{
            $imageObject = $imageObject->where(
                $delete['table_name'].'_id',$delete['images_id']
            );
            // 克隆对象
            $image1 = clone($imageObject);
            $image2 = clone($imageObject);
            // 验证要删除的图片是否存在
            $image1 = $image1->find();
            if(empty($image1)){ \RSD::JsonDie(
                'E40300.images_id Primary Key Does Not Exist, Delete Failed'
            );}else{
                if (is_file('.'.$image1['image_url'])){
                    unlink('.'.$image1['image_url']);
                }
            };

            $image2->delete();
        }catch (\Exception $e){
            return \RSD::returnModel(
                false,'E40300.images_id Primary Key Does Not Exist, Delete Failed'
            );
        }
        // 处理函数返回值
        return \RSD::returnModel(true,'E10002');
    }
}