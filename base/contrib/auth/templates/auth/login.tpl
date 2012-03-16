<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>麦谷OA系统</title>
<link href="{%$MEDIA_URL%}yaml/screen/forms.css" rel="stylesheet" type="text/css" />
<style type="text/css">
*{ margin:0px; padding:0px;}
ul,li{ list-style:none;}
img{ vertical-align:top; border:none;}
a{ text-decoration:none; color:#666;}
input,textarea,select{ vertical-align:middle;  color:#666; }
#box{ width:870px; margin:0px auto;}
table{ margin-top:347px; margin-left:67px; line-height:40px; color:#666; font-family:"微软雅黑";}

table tr td input{ border:1px solid #ccc;}
body{ background:url({%$MEDIA_URL%}images/bg/bg_07.jpg) center top no-repeat #fff;}
</style>
</head>

<body>
<div id="box">
<form action="{%url action='accounts/login'%}" name="" method="post" id="">
<table width="288" border="0" cellspacing="0" cellpadding="0" class="table">

  {%csrf_protected%}
  {%$login_form|as_table%}
  <tr>
    <td><label>验证码：</label></td>
    <td width="204">
        <input type="text" name="vdcode" style="width:100px;" />
        <img src="{%url action="accounts/check_code"%}" onclick="this.src='{%url action="accounts/check_code"%}?id='+Math.random()" style="vertical-align:middle" />
    </td>
  </tr>
  <tr>
    <td width="204" align="right" colspan="2">
        {%if $login_form.messages%}
            {%foreach from=$login_form.messages item=msg%}
                <span style="color:#ff0000;font-size:12px;font-weight:normal;">{%$msg%}</span>
            {%/foreach%}
        {%/if%}
        <input type="image" src="{%$MEDIA_URL%}images/web/dl.jpg" style="border:none;" />
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>