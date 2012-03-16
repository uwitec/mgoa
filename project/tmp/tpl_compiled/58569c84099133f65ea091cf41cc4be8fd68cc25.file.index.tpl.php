<?php /* Smarty version Smarty-3.0.6, created on 2012-03-14 16:48:57
         compiled from "E:\wamp\www\oa\project\applications\center\templates\center\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:127384f605b79e36c51-29463714%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '58569c84099133f65ea091cf41cc4be8fd68cc25' => 
    array (
      0 => 'E:\\wamp\\www\\oa\\project\\applications\\center\\templates\\center\\index.tpl',
      1 => 1305682216,
      2 => 'file',
    ),
    'ac624b146d0148281ecd4900028c804582679879' => 
    array (
      0 => 'E:\\wamp\\www\\oa\\project\\var\\templates\\base.tpl',
      1 => 1331619821,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '127384f605b79e36c51-29463714',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>
<?php if ($_smarty_tpl->getVariable('page_title')->value){?><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
 - <?php }?>
麦谷OA系统
</title>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
jquery/jquery-1.5.min.js"></script>

    <?php echo $_smarty_tpl->getVariable('extra_statics')->value;?>


<link rel="Shortcut Icon" href="<?php echo $_smarty_tpl->getVariable('BASE_URL')->value;?>
favicon.ico">
<link type="text/css" href="<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
style/base.css" rel="stylesheet" />
<script src="<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
js/oa.js" type="text/javascript"></script>

</head>

<body>
	<div id="box">
    	<div id="top">

        	<div id="logo"><a href="#" title=""><img src="<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
images/web/logo.jpg" height="80" /></a></div>
            <div id="hello">

            
                  <?php if ($_smarty_tpl->getVariable('user')->value['is_authenticated']){?>
                    欢迎您，

                    <a href="<?php echo smarty_function_url(array('action'=>"mine/center"),$_smarty_tpl);?>
" style="color:#ff0000"><?php echo $_smarty_tpl->getVariable('user')->value['info']['username'];?>
</a>
                    <?php  $_smarty_tpl->tpl_vars['top_user_role'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('user')->value['info']['role']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['top_user_role']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['top_user_role']->iteration=0;
if ($_smarty_tpl->tpl_vars['top_user_role']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['top_user_role']->key => $_smarty_tpl->tpl_vars['top_user_role']->value){
 $_smarty_tpl->tpl_vars['top_user_role']->iteration++;
 $_smarty_tpl->tpl_vars['top_user_role']->last = $_smarty_tpl->tpl_vars['top_user_role']->iteration === $_smarty_tpl->tpl_vars['top_user_role']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['top_user_role']['last'] = $_smarty_tpl->tpl_vars['top_user_role']->last;
?>
                            <?php echo $_smarty_tpl->tpl_vars['top_user_role']->value['name'];?>
<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['top_user_role']['last']){?> 、<?php }?>
                    <?php }} ?>
                     -
                    <?php if ($_smarty_tpl->getVariable('user')->value['is_super_admin']){?>
                    <a href="<?php echo smarty_function_url(array('action'=>"manager"),$_smarty_tpl);?>
">系统管理</a> -
                    <?php }?>
                    <a href="<?php echo smarty_function_url(array('name'=>'auth_logout'),$_smarty_tpl);?>
">注销</a>
                  <?php }?>
                  <img src="<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
images/web/web_01.jpg" width="19" height="22" alt="" />
              
            </div>
        </div>

        <div id="nav">
        <form action="" name="form1" id="form1">
        	<ul>
            	<li><a href="<?php echo smarty_function_url(array('action'=>''),$_smarty_tpl);?>
" title="首页">首&nbsp;&nbsp;页</a></li>
                <li><a href="<?php echo smarty_function_url(array('action'=>"order"),$_smarty_tpl);?>
" title="资源中心">资源中心</a></li>
                <li><a href="<?php echo smarty_function_url(array('action'=>"articles/category/notice"),$_smarty_tpl);?>
" title="内部公告">内部公告</a></li>
                <li><a href="<?php echo smarty_function_url(array('action'=>"articles/category/notice"),$_smarty_tpl);?>
" title="常用资料">常用资料</a></li>
                <li><a href="<?php echo smarty_function_url(array('action'=>"articles/category/manual"),$_smarty_tpl);?>
" title="产品手册">产品手册</a></li>
                <li><a href="<?php echo smarty_function_url(array('action'=>"articles/detail/employee_handbook"),$_smarty_tpl);?>
" title="员工手册">员工手册</a></li>
                <li><a href="<?php echo smarty_function_url(array('action'=>"articles/category/share"),$_smarty_tpl);?>
" title="精彩分享">精彩分享</a></li>
                <li><a href="<?php echo smarty_function_url(array('action'=>"articles/category/knowledge"),$_smarty_tpl);?>
" title="知识宝库">知识宝库</a></li>
                <li><a href="<?php echo smarty_function_url(array('action'=>"mine/center"),$_smarty_tpl);?>
" title="工作计划表">工作计划表</a></li>
            </ul>

            <p>
                <select style=" width:86px;">
                    <option value="<?php echo smarty_function_url(array('action'=>"order/search"),$_smarty_tpl);?>
">订单</option>
                    <option value="<?php echo smarty_function_url(array('action'=>"order/search"),$_smarty_tpl);?>
">文章</option>
                    <option value="<?php echo smarty_function_url(array('action'=>"order/search"),$_smarty_tpl);?>
">客户</option>
                </select>
                <input type="text" style="width:161px; border:1px solid #ccc;" placeholder="订单ID，客户公司，文章标题">
                <input type="submit" style="background:url(<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
images/web/search.jpg);width:82px;height:27px;border:none;" value="" />
            </p>
          </form>
        </div>
    
<div style="padding-top:15px;"><img src="<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
images/web/web_02.jpg" width="1363" height="29" /></div>





<div class="index_m">
	<div class="index_m_title">
		 <a href="<?php echo smarty_function_url(array('action'=>"order/new"),$_smarty_tpl);?>
">
            <img src="<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
images/web/bus_btn_img8.jpg">
		 </a>
		 <a href="<?php echo smarty_function_url(array('action'=>"order/list"),$_smarty_tpl);?>
">
            <img src="<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
images/web/web_03.jpg">
		 </a>
		 <span style="width:300px;margin-top:10px;">麦谷OA系统 - 管理首页<font color="#006666"> &gt;&gt; Maganet OA</font></span>
    </div>
	<div class="index_m_b">
        <div class="index_m_b2">

            <div class="index_m_b2_contant">
                <div class="index_m_b2_contant_l">
                    <div class="index_m_b2_contant_l_title">
                        最新消息 <font face="candara">News</font>
                    </div>
                    <ul class="index_m_b2_contant_l_ul">
                        <?php  $_smarty_tpl->tpl_vars['n'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('news')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['n']->key => $_smarty_tpl->tpl_vars['n']->value){
?>
                            <li>
                                <span><?php echo $_smarty_tpl->tpl_vars['n']->value['created_at'];?>
</span>
                                <a href="<?php echo smarty_function_url(array('action'=>"articles/detail"),$_smarty_tpl);?>
<?php echo $_smarty_tpl->tpl_vars['n']->value['id'];?>
/"><?php echo $_smarty_tpl->tpl_vars['n']->value['name'];?>
</a>
                            </li>
                        <?php }} ?>
                    </ul>
                </div>
                <div class="index_m_b2_contant_r">
                    <div class="index_m_b2_contant_l_title">
                       待办事项 <font face="candara">Waiting for the matter at issue</font>
                    </div>
                    <ul class="index_m_b2_contant_l_ul">
                        <li><span>2011-05-06</span><a title="?dir=myself" href="?dir=myself">设置工作计划</a></li>
                        <li><span>2011-05-06</span><a title="?dir=myself&amp;nav=injob" href="?dir=myself&amp;nav=injob">填写您的入职信息表</a></li>
                        <li><span>2011-05-06</span><a title="?dir=myself&amp;nav=vacation" href="?dir=myself&amp;nav=vacation">员工请假</a></li>
                        <li><span>2011-05-06</span><a title="?dir=myself&amp;nav=meeting" href="?dir=myself&amp;nav=meeting">会议：</a></li>
                    </ul>
                </div>
                <?php if ($_smarty_tpl->getVariable('long_not_orders')->value){?>
                <div class="index_m_b2_contant_l mt-10">
                    <div class="index_m_b2_contant_l_title">
                       最近十个长时间未联系订单 
                    </div>
                    <ul class="index_m_b2_contant_l_ul">
                        <?php  $_smarty_tpl->tpl_vars['lno'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('long_not_orders')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['lno']->key => $_smarty_tpl->tpl_vars['lno']->value){
?>
                            <li>
                                <a href="<?php echo smarty_function_url(array('action'=>"order/detail"),$_smarty_tpl);?>
<?php echo $_smarty_tpl->tpl_vars['lno']->value['id'];?>
/"><?php echo $_smarty_tpl->tpl_vars['lno']->value['Customer']['company_name'];?>
 - <?php echo $_smarty_tpl->tpl_vars['lno']->value['Customer']['name'];?>
</a>
                            </li>
                        <?php }} ?>
                    </ul>
                </div>
                <?php }?>
                <div class="clear"></div>
            </div>
        </div>
	</div>
</div>





<div><img src="<?php echo $_smarty_tpl->getVariable('MEDIA_URL')->value;?>
images/web/web_05.jpg" width="1363" height="29" /></div> 
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
        
        <?php if ($_smarty_tpl->getVariable('active_navigation')->value){?>
            $('#nav li a:eq(<?php echo $_smarty_tpl->getVariable('active_navigation')->value;?>
)').addClass('index_on');
        <?php }else{ ?>
            $('#nav li a:eq(0)').addClass('index_on');
        <?php }?>
        
        
        
	});
</script>
</body>
</html>