<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends MobilePage
{
    public function main()
    {
        $time = $this->getNextMonthDays(date('Y-m-d'));
        $member_num = count(pdo_getall('ewei_shop_member', array('level' => 6)));
        $m_order = pdo_getall('ewei_shop_order', array('status' => 3, 'paytime >' => strtotime($time[0]), 'paytime <=' => strtotime($time[1])), array('price'));
        $count = 0;
        foreach ($m_order as $k => $v) {
            $count += $v['price'];
        }

        $m_money = ($count * 10) / 100;
        $brokerage = $m_money / $member_num;
        $a = pdo_update('ewei_shop_member', array('brokerage +=' => $brokerage, 'shareholder_money +=' => $brokerage, 'past_brokerage +=' => $brokerage), array('level' => 6));
        if ($a > 0) {
            $data['type'] = 0;
            $data['money'] = $brokerage;
            $data['time'] = time();
            pdo_insert('participation_record', $data);
        }

    }

    protected function getNextMonthDays($date)
    {
        $timestamp = strtotime($date);
        $arr = getdate($timestamp);
        if ($arr['mon'] == 12) {
            $year = $arr['year'] + 1;
            $month = $arr['mon'] - 11;
            $firstday = $year . '-0' . $month . '-01';
            $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
        } else {
            $firstday = date('Y-m-01', strtotime(date('Y', $timestamp) . '-' . (date('m', $timestamp)) . '-01'));
            $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
        }
        return array($firstday, $lastday);
    }
}