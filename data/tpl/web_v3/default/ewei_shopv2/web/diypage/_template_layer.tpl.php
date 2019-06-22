<?php defined('IN_IA') or exit('Access Denied');?><script type="text/html" id="tpl_show_layer">

    <a class="diy-layer" style="width: <%style.width%>px; position: absolute; display: block; overflow: hidden; z-index: 999;
        <%if params.iconposition=='left top'%> top: <%style.top%>px; left: <%style.left%>px; text-align: left;<%/if%>
        <%if params.iconposition=='right top'%> top: <%style.top%>px; right: <%style.left%>px; text-align: right;<%/if%>
        <%if params.iconposition=='left bottom'%> bottom: <%style.top%>px; left: <%style.left%>px; text-align: left;<%/if%>
        <%if params.iconposition=='right bottom'%> bottom: <%style.top%>px; right: <%style.left%>px; text-align: right;<%/if%>
    " href="<%params.linkurl||'javascript:;'%>" target="_blank">
        <img src="<%imgsrc params.imgurl%>" style="height: auto; width: 100%; display: block;" />
    </a>
    <div class="diymenu-page" style="line-height: 500px;">这里是页面内容</div>
</script>

<script type="text/html" id="tpl_edit_layer">

    <div class="form-group">
        <div class="col-sm-2 control-label">按钮图片</div>
        <div class="col-sm-10">
            <div class="input-group">
                <input class="form-control input-sm diy-bind" data-bind-child="params" data-bind="imgurl" value="<%params.imgurl%>" id="iconsrc">
                <span data-input="#iconsrc" data-img="#iconimg" data-toggle="selectImg" class="input-group-addon btn btn-default">选择图片</span>
            </div>
            <div class="input-group " style="margin-top:.5em;">
                <img src="<%imgsrc params.imgurl%>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.jpg';" class="img-responsive img-thumbnail" width="50" id="iconimg">
                <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="$('#iconsrc').val('').trigger('change');$(this).prev().attr('src', '')">×</em>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">按钮宽度</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.width%>" data-min="10" data-max="150"></div>
                <div class="col-sm-4 control-labe count"><span><%style.width%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="width" value="<%style.width%>" type="hidden" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">按钮链接</div>
        <div class="col-sm-10">
            <div class="input-group form-group" style="margin: 0;">
                <input class="form-control input-sm diy-bind" data-bind-child="params" data-bind="linkurl" placeholder="请选择链接" value="<%params.linkurl%>" id="linkurl">
                <span data-input="#linkurl" data-toggle="selectUrl" class="input-group-addon btn btn-default">选择链接</span>
            </div>
            <div class="help-block">注意：此处仅支持链接跳转，JS代码请到 <a href="<?php  echo webUrl('sysset/shop')?>">全局统计代码</a> 中设置</div>
        </div>
    </div>

    <div class="line"></div>

        <div class="form-group">
            <div class="col-sm-2 control-label">按钮位置</div>
            <div class="col-sm-10">
                <label class="radio-inline"><input type="radio" name="iconposition" value="left top" class="diy-bind" data-bind-child="params" data-bind="iconposition" <%if params.iconposition=='left top'%>checked="checked"<%/if%>> 左上</label>
                <label class="radio-inline"><input type="radio" name="iconposition" value="right top" class="diy-bind" data-bind-child="params" data-bind="iconposition" <%if params.iconposition=='right top'%>checked="checked"<%/if%> > 右上</label>
                <label class="radio-inline"><input type="radio" name="iconposition" value="left bottom" class="diy-bind" data-bind-child="params" data-bind="iconposition" <%if params.iconposition=='left bottom'%>checked="checked"<%/if%> > 左下</label>
                <label class="radio-inline"><input type="radio" name="iconposition" value="right bottom" class="diy-bind" data-bind-child="params" data-bind="iconposition" <%if params.iconposition=='right bottom'%>checked="checked"<%/if%> > 右下</label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 control-label">上下偏移</div>
            <div class="col-sm-10">
                <div class="form-group">
                    <div class="slider col-sm-8" data-value="<%style.top%>" data-min="0" data-max="200"></div>
                    <div class="col-sm-4 control-labe count"><span><%style.top%></span>px(像素)</div>
                    <input class="diy-bind input" data-bind-child="style" data-bind="top" value="<%style.top%>" type="hidden" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 control-label">左右偏移</div>
            <div class="col-sm-10">
                <div class="form-group">
                    <div class="slider col-sm-8" data-value="<%style.left%>" data-min="0" data-max="150"></div>
                    <div class="col-sm-4 control-labe count"><span><%style.left%></span>px(像素)</div>
                    <input class="diy-bind input" data-bind-child="style" data-bind="left" value="<%style.left%>" type="hidden" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 control-label">是否启用</div>
            <div class="col-sm-10">
                <label class="radio-inline"><input type="radio" name="isopen" value="0" class="diy-bind" data-bind-child="params" data-bind="isopen" <%if params.isopen==0%>checked="checked"<%/if%>> 不启用</label>
                <label class="radio-inline"><input type="radio" name="isopen" value="1" class="diy-bind" data-bind-child="params" data-bind="isopen" <%if params.isopen==1%>checked="checked"<%/if%>> 启用</label>
            </div>
        </div>
        <div class="line"></div>

        <div class="alert alert-danger" style="margin: 0 10px;"><%if !merch%>注意：diy页面请至页面编辑中设置，此处设置为非diy页面的商城其他页面。<%else%>注意：diy页面请至页面中开启是否启用，此处设置为多商户商品详情页。<%/if%></div>

</script>
<!--4000097827-->