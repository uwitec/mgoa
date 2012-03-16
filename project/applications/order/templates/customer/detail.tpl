{%extends file="_layouts/base_layout.tpl"%}

{%block content%}
<table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
    <tbody><tr style="height:30px;background:#cbe6a1;">
	<td colspan="6"><b>客户信息</b></td>
	</tr>
     <tr style="height:28px;">
        <td width="15%" style="background:#f2f2f2;" rowspan="7">网站负责人信息（必填）</td>
        <td width="15%" id="as" style="background:#f2f2f2;">公司名称</td>
        <td name="customer" id="company" class="colum_cont">{%$order.Customer.company_name%}</td>
        <td width="15%" style="background:#f2f2f2;">负责人</td>
        <td width="28%" name="customer" id="director" class="colum_cont">{%$order.Customer.name%}</td>
      </tr>
      <tr style="height:28px;">
        <td style="background:#f2f2f2;">身份证号</td>
        <td name="customer" id="NC_no" class="colum_cont"></td>
        <td style="background:#f2f2f2;">上传附件</td>
        <td id="as" class="colum_cont"><a href="#" class="green83">预览</a></td>
      </tr>
      <tr style="height:28px;">
        <td style="background:#f2f2f2;">负责人职务</td>
        <td name="customer" id="duty" class="colum_cont">{%$order.Customer.duty%}</td>
        <td style="background:#f2f2f2;">办公电话</td>
        <td name="customer" id="telephone" class="colum_cont">{%$order.Customer.telephone%}</td>
     </tr>
     <tr style="height:28px;">
        <td style="background:#f2f2f2;">联系人手机</td>
        <td name="customer" id="mobile" class="colum_cont">{%$order.Customer.mobile%}</td>
        <td style="background:#f2f2f2;">联系人QQ</td>
        <td name="customer" id="qq" class="colum_cont">{%$order.Customer.qq%}</td>
     </tr>
     <tr style="height:28px;">
        <td style="background:#f2f2f2;">联系邮箱</td>
        <td name="customer" id="email" class="colum_cont">{%$order.Customer.email%}</td>
        <td style="background:#f2f2f2;">邮编</td>
        <td name="customer" id="zip_no" class="colum_cont">{%$order.Customer.zip_no%}</td>
     </tr>
     <tr style="height:28px;">
        <td style="background:#f2f2f2;">示例网址</td>
        <td bgcolor="#FFFFFF" name="customer" id="net" class="colum_cont">{%$order.Customer.example_url%}</td>
        <td style="background:#f2f2f2;">客户提供资料</td>
        <td class="colum_cont">公司简介 <span class="ziliao_edit"> <a href="#" class="green83 aunder">重新上传</a></span></td>
     </tr>
     <tr style="height:28px;">
        <td style="background:#f2f2f2;">联系地址</td>
         <td bgcolor="#FFFFFF" name="customer" id="address" class="colum_cont" colspan="3">{%$order.Customer.address%}</td>
     </tr>
    

</tbody>
</table>

{%/block%}