<?php defined('IN_IA') or exit('Access Denied');?><?php  echo header('Content-type: application/vnd.ms-excel');?>
<?php  echo header('Content-Disposition: attachment; filename="订单记录.xls"');?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
	<meta http-equiv=Content-Type content="text/html; charset=utf8">
	<meta name=ProgId content=Excel.Sheet>
	<meta name=Generator content="Microsoft Excel 12">
	<link rel=File-List href="comm.files/filelist.xml">
	<style id="comm_32218_Styles">
		<!--
		table {
			mso-displayed-decimal-separator: "\.";
			mso-displayed-thousand-separator: "\,";
		}

		.font532218 {
			color: windowtext;
			font-size: 9.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: 宋体;
			mso-generic-font-family: auto;
			mso-font-charset: 134;
		}

		.xl1532218 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: 宋体;
			mso-generic-font-family: auto;
			mso-font-charset: 134;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6332218 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: 宋体;
			mso-generic-font-family: auto;
			mso-font-charset: 134;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6432218 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: 宋体;
			mso-generic-font-family: auto;
			mso-font-charset: 134;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6532218 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: 宋体;
			mso-generic-font-family: auto;
			mso-font-charset: 134;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6632218 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: 宋体;
			mso-generic-font-family: auto;
			mso-font-charset: 134;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		ruby {
			ruby-align: left;
		}

		rt {
			color: windowtext;
			font-size: 9.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: 宋体;
			mso-generic-font-family: auto;
			mso-font-charset: 134;
			mso-char-type: none;
		}
		-->
	</style>
</head>
<body>
<!--[if !excel]>　　<![endif]-->
<!--下列信息由 Microsoft Office Excel 的“发布为网页”向导生成。-->
<!--如果同一条目从 Excel 中重新发布，则所有位于 DIV 标记之间的信息均将被替换。-->
<!----------------------------->
<!--“从 EXCEL 发布网页”向导开始-->
<!----------------------------->
<div id="comm_32218" align=center x:publishsource="Excel">
	<table border=0 cellpadding=0 cellspacing=0 width=300
	       style='border-collapse:collapse;table-layout:fixed;width:233pt'>
		<col width=72 span=3 style='width:54pt'>
		<col width=94 style='mso-width-source:userset;mso-width-alt:3008;width:71pt'>
		<tr height=18 style='height:13.5pt'>
			<td>订单ID</td>
			<td>用户名</td>
			<td>用户等级</td>
			<td>订单编号</td>
			<td>产品价格</td>
			<td>运费</td>
			<td>税费</td>
			<td>数量</td>
			<td>订单备注</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $row) { ?>
		<tr>
			<td><?php  echo $row['id'];?></td>
			<td><?php  echo $row['realname'];?></td>
			<td>
				<?php  if($row['level'] == 0) { ?>普通用户{if}
				<?php  if($row['level'] == 5) { ?>分销商{if}
				<?php  if($row['level'] == 6) { ?>股东{if}
			</td>
			<td><?php  echo $row['ordersn'];?></td>
			<td><?php  echo $row[''];?></td>
			<td><?php  echo $row['dispatchprice'];?></td>
			<td><?php  echo $row['dispatchprice'];?></td>
		</tr>
		<?php  } } ?>
	</table>
</div>
</body>
</html>