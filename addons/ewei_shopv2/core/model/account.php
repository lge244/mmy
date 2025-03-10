<?php
class Account_EweiShopV2Model
{
	public function checkLogin()
	{
		global $_W;
		global $_GPC;

		if (empty($_W['openid'])) {
			$openid = $this->checkOpenid();

			if (!empty($openid)) {
				return $openid;
			}

			$url = urlencode(base64_encode($_SERVER['QUERY_STRING']));
			$loginurl = mobileUrl('account/login', array('mid' => $_GPC['mid'], 'backurl' => $_W['isajax'] ? '' : $url));

			if ($_W['isajax']) {
				show_json(0, array('url' => $loginurl, 'message' => '请先登录!'));
			}

			header('location: ' . $loginurl);
			exit();
		}
	}

	public function checkOpenid()
	{
		global $_W;
		global $_GPC;
		$key = '__ewei_shopv2_member_session_' . $_W['uniacid'];

		if (isset($_GPC[$key])) {
			$session = json_decode(base64_decode($_GPC[$key]), true);

			if (is_array($session)) {
				$member = m('member')->getMember($session['openid']);
				if (is_array($member) && $session['ewei_shopv2_member_hash'] == md5($member['pwd'] . $member['salt'])) {
					$GLOBALS['_W']['ewei_shopv2_member_hash'] = md5($member['pwd'] . $member['salt']);
					$GLOBALS['_W']['ewei_shopv2_member'] = $member;
					return $member['openid'];
				}

				isetcookie($key, false, -100);
			}
		}
	}

	public function setLogin($member)
	{
		global $_W;

		if (!is_array($member)) {
			$member = m('member')->getMember($member);
		}

		if (!empty($member)) {
			$member['ewei_shopv2_member_hash'] = md5($member['pwd'] . $member['salt']);
			$key = '__ewei_shopv2_member_session_' . $_W['uniacid'];
			$cookie = base64_encode(json_encode($member));
			isetcookie($key, $cookie, 7 * 86400);
		}
	}

	public function getSalt()
	{
		$salt = random(16);

		while (1) {
			$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where salt=:salt limit 1', array(':salt' => $salt));

			if ($count <= 0) {
				break;
			}

			$salt = random(16);
		}

		return $salt;
	}

	public function checkBuy($stime,$level){
		$levelname = pdo_get('ewei_shop_member_level',array('id'=>$level))['levelname'];
		$date = date('Y-m',time());
		$date1 = $date.'-01';
		$date2 = strtotime($date."-01");
		if($date2 < $stime){
			$data['msg'] = "尊敬的用户你好，本月复购产品您还没有购买，下个月将无法继续享受".$levelname."权益";
			$data['code'] = 1;
		}else{
			$data['code'] = 2;
		}
		return $data;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
