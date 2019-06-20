<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>

    .fui-cell-group .fui-cell .fui-cell-icon {

        width: auto;

    }

    .fui-cell-group .fui-cell .fui-cell-icon img {

        width: 1.3rem;

        height: 1.3rem;

    }

    .fui-cell-group .fui-cell.no-border {

        padding-top: 0;

    }

    .fui-cell-group .fui-cell.no-border .fui-cell-info {

        font-size: .6rem;

        color: #999;

    }

    .fui-cell-group .fui-cell.applyradio .fui-cell-info {

        line-height: normal;

    }

</style>

<div class='fui-page  fui-page-current'>

    <div class="fui-header">

        <div class="fui-header-left">

            <a class="back"></a>

        </div>

        <div class="title">佣金提现

        </div>

        <div class="fui-header-right">&nbsp;</div>

    </div>

    <div class="fui-content ">
        <div class="fui-cell-title" style="height: 2.45rem">
            <div class="fui-cell-info"
                 style="font-size:.7rem;color:#666;position: relative;height: 100%;line-height: 1.425rem">可提现金额: ￥<span
                    id="current"><?php  echo number_format($_W['ewei_shopv2_member']['brokerage'],2)?></span></div>
        </div>
        <div class="fui-cell-group" style="margin-top: 0">
            <div class="fui-cell-title" style="height: 2.45rem;font-size:.7rem;color:#666;line-height: 1.425rem">提现金额

            </div>
            <div class="fui-cell" style="padding: 0 .6rem .6rem;">
                <div class="fui-cell-label big" style="width:auto; font-size:1rem;color: #000; ">￥</div>
                <div class="fui-cell-info"><input type="number" class="fui-input" id="money" style="font-size:1rem;">
                </div>
            </div>
        </div>
        <span style="color: #495066; margin-left: 20px;">提现手续费6%</span>
        <span style="float: right; margin-right: 20px; color: #495066">到账金额：<span style="color: #ff0011"
                                                                                  id="money2"></span>￥</span>
        <div class="fui-cell-group">
            <div class="fui-cell">
                <div class="fui-cell-label" style="width: 120px;"><span class="re-g">提现方式</span></div>
                <select id="t5" style="font-size:14px;height: 34px;width: 200px; background: white;">
                    <option value="">支付宝</option>
                    <option value="">微信</option>
                </select>
            </div>

            <div class="fui-cell applyradio">

                <div class="fui-cell-label" style="width: 120px;">姓名</div>

                <div class="fui-cell-info"><input type="text" id="realname" placeholder="请填写姓名" name="realname"
                                                  class="fui-input" value="" max="25"></div>

            </div>
            <div class="fui-cell applyradio">
                <div class="fui-cell-label" style="width: 120px;">帐号</div>

                <div class="fui-cell-info"><input type="text" id="alipay" placeholder="请填写收款账号" name="alipay"
                                                  class="fui-input" value="" max="25"></div>
            </div>
            <div class="fui-cell applyradio">
                <div class="fui-cell-label" style="width: 120px;">确认帐号</div>

                <div class="fui-cell-info"><input type="text" id="alipay2" placeholder="请填写收款账号" name="alipay2"
                                                  class="fui-input" value="" max="25"></div>
            </div>
            <div class="fui-cell ab-group" style="display: none;">

            </div>

            <div class="fui-cell alipay-group" style="display: none;">


            </div>


            <div class="fui-cell alipay-group" style="display: none;">

                <div class="fui-cell-label" style="width: 120px;">确认帐号</div>

                <div class="fui-cell-info"><input type="text" id="alipay1" placeholder="请确认账号" name="alipay1"
                                                  class="fui-input" value="" max="25"></div>

            </div>


        </div>


        <a class="btn btn-danger block " id="withdraw">提现</a>

        <div class="fui-cell-group" style="background: transparent;padding: .4rem 0;margin: 0;display: none;  ">
            <div class="fui-cell no-border">
                <div class="fui-cell-info" id="chargeinfo">详细说明</div>
            </div>


            <div class="fui-cell no-border charge-group">

                <div class="fui-cell-info">本次提现将扣除手续费 ￥<span class="text-danger" id="deductionmoney"></span></div>

            </div>

            <div class="fui-cell no-border charge-group">

                <div class="fui-cell-info"> 本次提现实际到账金额 ￥<span class="text-danger" id="realmoney"></span></div>

            </div>

        </div>
    </div>
</div>
<script>
    $('#money').on('blur', function () {
        var money = $('#money').val();
        var a = money * 0.06;
        var money2 = money - a;
        if (money2 > 0) {
            $('#money2').text(money2)
        }
    });

    $('#withdraw').click(function () {
        var current = <?php  echo $_W['ewei_shopv2_member']['brokerage'];?>;
        var money = $('#money').val();
        var realname = $('#realname').val();
        var alipay = $('#alipay').val();
        var alipay2 = $('#alipay2').val();

        if (money > current) {
            alert('提现的金额不能大于佣金总额');
            $('#money').val('');
            $('#money2').text('');
            return false;
        }
        if (money == '') {
            alert('提现的金额不能为空');
            return false;
        }
        if (money < 100) {
            alert('每次提现的金额不能小于一百元');
            return false;
        }
        if (realname == '' || alipay == '' || alipay2 == '') {
            alert('提现到的账号信息不能缺少');
            return false;
        }
        if (alipay != alipay2) {
            alert('两次填写的收款账号不同');
            return false;
        }
        $.post("./index.php?i=2&c=entry&m=ewei_shopv2&do=mobile&r=member.recharge.post", {
            "money": money,
            "realname": realname,
            "alipay": alipay
        }, function (res) {
            if (res.code == 0) {
                alert(res.msg)
                window.location.reload();
            } else {
                alert(res.msg)
            }
        }, 'json')

    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>