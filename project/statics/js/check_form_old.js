function input_checkform(fm)
{
	company=fm.company.value;
	director=fm.director.value;
	book_time=fm.book_time.value;
	duty=fm.duty.value;
	mobile=fm.mobile.value;
	telephone=fm.telephone.value;
	email=fm.email.value;
	qq=fm.qq.value;
	areas=fm.areas.value;
	net=fm.net.value;
	content=fm.content.value;
	remark=fm.remark.value;

	if(company=="")
	{
		alert("公司名称不能为空，请输入公司名称！");
		return false;
	}
	else if(director=="")
	{
		alert("负责人姓名不能为空，请输入负责人姓名！");
		return false;
	}
	else if(book_time=="")
	{
		alert("预约时间请选择，暂无预约的请选择当前时间");
		return false;
	}
	else if(duty=="")
	{
		alert("负责人职务不能为空，如果是个人，请输入'个人'...");
		return false;
	}
	else if(mobile=="" && telephone=="")
	{
		alert("联系电话最少输入一项，不能全部为空，请输入电话或者手机号！");
		return false;
	}
	else if(email=="")
	{
		alert("联系邮箱不能为空，请输入！");
		return false;
	}		
	else if(areas=="")
	{
		alert("客户地区不能为空，请输入客户地区！");
		return false;
	}
	else if(net=="http://")
	{
		alert("客户示例网址不能为空，请输入！");
		return false;
	}
	else if(content=="")
	{
		alert("请添加客户沟通记录，不能为空！");
		return false;
	}
}
		 var ci=0;
		 function insert_row()
		{
			 ci ++;   
			  R = tab_idn.insertRow();
			  R.height="28px";
			  C = R.insertCell();   
			  C.style.background="#f2f2f2";
			  C.style.border="0px";
			  C.innerHTML = "域名";  
			  C = R.insertCell();   
			  C.style.border="0px";
			  C.innerHTML = "<font style='font-family:Arial Black;color:#339933'>http://www.</font><input type='text' name='new_idn_domain' style='width:240px;'>";  
			  C = R.insertCell();   
			  C.style.background="#f2f2f2";
			  C.style.border="0px";
			  C.innerHTML = "购买年限";  
			  C = R.insertCell();   
			  C.style.border="0px";
			  C.innerHTML = "<select name='idn_limit_year'><option value=''>请选择使用年限</option><option value='1'>一年</option><option value='2'>两年</option><option value='3'>三年</option><option value='4'>四年</option><option value='5'>五年</option></select>";  
			  C = R.insertCell();   
			  C.style.background="#f2f2f2";
			  C.style.border="0px";
			  C.innerHTML = "<a onclick='deleteRow(this)'><img style='cursor:hand;' src='images/icon/cancel.png'></a>";  
		 }
		 function deleteRow(obj)
		{
			 tab_idn.deleteRow(obj.parentElement.parentElement.rowIndex);
		 }
		function showdiv(obj) 
		{
			var objtype=obj.name;	
			if(objtype=="idn_buy_type")
			{
				if(obj.value==0)
				{
					$(".idn_reg").show();
					$(".idn_self").hide();
					
				}
				else
				{
					$(".idn_reg").hide();
					$(".idn_self").show();
				}
			}
			else if(objtype=="host_buy_type")
			{
				if(obj.value==0)
				{
					$(".host_reg").show();
					$(".host_self").hide();
					
				}
				else
				{
					$(".host_reg").hide();
					$(".host_self").show();
				}
			}
		}
function idn_checkform(fm)
{
	var idn_type=fm.idn_buy_type.value;
	var idn_domain="";
	var idn_buytime="";
	if(idn_type=="")
	{
		alert("请选择域名购买方式，方式不能为空！");
		return false;
	}
	else
	{
		if(idn_type==0)
		{
			var lens=fm.new_idn_domain.length;
			if(lens==undefined)
			{
				if(fm.new_idn_domain.value=="" || fm.idn_limit_year.value=="")
				{
					alert("您输入的域名和购买年限不能为空，请输入后进行提交！");
					return false;
				}
				else
				{
					fm.idn_domain.value=fm.new_idn_domain.value+"@"+fm.idn_limit_year.value+"/";
				}
			}
			else
			{
				for(var i=0;i<lens;i++)
				{
					domain=fm.new_idn_domain[i].value;
					year=fm.idn_limit_year[i].value;
					if(domain=="" || year=="")
					{
						
						alert(idn_domain+"您输入的域名和购买年限不能为空，请输入后进行提交！");
						return false;
					}
					else
					{
						idn_domain=idn_domain+domain+"@"+year+"/";
						fm.idn_domain.value=idn_domain;
					}
				}				
			}

		}
		else
		{
			if(fm.idn_domain_self.value=="")
			{
				alert("请输入客户提供的域名信息，输入不能为空！");
				return false;
			}
			else
			{
				fm.idn_domain.value=fm.idn_domain_self.value;
			}
		}
	}
}
function host_checkform(fm)
{
	var host_type=fm.host_buy_type.value;
	var host_name="";
	var host_buytime="";
	if(host_type=="")
	{
		alert("请选择主机购买方式，方式不能为空！");
		return false;
	}
	else
	{
		if(host_type==0)
		{
			if(fm.new_host_name.value=="" || fm.host_limit_year.value=="")
			{
				alert("您输入的主机型号和购买年限不能为空，请选择后进行提交！");
				return false;
			}
		}
		else
		{
			if(fm.ftp_address.value=="")
			{
				alert("请输入客户提供的FTP地址，输入不能为空！");
				return false;
			}
			else if(fm.ftp_name.value=="")
			{
				alert("请输入FTP帐号名称，输入不能为空！");
				return false;
			}
			else if(fm.ftp_password.value=="")
			{
				alert("请输入FTP密码，输入不能为空！");
				return false;
			}
		}
	}
}
function postoffice_checkform(fm)
{
	var postoffice_type=fm.postoffice_type.value;
	var com_idn=fm.com_idn.value;
	var user_amount=fm.user_amount.value;
	var postoffice_limit_year=fm.postoffice_limit_year.value;
	if(postoffice_type=="")
	{
		alert("请选择邮局型号，型号不能为空！");
		return false;
	}
	else if(com_idn=="")
	{
		alert("请输入绑定域名的名称，绑定的域名不能为空！");
		return false;
	}
	else if(user_amount=="")
	{
		alert("请输入邮局使用的用户数量，输入不能为空！");
		return false;
	}
	else if(postoffice_limit_year=="")
	{
		alert("请选择邮局的购买年限，不能为空！");
		return false;
	}
}

