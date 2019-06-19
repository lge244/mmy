<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Join_EweiShopV2Page extends WebPage
{
    public function main()
    {
        include $this->template();
    }

    public function upload()
    {
        $file = $_FILES['file'];
        if ($file == null) {
            exit(json_encode(array('code' => 1, 'msg' => '没有文件上传')));
        }
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);//获取上传文件类型

        if (!in_array(strtolower($ext), array('xls', 'xlsx','txt'))) {
            exit(json_encode(array('code' => 1, 'msg' => '文件格式不支持')));
        }
        $uploadPath = './public/uploads/';
        //创建目录
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
            chmod($uploadPath, 0777);
        }
        $newFileName = $uploadPath . time() . '.' . $ext;
        if (!@move_uploaded_file($file['tmp_name'], $newFileName)) {
            exit(json_encode(array('code' => 1, "msg" => "文件上传失败！")));
        }
        exit(json_encode(array('code' => 0, 'msg' => "文件上传成功!", 'fileName' => $newFileName)));
    }

    public function save()
    {
        global $_W;

        $fileName = $_POST['fileName'];
        $word = $this->importExcel($fileName);
        $srt_word = ['title', 'total'];
        unset($word[1]);
        foreach ($word as $k => $v) {
            $a = array_values($v);
            $arr[$k] = array_combine($srt_word, $a);
            $arr[$k]['uniacid'] =2;
            $arr[$k]['status'] =0;
            $arr[$k]['thumb'] = '0';
            $arr[$k]['createtime'] = time();
        }
        $i = 0;
        foreach ($arr as $key=>$value){
            $res = pdo_insert('ewei_shop_goods',$value);
            if ($res){
                $record['title'] = $value['title'];
                $record['total'] = $value['total'];
                $record['uid'] = $_W['user']['uid'];
                $record['desc'] = '录入商品';
                $record['time'] = time();
                pdo_insert('shop_goods_record',$record);
                $i++;
            }
        }
        $count =count($arr);
        if ($i!=0){
            exit(json_encode(array('code'=>0,'msg'=>"导入总$count 条数, 导入成功 $i 条数")));
        }
        exit(json_encode(array('code'=>1,'msg'=>"批量导入失败")));

    }

    public function importExcel($file, $sheet = 0)
    {
        $file = iconv("utf-8", "gb2312", $file);   //转码
        if (empty($file) OR !file_exists($file)) {
            die('file not exists!');
        }
        include_once IA_ROOT . '/framework/library/phpexcel/PHPExcel.php';
        include_once IA_ROOT . '/framework/library/phpexcel/PHPExcel/IOFactory.php';

        $objRead = new PHPExcel_Reader_Excel2007();   //建立reader对象
        if (!$objRead->canRead($file)) {
            $objRead = new PHPExcel_Reader_Excel5();
            if (!$objRead->canRead($file)) {
                die('No Excel!');
            }
        }
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
        $obj = $objRead->load($file);  //建立excel对象
        $currSheet = $obj->getSheet($sheet);   //获取指定的sheet表
        $columnH = $currSheet->getHighestColumn();   //取得最大的列号
        $columnCnt = array_search($columnH, $cellName);
        $rowCnt = $currSheet->getHighestRow();   //获取总行数
        $data = array();
        for ($_row = 1; $_row <= $rowCnt; $_row++) {  //读取内容
            for ($_column = 0; $_column <= $columnCnt; $_column++) {
                $cellId = $cellName[$_column] . $_row;
                $cellValue = $currSheet->getCell($cellId)->getValue();
                //$cellValue = $currSheet->getCell($cellId)->getCalculatedValue();  #获取公式计算的值
                if ($cellValue instanceof PHPExcel_RichText) {   //富文本转换字符串
                    $cellValue = $cellValue->__toString();
                }
                $data[$_row][$cellName[$_column]] = $cellValue;
            }
        }
        return $data;
    }

}