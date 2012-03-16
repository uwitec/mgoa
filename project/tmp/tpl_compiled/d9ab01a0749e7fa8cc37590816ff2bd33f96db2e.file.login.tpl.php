<?php /* Smarty version Smarty-3.0.6, created on 2012-03-14 16:48:43
         compiled from "E:\wamp\www\oa\base\contrib\auth\templates\auth\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:125824f605b6b17b1b7-00701948%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd9ab01a0749e7fa8cc37590816ff2bd33f96db2e' => 
    array (
      0 => 'E:\\wamp\\www\\oa\\base\\contrib\\auth\\templates\\auth\\login.tpl',
      1 => 1331711141,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '125824f605b6b17b1b7-00701948',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>麦谷OA系统</title>
<link href="<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
yaml/screen/forms.css" rel="stylesheet" type="text/css" />
<style type="text/css">
*{ margin:0px; padding:0px;}
ul,li{ list-style:none;}
img{ vertical-align:top; border:none;}
a{ text-decoration:none; color:#666;}
input,textarea,select{ vertical-align:middle;  color:#666; }
#box{ width:870px; margin:0px auto;}
table{ margin-top:347px; margin-left:67px; line-height:40px; color:#666; font-family:"微软雅黑";}

table tr td input{ border:1px solid #ccc;}
body{ background:url(<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
images/bg/bg_07.jpg) center top no-repeat #fff;}
</style>
</head>

<body>
<div id="box">
<form action="<?php echo smarty_function_url(array('action'=>'accounts/login'),$_smarty_tpl);?>
" name="" method="POST" id="">
<table width="288" border="0" cellspacing="0" cellpadding="0" class="table">

  <?php echo smarty_function_csrf_protected(array(),$_smarty_tpl);?>

  <?php echo smarty_modifier_as_table($_smarty_tpl->getVariable('login_form')->value);?>

  <tr>
    <td><label>验证码：</label></td>
    <td width="204">
        <input type="text" name="vdcode" style="width:100px;" />
        <img src="<?php echo smarty_function_url(array('action'=>"accounts/check_code"),$_smarty_tpl);?>
" onclick="this.src='<?php echo smarty_function_url(array('action'=>"accounts/check_code"),$_smarty_tpl);?>
?id='+Math.random()" style="vertical-align:middle" />
    </td>
  </tr>
  <tr>
    <td width="204" align="right" colspan="2">
        <?php if ($_smarty_tpl->getVariable('login_form')->value['messages']){?>
            <?php  $_smarty_tpl->tpl_vars['msg'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('login_form')->value['messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['msg']->key => $_smarty_tpl->tpl_vars['msg']->value){
?>
                <span style="color:#ff0000;font-size:12px;font-weight:normal;"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</span>
            <?php }} ?>
        <?php }?>
        <input type="image" src="<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
images/web/dl.jpg" style="border:none;" />
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>