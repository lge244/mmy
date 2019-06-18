<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Recharge_EweiShopV2Page extends MobileLoginPage
{
	public function main()
	{
		global $_W;
		$member = m('member')->getMember($_W['openid'], true);
		include $this->template();
	}

	public function withdraw()
	{
		global $_W;

		include $this->template();
	}


	public function post()
	{
		global $_W;
		global $_GPC;
		$money = $_GPC['money'];
		$brokerage = $_W['ewei_shopv2_member']['brokerage'];
		if ($brokerage < $money){
			exit(json_encode(array('code' =>1,'msg'=>'佣金不够提现哦')));
		}
		$data['money'] = $money;
		$data['uid'] = $_W['ewei_shopv2_member']['id'];
		$data['username'] = $_GPC['realname'];
		$data['account'] = $_GPC['alipay'];
		$data['status'] = 0;
		$data['withdraw_time'] = time();
		$a = pdo_insert('ewei_shop_withdraw',$data);
		if ($a){
			$money2 = $brokerage-$money;
			pdo_update('ewei_shop_member',array('brokerage'=>$money2),array('id'=>$_W['ewei_shopv2_member']['id']));
			exit(json_encode(array('code' =>0,'msg'=>'提现成功，预计48小时内到账')));
		}
		exit(json_encode(array('code' =>1,'msg'=>'啊哦！网络错误啦！请稍后重试')));
	}

}

?>
