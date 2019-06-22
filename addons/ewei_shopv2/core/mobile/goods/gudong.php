<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Gudong_EweiShopV2Page extends MobilePage
{
    public function main(){
        $info = pdo_get('content',array('id'=>2),array('content'));

        include $this->template();
    }

    public function add(){
        global  $_GPC;
        global $_W;
        $ratio = pdo_get('shop_shareholder_rule');
        $data['ratio'] = $ratio['pshareholder_ratio'];
        $data['nickname'] = $_W['ewei_shopv2_member']['realname'];
 		$uid = pdo_get("ewei_shop_member",array('mobile'=>$_W['ewei_shopv2_member']['mobile']),array('id'));
      	$data['uid'] = $uid['id'];
        $data['time'] = time();
        $data['mobile'] = $_W['ewei_shopv2_member']['mobile'];
      	$result = pdo_get("gudong_apply",array('uid'=>$uid['id']),array('id'));
        if($result){
            $res = pdo_insert("gudong_apply",$data);
            if($res){
                exit(json_encode(['code'=>1,'msg'=>"申请成功,请等待后台审核"]));
            }else{
                exit(json_encode(['code'=>0,'msg'=>"申请失败"]));
            }
        }else{
        	exit(json_encode(['code'=>0,'msg'=>"请勿重复申请"]));
        }
        
    }

}