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

        // TODO : 泛化处理所有数据
        $this->generalization($dataArr);

        // TODO : 聚类处理
        $data = $this->clustering($get['k_number'], $dataArr, $tree, $valNum, $treeNu);

        // TODO : 隐藏标识信息
        $this->hideListData( $get, $data );

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

            $tree, 'plate_number', $dataArr, function(&$val, $name) {

                $val[$name] = explode(' ', $val[$name])[0];

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入汽车类型分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'license_type', $dataArr, function(&$val, $name) {

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入汽车颜色分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'license_color', $dataArr, function(&$val, $name) {

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入生产厂分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'production_plant', $dataArr, function(&$val, $name) {

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入身份证分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'id_number', $dataArr, function(&$val, $name) {

                $val[$name] = substr($val[$name],0,6);

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入用户性别分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'user_sex', $dataArr, function(&$val, $name) {

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入用户性别分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'user_phone', $dataArr, function(&$val, $name) {

                $val[$name] = substr($val[$name],0,3);

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        // TODO : 写入地址信息分类子树
        $tree = array_merge($tree, $this->subtree(

            $tree, 'user_address', $dataArr, function(&$val, $name) {

                $val[$name] = substr($val[$name],0, 6);

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            })

        );

        return $tree;
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
        $paymentTimeArr = $this->subtree(

            [], 'payment_time', $dataArr, function(&$val, $name) {

                $val[$name] = explode('.', $val[$name])[0];

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            }
        );

        // TODO : 获取车牌车辆号
        $licenseNumberArr = $this->subtree(

            [], 'license_number', $dataArr, function(&$val, $name) {

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            }
        );

        // TODO : 获取车辆排量
        $displacementArr = $this->subtree(

            [], 'displacement', $dataArr, function(&$val, $name) {

            },function(&$size, $name, $val, $n, $pid){

                return $this->treeArray($size, $name, $val, $n, $pid);

            }
        );

        // TODO : 合并数组
        $totalNum = array_merge( $paymentTimeArr, $licenseNumberArr );
        $totalNum = array_merge( $totalNum, $displacementArr );

        // TODO : 循环处理数据
        $numberArr = [];
        foreach ($totalNum as $k => $v)
        {
            if( $v['pach'] == 3 )
            {
                $numberArr[] = (float) $v['attr'];
            }
        }

        // TODO : 合数组排序
        sort( $numberArr );

        // TODO : 返回总差值
        return (float) bcsub( $numberArr[count($numberArr)-1], $numberArr[0], 10 );

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
        // 获取每个属性的层级数
        $numArr = [];
        foreach ( $tree as $k => $v )
        {
            $numArr[] = $v['pach'];
        }
        // 倒序排序
        rsort($numArr);

        // 返回最大值
        return $numArr[0];
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
        foreach ( $dataArr as $key => &$val )
        {
            // 写入数据到数组
            $function($val, $name);
            $treeArr[] = $val[$name];
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
    private function clustering($kn, &$dataArr, $treeArr, $valNum, $treeNu)
    {
        $arrayData = [];
        $ns = 0;
        // TODO : 循环聚类
        while ( count($dataArr) >= $kn )
        {
            $arrayData[$ns] = $this->clusteringFunc2($kn, $dataArr, $treeArr, $valNum, $treeNu);
            $ns++;
        }
        return $arrayData;
    }

    /**
     * 名  称 : clusteringFunc2()
     * 功  能 : 处理聚类函数
     * 变  量 : --------------------------------------
     * 输  出 : (Array)  $E        =>  '簇数组';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/15 10:32
     */
    private function clusteringFunc2($kn, &$dataArr, $treeArr, $valNum, $treeNu)
    {
        // TODO : 判断当前数据长度
        if( $kn <= count($dataArr) )
        {
            // TODO : 随机选择一条记录
            $r1 =  $this->randRecord($dataArr);

            // TODO : 定义簇数组
            $E = [ $r1 ];

            // TODO : 处理聚类函数
            $E = $this->clusteringFunc($kn, $dataArr, $E, $treeArr, $valNum, $treeNu);

            // TODO : 返回数据
            $arras =  $E;

        }else{
            // TODO : 返回数据
            $arras = $dataArr;
        }

        return $arras;
    }

    /**
     * 名  称 : clusteringFunc()
     * 功  能 : 处理聚类函数
     * 变  量 : --------------------------------------
     * 输  出 : (Array)  $E        =>  '簇数组';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/15 10:32
     */
    private function clusteringFunc($kn, &$dataArr, $E, $treeArr, $valNum, $treeNu)
    {
        foreach($dataArr as $k => $v){

            $ES  = array_merge(  $E, [$v] );

            // TODO : 获取数字属性差值
            $eDiff = $this->totalDifference($ES);

            // TODO : 获取分类属性层数
            $eTree = $this->hierarchySubtree($treeArr, $ES);

            // TODO : 计算数字属性差值
            $N = ( float ) bcdiv ( $eDiff , $valNum, 10 );

            // TODO : 计算分类属性差值
            $T = ( float ) bcdiv ( $eTree , $treeNu, 10 );

            // TODO : 求和
            $H = ( float ) bcadd ( $N, $T,10 );

            $S[] = [
                'ids' => $k,
                'num' => $H,
                'dat' => $v
            ];
        }

        // 根据差值进行排序
        foreach ( $S as $keys => $vals )
        {
            foreach ( $S as $keys1 => $vals2 )
            {
                if( bccomp ( $S[$keys1]['num'] , $S[$keys]['num'], 10 ) >= 1 )
                {
                    $a = $S[$keys];
                    $S[$keys] = $S[$keys1];
                    $S[$keys1] = $a;
                }
            }
        }

        unset( $dataArr[ $S[0][ 'ids' ] ] );

        $E = array_merge( $E, [$S[0]['dat']] );

        if( count($E) < $kn )
        {
            $ArrS = $this->clusteringFunc($kn, $dataArr, $E, $treeArr, $valNum, $treeNu);
        }else{
            $ArrS = $E;
        }

        return $ArrS;
    }

    /**
     * 名  称 : generalization()
     * 功  能 : 泛化处理所有数据
     * 变  量 : --------------------------------------
     * 输  出 : (Array)  $E        =>  '簇数组';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/15 10:32
     */
    private function generalization(&$E)
    {
        // TODO : 遍历所有数据
        foreach ($E as $key => &$val)
        {
            // TODO : 泛化处理车牌号
            $val['plate_number'] = explode(' ', $val['plate_number'])[0];

            // TODO : 泛化处理身份证
            $val['id_number'] = substr($val['id_number'],0,6);

            // TODO : 泛化处理地址信息
            $val['user_address'] = substr($val['user_address'],0, 6);

            // TODO : 泛化处理车牌发放时间年份
            $val['payment_time'] = (int) explode('.', $val["payment_time"])[0];

        }
    }

    /**
     * 名  称 : hierarchySubtree()
     * 功  能 : 获取分类属性子树层级
     * 变  量 : --------------------------------------
     * 输  出 : (Array)  $treeArr  =>  '分类树数组';
     * 输  出 : (Array)  $E        =>  '簇数组';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/14 22:49
     */
    private function hierarchySubtree($treeArr, &$E)
    {
        // TODO : 定义判断用数组
        $root = [
            'plate_number'     => [],
            'license_type'     => [],
            'license_color'    => [],
            'production_plant' => [],
            'id_number'        => [],
            'user_sex'         => [],
            'user_phone'       => [],
            'user_address'     => [],
        ];

        // TODO : 遍历所有数据
        foreach ($E as $key => &$val)
        {
            $root['plate_number'][]     = $val['plate_number'];
            $root['license_type'][]     = $val['license_type'];
            $root['license_color'][]    = $val['license_color'];
            $root['production_plant'][] = $val['production_plant'];
            $root['id_number'][]        = $val['id_number'];
            $root['user_sex'][]         = $val['user_sex'];
            $root['user_phone'][]       = $val['user_phone'];
            $root['user_address'][]     = $val['user_address'];
        }

        // TODO : 计算层级
        foreach( $root as $v )
        {
            return $this->hierarchicalData($treeArr, $v);
        }
    }

    /**
     * 名  称 : hierarchicalData()
     * 功  能 : 获取当前所有分类属性的层级数
     * 变  量 : --------------------------------------
     * 输  入 : (Array)  $treeArr  => '被处理数据';
     * 输  入 : (Array)  $valArr   => '被处理数据';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/13 11:38
     */
    private function hierarchicalData($treeArr, $valArr)
    {
        // 获取分类属性在分类树中所在的位置
        $valArrs = [];
        foreach ( $valArr as $k => $v )
        {
            $valArrs[] = $this->retrieval($treeArr, 'attr', $v);
        }

        // 判断层级是否一样
        if( $this->isSameLevel($valArrs)['type'] )
        {
            // 获取最低层数据
            $data = $this->isSameLevel($valArrs)['data'];

            foreach( $data as $k => $v )
            {
                // 获取当前所有分类属性的层级数
                $valArrs2 =  $this->minimalSubtree($treeArr, $v);
                $valArrs = array_merge($valArrs,$valArrs2);
                return $valArrs;
            }

        }

        // 保存所有层级数
        $pachArr = [];
        // 保存所有父id数
        $pidArr  = [];

        foreach ( $valArrs as $k => $v )
        {
            $pachArr[] = $v['pach'];
            $pidArr[]  = $v['pid'];
        }

        $box = array_unique($pachArr);

        if( 1 !== count( $box ) )
        {
            return $this->minimalSubtree($treeArr, $v);
        }

        // 获取顶层数据
        $data = $this->retrieval($treeArr, 'id', $pidArr[0]);

        // 返回所有层数
        return $this->getSubtreeNumber($treeArr, $data);

    }

    /**
     * 名  称 : getSubtreeNumber()
     * 功  能 : 获取子树层数
     * 变  量 : --------------------------------------
     * 输  入 : (Array)  $tree  => '分类树数组';
     * 输  入 : (Array)  $data  => '被处理数据';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/13 11:38
     */
    private function getSubtreeNumber($tree, $data, $n=1)
    {
        // 获取当前分类节点的子节点
        $arr = [];
        // 层数数组
        $nArr = [];

        foreach ( $tree as $k => $v )
        {
            if( $data['id'] ===  $v['pid'] )
            {
                $arr[] = $v;
            }
        }

        foreach ( $arr as $k => $v )
        {
             $nArr[] = $this->getSubtreeNumber($tree, $v, $n+1);
        }

        if(empty($nArr)){
            return $n;
        }

        rsort($nArr);

        return $nArr[0];

    }

    /**
     * 名  称 : isSameLevel()
     * 功  能 : 判断层级是否一样
     * 变  量 : --------------------------------------
     * 输  入 : (Array)  $treeArr  => '被处理数据';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/13 11:38
     */
    private function isSameLevel (&$valArrs)
    {
        $pachArr = [];

        foreach ( $valArrs as $k => $v )
        {
            $pachArr[] = $v['pach'];
        }

        $box = array_unique($pachArr);

        if( 1 === count( $box ) )
        {
            return [ 'type' => true, 'data' => [] ];
        }

        sort($box);

        unset($box[0]);

        $boxArr = [];
        foreach( $box as $k => $v )
        {
            foreach( $valArrs as $k2 =>  $val )
            {
                if( $v == $val['pach'] )
                {
                    $boxArr[] = $val;
                    unset($valArrs[$k2]);
                }
            }
        }

        return [ 'type' => false, 'data' => $pachArr ];
    }

    /**
     * 名  称 : retrieval()
     * 功  能 : 检索分类树数据
     * 变  量 : --------------------------------------
     * 输  入 : (Array)  $treeArr  => '被处理数据';
     * 输  入 : (String) $attrName => '检索名称';
     * 输  入 : (String) $attrVal  => '检索内容';
     * 输  出 : --------------------------------------
     * 创  建 : 2018/12/13 11:38
     */
    private function retrieval($treeArr, $attrName, $attrVal)
    {
        foreach ( $treeArr as $k => $v )
        {
            if( $attrVal ===  $v[$attrName] )
            {
                return $v;
            }
        }

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
        if(count($arr)==0){
            return [];
        }

        sort($arr);

        if( !empty($arr) )
        {
            // 获取随机数
            $num = mt_rand( 0, ( count($arr)-1 ) );

            // 获取数据
            $rowData = $arr[$num];

            // 清除数据
            unset($arr[$num]);

            // 返回数据
            return $rowData;
        }
    }
}