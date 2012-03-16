<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>{%block page_title%}
{%$smarty.block.child%}
{%if $page_title%}{%$page_title%} - {%/if%}
麦谷OA系统 - 客户管理
{%/block%}</title>
{%block layout_style%}{%/block%}
<script type="text/javascript" src="{%$MEDIA_URL%}jquery/jquery-1.5.min.js"></script>
<script type="text/javascript" src="{%$MEDIA_URL%}customer/js/oa.js"></script>
{%block extra_statics%}
    {%$extra_statics%}
{%/block%}

<link type="text/css" href="{%$MEDIA_URL%}style/base.css" rel="stylesheet" />
<link type="text/css" href="{%$MEDIA_URL%}customer/style/style.css" rel="stylesheet" />


</head>

<body style="background:none;">
{%block content%}

{%/block%}
<script type="text/javascript">
	$(function(){
		$('input[type="text"], input[type="password"], textarea, select').css('border', '1px solid #bbb').focus(function(){
			$(this).css('border', '1px solid #999');
		}).blur(function(){
			$(this).css('border', '1px solid #bbb');
		});
        {%block js_init%}

        {%/block%}
	});
</script>
</body>
</html>