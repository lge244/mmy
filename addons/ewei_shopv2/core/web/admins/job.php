<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Job_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $category = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shopv2_job'));

        include $this->template();
    }

    public function add()
    {
        include($this->template());
    }

    public function post()
    {
        $data = $_POST;
        if ($data['jobtitle'] == ''){
            exit(json_encode(array('code'=>1,'msg'=>'权限名称不能为空！')));
        }
        $item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shopv2_job') . (' WHERE jobtitl = \'' . $data['jobtitl'] . '\' limit 1'));
        if ($item == true){
            exit(json_encode(array('code'=>1,'msg'=>'该权限已存在！')));
        }
        $res = pdo_insert('ewei_shopv2_job',$data);
        if ($res){
            exit(json_encode(array('code'=>0,'msg'=>'权限添加成功！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误请检查网络！')));

    }


}

?>
