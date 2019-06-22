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

        <div class="title">股东申请

        </div>

        <div class="fui-header-right">&nbsp;</div>

    </div>

    <div class="fui-content ">

        <div class="fui-cell-group">


            <div class="fui-cell applyradio">

                <div class="fui-cell-label" style="width: 120px;">姓名</div>

                <div class="fui-cell-info"><input type="text" id="realname" placeholder="请填写姓名" name="realname"
                                                  class="fui-input" value="" max="25"></div>

            </div>
            <div class="fui-cell applyradio">
                <div class="fui-cell-label" style="width: 120px;">昵称</div>

                <div class="fui-cell-info"><input type="text" id="alipay" placeholder="请填写收款账号" name="alipay"
                                                  class="fui-input" value="" max="25"></div>
            </div>
            <div class="fui-cell applyradio">
                <div class="fui-cell-label" style="width: 120px;">申请时间</div>

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