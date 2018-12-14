<?php
/**
 *  文件名称 :  KalgorithmService.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\service;
use app\kalgorithm_module\working_version\v1\dao\KalgorithmDao;
use app\kalgorithm_module\working_version\v1\library\KalgorithmLibrary;
use app\kalgorithm_module\working_version\v1\validator\KalgorithmValidatePost;
use app\kalgorithm_module\working_version\v1\validator\KalgorithmValidateGet;
use app\kalgorithm_module\working_version\v1\validator\KalgorithmValidatePut;
use app\kalgorithm_module\working_version\v1\validator\KalgorithmValidateDelete;

class KalgorithmService
{
    /**
     * 名  称 : kalgorithmShow()
     * 功  能 : 获取K匿名算法数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (Number) $get['k_number']          => 'K值';
     * 输  入 : (String) $get['identifier']        => '标识符';
     * 输  入 : (String) $get['quasi_identifier']  => '准标识符';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/10 11:07
     */
    public function kalgorithmShow($get)
    {
        // 实例化验证器代码
        $validate  = new KalgorithmValidateGet();
        
        // 验证数据
        if (!$validate->scene('edit')->check($get)) {
            return \RSD::returnData($validate->getError(),'',false);
        }
        
        // 实例化Dao层数据类
        $kalgorithmDao = new KalgorithmDao();
        
        // 执行Dao层逻辑
        $res = $kalgorithmDao->kalgorithmSelect($get);

        // TODO : 处理数据
        $this->processingData($get, $res['data']);
        
        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }

    /**
     * 名  称 : processingData()
     * 功  能 : 处理数据
     * 变  量 : --------------------------------------
     * 输  入 : (Number) $get['k_number']          => 'K值';
     * 输  入 : (String) $get['identifier']        => '标识符';
     * 输  入 : (String) $get['quasi_identifier']  => '准标识符';
     * 输  入 : (Array)  $dataArr                  => '被处理数据';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/13 09:58
     */
    private function processingData($get, &$dataArr)
    {
        // TODO : 生成分类树
        $tree   = $this->generateClassTree($get, $dataArr);

        // TODO : 获取所有属性总差值
        $valNum = $this->totalDifference($dataArr);

        // TODO : 获取分类树层级数量
        $treeNu = $this->hierarchyQuantity($tree);

        // TODO : 聚类处理
        $data = $this->clustering($get['k_number'], $dataArr, $tree, $valNum, $treeNu);

        // TODO : 隐藏标识信息
        $this->hideListData($get, $data);

        // TODO : 打印数据
        die(json_encode($data,320));
    }

    /**
     * 名  称 : hideListData()
     * 功  能 : 隐藏标识符信息
     * 变  量 : --------------------------------------
     * 输  入 : (Number) $get['k_number']          => 'K值';
     * 输  入 : (String) $get['identifier']        => '标识符';
     * 输  入 : (String) $get['quasi_identifier']  => '准标识符';
     * 输  入 : (Array)  $dataArr                  => '被处理数据';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/13 09:58
     */
    private function hideListData($get, &$dataArr)
    {
        // 验证是否有数据
        if(empty($get['identifier'])) return FALSE;

        // 验证状态是否正确
        if(!is_string($get['identifier'])){
            \RSD::JsonDie('E10002.identifier input error');
        }

        // 拆分标识符字符串为数组
        $array = explode(',',$get['identifier']);

        // 处理数据
        foreach ($dataArr as $k1 => $v1)
        {
            foreach ($array as $v2)
            {
                if(array_key_exists($v2,$v1))
                {
                    unset($dataArr[$k1][$v2]);
                }
            }
        }
    }

    /**
     * 名  称 : generateClassTree()
     * 功  能 : 生成分类树
     * 变  量 : --------------------------------------
     * 输  入 : (Number) $get['k_number']          => 'K值';
     * 输  入 : (String) $get['identifier']        => '标识符';
     * 输  入 : (String) $get['quasi_identifier']  => '准标识符';
     * 输  入 : (Array)  $dataArr                  => '被处理数据';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/13 11:37
     */
    private function generateClassTree($get, &$dataArr)
    {
        // TODO : 定义分类树
        $tree =  [
            [
                'id' => 1,
                'pid' => 0,
                'attr' => 'tree_root',
                'pach' => 1
            ]
        ];

        // TODO : 写入车牌号分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'plate_number', $dataArr, function($val, $name) {

                return explode(' ', $val[$name])[0];

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入汽车类型分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'license_type', $dataArr, function($val, $name) {

                return $val[$name];

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入汽车颜色分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'license_color', $dataArr, function($val, $name) {

                return $val[$name];

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入生产厂分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'production_plant', $dataArr, function($val, $name) {

                return $val[$name];

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入身份证分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'id_number', $dataArr, function($val, $name) {

                return substr($val[$name],0,6);

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入用户性别分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'user_sex', $dataArr, function($val, $name) {

                return $val[$name];

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入用户性别分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'user_phone', $dataArr, function($val, $name) {

                return substr($val[$name],0,3);

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入地址信息分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'user_address', $dataArr, function($val, $name) {

                return substr($val[$name],0, 9);

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        die( json_encode( $tree ) );
    }

    /**
     * 名  称 : totalDifference()
     * 功  能 : 获取差值
     * 变  量 : --------------------------------------
     * 输  入 : (Array)  $dataArr  =>  '被处理数据';
     * 输  出 : (Array)  $totalNum =>  '总差值';
     * 创  建 : 2018/12/13 11:57
     */
    private function totalDifference($dataArr, $totalNum = [])
    {
        // TODO : 获取车牌发放时间年份
        $paymentTimeArr = $this->subtree($dataArr, function($val) {
            $str = explode('.', $val['payment_time'])[0];
            return (int)$str;
        });

        // TODO : 获取车牌车辆号
        $licenseNumberArr = $this->subtree($dataArr, function($val) {
            return $val['license_number'];
        });

        // TODO : 获取车辆排量
        $displacementArr = $this->subtree($dataArr, function($val) {
            return $val['displacement'];
        });

        // TODO : 合并数组
        $totalNum = array_merge( $paymentTimeArr, $licenseNumberArr );
        $totalNum = array_merge( $totalNum, $displacementArr );

        // TODO : 合数组排序
        sort( $totalNum );

        // TODO : 返回总差值
        return (int) bcsub( $totalNum[count($totalNum)-1], $totalNum[0] );

    }

    /**
     * 名  称 : hierarchyQuantity()
     * 功  能 : 获取分类树层级数量
     * 变  量 : --------------------------------------
     * 输  入 : (Array)  $tree    =>  '分类树数据';
     * 输  出 : (Array)  $treeNum =>  '层级数量';
     * 创  建 : 2018/12/13 11:57
     */
    private function hierarchyQuantity( $tree, $treeNum=0 )
    {
        if(is_array($tree))
        {
            $treeNum++;
            $arr = [];
            // 循环获取层级数量
            foreach( $tree as $k => $v )
            {
                $arr[] = $this->hierarchyQuantity($v, $treeNum);
            }
            rsort($arr);
            $treeNum = $arr[0];
        }
        return (int) $treeNum;
    }


    /**
     * 名  称 : subtree()
     * 功  能 : 获取分类子树
     * 变  量 : --------------------------------------
     * 输  入 : (Array)  $tree     =>  '分类树';
     * 输  出 : (String) $name     =>  '属性';
     * 输  入 : (Array)  $dataArr  =>  '被处理数据';
     * 输  出 : (Array)  $treeArr  =>  '子树数组';
     * 创  建 : 2018/12/13 11:57
     */
    private function subtree($tree, $name, $dataArr, $function, $func)
    {
        // TODO : 遍历所有数据
        foreach ( $dataArr as $key => $val )
        {
            // 写入数据到数组
            $treeArr[] = $function($val, $name);
        }

        // TODO : 最后处理数据，排序,返回数据
        $treeArr = array_unique( $treeArr );
        sort( $treeArr );

        // TODO : 获取数组长度
        $size = count( $tree );

        // TODO : 遍历新数据
        $n = 1;
        $treeArrs = [];
        $pid = $size+1;
        if($n == 1){
            $treeArrs[] = [
                'id' => ++$size,
                'pid' => 1,
                'attr' => $name,
                'pach' => 2
            ];
        }
        foreach ( $treeArr as $key => $val )
        {
            // 写入数据到数组
            $treeArrs[] = $func($size, $name, $val, $n, $pid);
            $n += 1;
        }

        return $treeArrs;
    }

    /**
     * 名  称 : treeArray()
     * 功  能 : 获取分类子树数组
     * 变  量 : --------------------------------------
     * 输  入 : (String)  $size  =>  '长度';
     * 输  出 : (String)  $name  =>  '属性';
     * 输  出 : (String)  $value =>  '属性值';
     * 输  出 : (String)  $n     =>  '判断条件';
     * 创  建 : 2018/12/13 11:57
     */
    private function treeArray(&$size, $name, $value, $n, $pid)
    {
        return [
            'id' => ++$size,
            'pid' => $pid,
            'attr' => $value,
            'pach' => 3
        ];
    }



    /**
     * 名  称 : clustering()
     * 功  能 : 聚类处理
     * 变  量 : --------------------------------------
     * 输  入 : (Number) $kn       =>  '聚类K值';
     * 输  入 : (Array)  $dataArr  =>  '被处理数据';
     * 输  出 : (Array)  $treeArr  =>  '分类树数组';
     * 输  出 : (Array)  $valNum   =>  '属性总差值';
     * 输  出 : (Array)  $treeNu   =>  '分类树层数';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/13 11:38
     */
    private function clustering($kn, $dataArr, $treeArr, $valNum, $treeNu)
    {
        // TODO : 随机选择一条记录
        $data1 =  $this->randRecord($dataArr);

        // TODO : 随机选择一条记录
        $data2 =  $this->randRecord($dataArr);

        // TODO : 判断当前数据长度
        if( $kn < count($dataArr) )
        {
            // TODO : 添加到簇中
            $r = [ $data1, $data2 ];

            // TODO : 获取簇差值
            $rDiff = $this->totalDifference($r);

            // TODO : 获取分类层级


            die( (string)$rDiff );

            return $r;
        }

        // TODO : 暂时返回所有数据
        return $dataArr;

    }

    /**
     * 名  称 : hierarchySubtree()
     * 功  能 : 获取分类属性子树层级
     * 变  量 : --------------------------------------
     * 输  出 : (Array)  $treeArr  =>  '分类树数组';
     * 输  出 : (Array)  $r        =>  '簇数组';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/14 22:49
     */
    private function hierarchySubtree($treeArr, $r)
    {

    }

    /**
     * 名  称 : randRecord()
     * 功  能 : 随机抽取出一条记录
     * 变  量 : --------------------------------------
     * 输  入 : (Array)  $dataArr  => '被处理数据';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/13 11:38
     */
    private function randRecord(&$arr)
    {
        if( !empty($arr) )
        {
            // 获取随机数
            $num = mt_rand(0,count($arr)-1);

            // 获取数据
            $rowData = $arr[$num];

            // 清除数据
            unset($arr[$num]);

            // 返回数据
            return $rowData;
        }
    }
}