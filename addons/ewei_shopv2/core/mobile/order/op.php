<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}


class Op_EweiShopV2Page extends MobileLoginPage
{
    /**
     * 取消订单
     * @global type $_W
     * @global type $_GPC
     */

    public function cancel()
    {
        global $_W;
        global $_GPC;
        $orderid = intval($_GPC["id"]);
        $order = pdo_fetch("select id,ordersn,openid,status,deductcredit,deductcredit2,deductprice,couponid,isparent,`virtual`,`virtual_info`,merchid from " . tablename("ewei_shop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array(":id" => $orderid, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"]));
        if (empty($order)) {
            show_json(0, "订单未找到");
        }

        if (0 < $order["status"]) {
            show_json(0, "订单已支付，不能取消!");
        }

        if ($order["status"] < 0) {
            show_json(0, "订单已经取消!");
        }

        if (!empty($order["virtual"]) && $order["virtual"] != 0) {
            $goodsid = pdo_fetch("SELECT goodsid FROM " . tablename("ewei_shop_order_goods") . " WHERE uniacid = " . $_W["uniacid"] . " AND orderid = " . $order["id"]);
            $typeid = $order["virtual"];
            $vkdata = ltrim($order["virtual_info"], "[");
            $vkdata = rtrim($vkdata, "]");
            $arr = explode("}", $vkdata);
            foreach ($arr as $k => $v) {
                if (!$v) {
                    unset($arr[$k]);
                }

            }
            $vkeynum = count($arr);
            pdo_query("update " . tablename("ewei_shop_virtual_data") . " set openid=\"\",usetime=0,orderid=0,ordersn=\"\",price=0,merchid=" . $order["merchid"] . " where typeid=" . intval($typeid) . " and orderid = " . $order["id"]);
            pdo_query("update " . tablename("ewei_shop_virtual_type") . " set usedata=usedata-" . $vkeynum . " where id=" . intval($typeid));
        }

        m("order")->setStocksAndCredits($orderid, 2);
        if (0 < $order["deductprice"]) {
            m("member")->setCredit($order["openid"], "credit1", $order["deductcredit"], array("0", $_W["shopset"]["shop"]["name"] . "购物返还抵扣积分 积分: " . $order["deductcredit"] . " 抵扣金额: " . $order["deductprice"] . " 订单号: " . $order["ordersn"]));
        }

        m("order")->setDeductCredit2($order);
        if (com("coupon") && !empty($order["couponid"])) {
            com("coupon")->returnConsumeCoupon($orderid);
        }

        pdo_update("ewei_shop_order", array("status" => -1, "canceltime" => time(), "closereason" => trim($_GPC["remark"])), array("id" => $order["id"], "uniacid" => $_W["uniacid"]));
        if (!empty($order["isparent"])) {
            pdo_update("ewei_shop_order", array("status" => -1, "canceltime" => time(), "closereason" => trim($_GPC["remark"])), array("parentid" => $order["id"], "uniacid" => $_W["uniacid"]));
        }

        m("notice")->sendOrderMessage($orderid);
        show_json(1);
    }

    /**
     * 确认收货
     * @global type $_W
     * @global type $_GPC
     */

    public function finish()
    {
        global $_W;
        global $_GPC;
        $orderid = intval($_GPC["id"]);
        $member = m('member')->getMember($_W['openid'], true);
        $order = pdo_fetch("select id,status,openid,couponid,price,refundstate,refundid,ordersn,price from " . tablename("ewei_shop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array(":id" => $orderid, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"]));
        
      if (empty($order)) {
            show_json(0, "订单未找到");
        }

        if ($order["status"] != 2) {
            show_json(0, "订单不能确认收货");
        }

        if (0 < $order["refundstate"] && !empty($order["refundid"])) {
            $change_refund = array();
            $change_refund["status"] = -2;
            $change_refund["refundtime"] = time();
            pdo_update("ewei_shop_order_refund", $change_refund, array("id" => $order["refundid"], "uniacid" => $_W["uniacid"]));
        }

        pdo_update("ewei_shop_order", array("status" => 3, "finishtime" => time(), "refundstate" => 0), array("id" => $order["id"], "uniacid" => $_W["uniacid"]));
//确认收货，修改订单状态
        //获取上级和上级的上级的服务费
        if($member['fid']){
            $commission = m("order")->shareCommission($orderid,$member['id']);
            $info1 = pdo_get("ewei_shop_member",array('id'=>$member['fid']),array('brokerage','past_brokerage','share_money'));
            //修改上级的分润佣金
            pdo_update("ewei_shop_member",array('brokerage'=>$info1['brokerage'] + $commission['share2commission'],'past_brokerage'=>$info1['past_brokerage'] + $commission['share2commission'],'share_money'=>$info1['share_money'] + $commission['share2commission']),array('id'=>$member['fid']));
           
          	pdo_insert("share_record",array('uid'=>$member['id'],'fid'=>$member['fid'],'money'=>$commission['share2commission'],'type'=>0,'time'=>time()));
          	
          //
            $f = pdo_get("ewei_shop_member",array('id'=>$member['fid']),array('fid'));
            $info2 = pdo_get("ewei_shop_member",array('id'=>$f['fid']),array('brokerage','past_brokerage','share_money'));

            if($f['fid']){
                pdo_update("ewei_shop_member",array('brokerage'=>$info2['brokerage'] + $commission['share3commission'],'past_brokerage'=>$info2['past_brokerage'] + $commission['share3commission'],'share_money'=>$info2['share_money'] + $commission['share3commission']),array('id'=>$f['fid']));
                pdo_insert("share_record",array('uid'=>$member['id'],'fid'=>$f['fid'],'money'=>$commission['share3commission'],'type'=>0,'time'=>time()));
            }
        }

        $price = pdo_get('ewei_shop_order_goods',array('orderid'=>$orderid),array('price','total'));
        $service = pdo_get('service');
        $money = $price['price']*$price['total']*$service['service_ratio'] / 100;
        $a = pdo_update('users',array('brokerage +='=>$money),array('uid'=>$_W['ewei_shopv2_member']['cid']));
        if ($a){
            $data['uid'] = $_W['ewei_shopv2_member']['cid'];
            $data['mid'] = $_W['ewei_shopv2_member']['id'];
            $data['mid'] = $_W['ewei_shopv2_member']['id'];
            $data['orderid'] = $orderid;
            $data['brokerage'] = $money;
            $data['time'] = time();
            pdo_insert('service_rebate_record',$data);
        }

        if ($_W['ewei_shopv2_member']['level'] <= 0) {
            $level = pdo_getall('ewei_shop_member_level');
            foreach ($level as $k => $v) {
                $res1 = pdo_getall('ewei_shop_order_goods', array('goodsid' => $v['goodsid'], 'openid' => $_W['ewei_shopv2_member']['openid']), array('orderid'));
                foreach ($res1 as $key => $value) {
                    $res2 = pdo_get('ewei_shop_order', array('id' => $value['orderid'], 'status' => 3), array('id'));
                    if ($res2) {
                        $agency_rule = pdo_get('shop_agency_rule');
                        $starting_time = time();
                        $expiration_time = time() + (86400 * $agency_rule['agency_purchase_time']);
                        pdo_update('ewei_shop_member', array('level' => $v['id'], 'starting_time' => $starting_time, 'expiration_time' => $expiration_time), array('openid' => $_W['ewei_shopv2_member']['openid']));
                    }
                }
            }
        }
        



        m("order")->setStocksAndCredits($orderid, 3);
        m("order")->fullback($orderid);
        m("member")->upgradeLevel($order["openid"], $orderid);
        m("order")->setGiveBalance($orderid, 1);
        if (com("coupon")) {
            $refurnid = com("coupon")->sendcouponsbytask($orderid);
        }

        if (com("coupon") && !empty($order["couponid"])) {
            com("coupon")->backConsumeCoupon($orderid);
        }

        m("notice")->sendOrderMessage($orderid);
        com_run("printer::sendOrderMessage", $orderid);
        if (p("lineup")) {
            p("lineup")->checkOrder($order);
        }

        if (p("commission")) {
            p("commission")->checkOrderFinish($orderid);
        }

        if (p("lottery")) {
            $res = p("lottery")->getLottery($_W["openid"], 1, array("money" => $order["price"], "paytype" => 2));
            if ($res) {
                p("lottery")->getLotteryList($_W["openid"], array("lottery_id" => $res));
            }

        }

        if (p("task")) {
            p("task")->checkTaskProgress($order["price"], "order_full", "", $order["openid"]);
        }

        show_json(1, array("url" => mobileUrl("order", array("status" => 3))));
    }

    /**
     * 删除或恢复订单
     * @global type $_W
     * @global type $_GPC
     */

    public function delete()
    {
        global $_W;
        global $_GPC;
        $orderid = intval($_GPC["id"]);
        $userdeleted = intval($_GPC["userdeleted"]);
        $order = pdo_fetch("select id,status,refundstate,refundid from " . tablename("ewei_shop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array(":id" => $orderid, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"]));
        if (empty($order)) {
            show_json(0, "订单未找到!");
        }

        if ($userdeleted == 0) {
            if ($order["status"] != 3) {
                show_json(0, "无法恢复");
            }

        } else {
            if ($order["status"] != 3 && $order["status"] != -1) {
                show_json(0, "无法删除");
            }

            if (0 < $order["refundstate"] && !empty($order["refundid"])) {
                $change_refund = array();
                $change_refund["status"] = -2;
                $change_refund["refundtime"] = time();
                pdo_update("ewei_shop_order_refund", $change_refund, array("id" => $order["refundid"], "uniacid" => $_W["uniacid"]));
            }

        }

        pdo_update("ewei_shop_order", array("userdeleted" => $userdeleted, "refundstate" => 0), array("id" => $order["id"], "uniacid" => $_W["uniacid"]));
        show_json(1);
    }

}


