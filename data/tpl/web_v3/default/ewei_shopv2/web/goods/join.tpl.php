<?php defined('IN_IA') or exit('Access Denied');?><script src="<?php  echo EWEI_SHOPV2_LOCAL?>static/js/dist/layui/layui.js"></script>
<link href="<?php  echo EWEI_SHOPV2_LOCAL?>static/js/dist/layui/css/layui.css" rel="stylesheet">
<body style="margin: 20px;">
<div><p></p>
    <p>请先准备好要导入的数据，确认无误后导入</p></div>
<br>
<form method="POST" enctype="multipart/form-data" id="form1" action="uploadExcel/upload.do">
    <table>
        <tbody>
        <tr>
            <td>上传文件:</td>
            <td> <span class="btn-upload form-group">
				<button type="button" class="layui-btn layui-btn-sm" id="test3"><i class="layui-icon"></i>上传文件</button>
				</span></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="button" class="layui-btn layui-btn-sm channel">批量导入</button>
                <a
                        class="layui-btn-sm" href="./template.xls" style="color: black">
                    <i class="layui-icon " style="color: green"></i> 下载模版</a></td>
        </tr>
        <input type="hidden" id="fileName" value="">
        </tbody>
    </table>
</form>
<script>
    layui.use('upload', function () {
        var $ = layui.jquery
            , upload = layui.upload;
        //指定允许上传的文件类型
        upload.render({
            elem: '#test3'
            , url: "<?php  echo webUrl('goods/join/upload')?>"
            , accept: 'file' //普通文件
            , done: function (res) {
                if (res.code == 0) {
                    layer.msg(res.msg)
                    $('#fileName').val(res.fileName)
                } else {
                    layui.msg(res.msg, {icon: 6})
                }
            }
        });
        $('.channel').click(function () {
            var fileName = $('#fileName').val();
            if (fileName == ''){
                alert('别闹！请提交文件');
                return false
            }
            $.post("<?php  echo webUrl('goods/join/save')?>", {fileName: fileName}, function (res) {
                if (res.code == 0) {
                   alert(res.msg);
                    window.location.reload();
                }else{
                    alert(res.msg);
                    tip.msgbox.err(res.msg);
                }
            }, 'json')

        })

    })
</script>

</body>