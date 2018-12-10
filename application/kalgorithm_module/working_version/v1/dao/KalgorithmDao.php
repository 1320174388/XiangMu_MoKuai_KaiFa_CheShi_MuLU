<?php
/**
 *  文件名称 :  KalgorithmDao.php
 *  创建日期 :  2018/12/10 11:05
 *  文件描述 :  K 匿名算法 ~ 聚类算法数据层
 *  历史记录 :  -----------------------
 */
namespace app\kalgorithm_module\working_version\v1\dao;
use app\kalgorithm_module\working_version\v1\model\KalgorithmModel;

class KalgorithmDao implements KalgorithmInterface
{

    // TODO : 定义数据存储变量
    private $clusteringData = array();


    /**
     * 名  称 : kalgorithmSelect()
     * 功  能 : 获取K匿名算法数据数据处理
     * 变  量 : --------------------------------------
     * 输  入 : (Number) $get['k_number']          => 'K值';
     * 输  入 : (String) $get['identifier']        => '标识符';
     * 输  入 : (String) $get['quasi_identifier']  => '准标识符';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/10 11:07
     */
    public function kalgorithmSelect($get)
    {
        // TODO : 获取数据
        $dataArr = $this->dataSelect($get);

        // TODO : 处理数据
        $newArr  = $this->kAlgorithmData($get, $dataArr);
        
        // 处理函数返回值
        return \RSD::returnModel($newArr,'E40000','请求成功','请求失败');
    }


    /**
     * 获取数据
     */
    private function dataSelect($get)
    {
        return KalgorithmModel::field(
            config('kalgorithm_v1_tableName.LicensePlate') . '.plate_number,' .
            config('kalgorithm_v1_tableName.LicensePlate') . '.plate_type,' .
            config('kalgorithm_v1_tableName.LicensePlate') . '.issuing_unit,' .
            config('kalgorithm_v1_tableName.LicensePlate') . '.payment_time,' .
            config('kalgorithm_v1_tableName.LicensePlate') . '.license_number,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.license_name,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.license_type,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.license_color,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.production_plant,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.displacement,' .
            config('kalgorithm_v1_tableName.Vehicle') . '.id_number,' .
            config('kalgorithm_v1_tableName.Customers') . '.user_name,' .
            config('kalgorithm_v1_tableName.Customers') . '.user_sex,' .
            config('kalgorithm_v1_tableName.Customers') . '.user_phone,' .
            config('kalgorithm_v1_tableName.Customers') . '.user_address'
        )->leftJoin(
            config('kalgorithm_v1_tableName.Vehicle'),
            config('kalgorithm_v1_tableName.LicensePlate').'.license_number = '.
            config('kalgorithm_v1_tableName.Vehicle').'.license_number'
        )->leftJoin(
            config('kalgorithm_v1_tableName.Customers'),
            config('kalgorithm_v1_tableName.Vehicle').'.id_number = '.
            config('kalgorithm_v1_tableName.Customers').'.id_number'
        )->select()->toArray();
    }


    /**
     * 名  称 : kAlgorithmData()
     * 功  能 : K匿名算法数据数据处理函数
     * 变  量 : --------------------------------------
     * 输  入 : (Array) $get  => '传值参数';
     * 输  入 : (Array) $arr  => '处理数据';
     * 输  出 : ['code'=>'错误码','msg'=>'提示信息','data'=>'返回数据']
     * 创  建 : 2018/12/10 11:07
     */
    private function kAlgorithmData($get, &$arr)
    {
        // TODO : 隐藏标识信息
        $this->hideIdentification($get, $arr);

        // TODO : 处理准标识符
        $this->quasiIdentifier($get, $arr);

        // TODO : 随机选择一条记录
        $data = $this->randRecord($arr);

        die(json_encode($data, 320));
    }


    /**
     * 隐藏标识信息
     */
    private function hideIdentification($get, &$data)
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
        foreach ($data as $k1 => $v1)
        {
            foreach ($array as $v2)
            {
                if(array_key_exists($v2,$v1))
                {
                    unset($data[$k1][$v2]);
                }
            }
        }
    }


    /**
     * 处理准标识符
     */
    private function quasiIdentifier($get, $data)
    {
        // 验证是否有数据
        if(empty($get['quasi_identifier'])) return FALSE;

        // 验证状态是否正确
        if(!is_string($get['quasi_identifier'])){
            \RSD::JsonDie('E10002.quasi_identifier input error');
        }

        // 处理数据
        

    }


    /**
     * 随机抽取出一条记录
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


    /**
     * 导出表格数据到数据库
     */
    private function excelReader($data=[])
    {
        // 实例化 Spreadsheet_Excel_Reader 导出表格数据
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');

        // 读取的文件
        $objPHPExcel = $objReader->load('3.xlsx', $encode = 'utf-8');


        $sheet = $objPHPExcel->getSheet(0);

        //取得总行数
        $highestRow = $sheet->getHighestRow();

        //取得总列数
        $highestColumn = $sheet->getHighestColumn();

        // 循环显示数据
        for ($i = 2; $i <= $highestRow; $i++)
        {
            $data[$i-2]['id'] = $i-1;
            $data[$i-2]['id_number']    = $objPHPExcel->getActiveSheet()->getCell("A" .$i)->getValue();
            $data[$i-2]['user_name']    = $objPHPExcel->getActiveSheet()->getCell("B" .$i)->getValue();
            $data[$i-2]['user_sex']     = $objPHPExcel->getActiveSheet()->getCell("C" .$i)->getValue();
            $data[$i-2]['user_phone']   = $objPHPExcel->getActiveSheet()->getCell("D". $i)->getValue();
            $data[$i-2]['user_address'] = $objPHPExcel->getActiveSheet()->getCell("E" .$i)->getValue();
        }

        // 定义数据表
        \think\Db::name('customers_tables')->insertAll($data);
    }


}