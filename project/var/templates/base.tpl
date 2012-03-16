<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>{%block page_title%}
{%$smarty.block.child%}
{%if $page_title%}{%$page_title%} - {%/if%}
麦谷OA系统
{%/block%}</title>
{%block layout_style%}{%/block%}
<script type="text/javascript" src="{%$MEDIA_URL%}jquery/jquery-1.5.min.js"></script>
{%block extra_statics%}
    {%$extra_statics%}
{%/block%}
<link rel="Shortcut Icon" href="{%$BASE_URL%}favicon.ico">
<link type="text/css" href="{%$MEDIA_URL%}style/base.css" rel="stylesheet" />
<script src="{%$MEDIA_URL%}js/oa.js" type="text/javascript"></script>

</head>

<body>
	<div id="box">
    	<div id="top">

        	<div id="logo"><a href="#" title=""><img src="{%$MEDIA_URL%}images/web/logo.jpg" height="80" /></a></div>
            <div id="hello">

            {%block top_nav%}
                  {%nocache%}
                  {%if $user.is_authenticated%}
                    欢迎您，

                    <a href="{%url action="mine/center"%}" style="color:#ff0000">{%$user.info.username%}</a>
                    {%foreach from=$user.info.role item=top_user_role name=top_user_role%}
                            {%$top_user_role.name%}{%if !$smarty.foreach.top_user_role.last%} 、{%/if%}
                    {%/foreach%}
                     -
                    {%if $user.is_super_admin%}
                    <a href="{%url action="manager"%}">系统管理</a> -
                    {%/if%}
                    <a href="{%url name='auth_logout'%}">注销</a>
                  {%/if%}
                  {%/nocache%}
                  <img src="{%$MEDIA_URL%}images/web/web_01.jpg" width="19" height="22" alt="" />
              {%/block%}
            </div>
        </div>

        <div id="nav">
        <form action="" name="form1" id="form1">
        	<ul>
            	<li><a href="{%url action=""%}" title="首页">首&nbsp;&nbsp;页</a></li>
                <li><a href="{%url action="order"%}" title="资源中心">资源中心</a></li>
                <li><a href="{%url action="articles/category/notice"%}" title="内部公告">内部公告</a></li>
                <li><a href="{%url action="articles/category/notice"%}" title="常用资料">常用资料</a></li>
                <li><a href="{%url action="articles/category/manual"%}" title="产品手册">产品手册</a></li>
                <li><a href="{%url action="articles/detail/employee_handbook"%}" title="员工手册">员工手册</a></li>
                <li><a href="{%url action="articles/category/share"%}" title="精彩分享">精彩分享</a></li>
                <li><a href="{%url action="articles/category/knowledge"%}" title="知识宝库">知识宝库</a></li>
                <li><a href="{%url action="mine/center"%}" title="工作计划表">工作计划表</a></li>
            </ul>

            <p>
                <select style=" width:86px;">
                    <option value="{%url action="order/search"%}">订单</option>
                    <option value="{%url action="order/search"%}">文章</option>
                    <option value="{%url action="order/search"%}">客户</option>
                </select>
                <input type="text" style="width:161px; border:1px solid #ccc;" placeholder="订单ID，客户公司，文章标题">
                <input type="submit" style="background:url({%$MEDIA_URL%}images/web/search.jpg);width:82px;height:27px;border:none;" value="" />
            </p>
          </form>
        </div>
    
<div style="padding-top:15px;"><img src="{%$MEDIA_URL%}images/web/web_02.jpg" width="1363" height="29" /></div>

{%block content%}

{%/block%}

<div><img src="{%$MEDIA_URL%}images/web/web_05.jpg" width="1363" height="29" /></div> 
</div> 
<div class="clear"></div> 
<div id="bottom">
    麦谷网络OA系统 - Maganet Team &copy; 2011.
</div>

<script type="text/javascript">
	$(function(){
		$('input[type="text"], input[type="password"], input[type="file"], textarea, select').css('border', '1px solid #bbb').focus(function(){
			$(this).css('border', '1px solid #999');
		}).blur(function(){
			$(this).css('border', '1px solid #bbb');
		});
        $('a[href="'+window.location.href+'"]').addClass('active');
        if($.browser.msie || ($.browser.mozilla && $.browser.version < 2.0)) {
            $('input[type="text"][placeholder]').each(function(){
                if($(this).val()) {
                    return true;
                }

                $(this).val($(this).attr('placeholder'))
                .focus(function(){
                    $(this).val('');
                })
                .blur(function(){
                    if(!$.trim($(this).val())) {
                        $(this).val($(this).attr('placeholder'))
                    }
                });
            });
        }
        
        {%if $active_navigation%}
            $('#nav li a:eq({%$active_navigation%})').addClass('index_on');
        {%else%}
            $('#nav li a:eq(0)').addClass('index_on');
        {%/if%}
        {%block js_init%}
        
        {%/block%}
	});
</script>
</body>
</html>