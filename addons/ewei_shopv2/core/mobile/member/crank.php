<?php
if (!(defined('IN_IA')))
{
	exit('Access Denied');
}
class Crank_EweiShopV2Page extends MobileLoginPage
{
	public function main(){
		global $_W;
		$member = m('member')->getMember($_W['openid'], true);
		$rank = pdo_getall('ewei_shop_member', array(), array('id','realname','past_brokerage') , '' , 'past_brokerage DESC' , array());
		$myrank = '';

		$ranks = [];
		foreach ($rank as $k=>$v){
			if($k <= 9){
				$ranks[] = $v;
				$ranks[$k]['rank'] = $k + 1;
			}
			for ($i = 1;$i <= count($v);$i++){
				if($member['id'] == $v['id']){
					$myrank = $i;
				}
			}
		}
		$r = $myrank - 1;
		$mycommission = $rank[$r]['past_brokerage'];
		include $this->template();
	}
}