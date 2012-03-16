{%if $order.Payment%}


<table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
    <tbody>
        <tbody><tr style="height:30px;background:#cbe6a1;">
            <td colspan="6"><b>客户付款信息</b></td>
            </tr>
            <tr style="height:28px;">

                <td style="background:#f2f2f2;">总价</td>
                <td><font size="2" color="#33CC00">{%$order->Solution[0]->price%}</font>元</td>
                <td style="background:#f2f2f2;">欠款</td>
                <td><font size="2" color="#33CC00">{%$not_payed%}</font>元</td>
                <td style="background:#f2f2f2;">接单日期</td>
                <td>{%$order->created_at%}</td>

            </tr>
            <tr style="height:28px;">
                <td style="background:#f2f2f2;">款额类别</td>
                <td style="background:#f2f2f2;">支付金额</td>
                <td width="15%" style="background:#f2f2f2;">支付日期</td>
                <td style="background:#f2f2f2;">是否到账</td>
                <td colspan="2" style="background:#f2f2f2;">其他</td>
            </tr>
            <tr style="height:28px;">
                <td>首付款</td>
                <td><font size="2" color="#33CC00">{%$order.Payment[0]->price%}</font>元</td>
                <td>{%$order.Payment[0]->updated_at%}</td>
                <td>{%$order.Payment[0]->is_payed%}</td>
                <td>是否开票</td>
                <td>{%$order.Payment[0]->invoice%}</td>
            </tr>
            <tr style="height:28px;">
                <td>二期款</td>
                <td><font size="2" color="#33CC00">{%$order.Payment[1]->price%}</font>元</td>
                <td>{%$order.Payment[1]->updated_at%}</td>
                <td>{%$order.Payment[1]->is_payed%}</td>
                <td>是否对公</td>
                <td>{%$order.Payment[0]->public%}</td>
            </tr>
            <tr style="height:28px;">
                <td>尾款</td>
                <td><font size="2" color="#33CC00">{%$order.Payment[2]->price%}</font>元</td>
                <td>{%$order.Payment[2]->updated_at%}</td>
                <td>{%$order.Payment[2]->is_payed%}</td>
                <td>支付银行</td>
                <td>{%$order.Payment[0]->bank%}</td>
            </tr>
        </tbody>
    </tbody>
</table>
{%/if%}

<table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
    <tbody><tr style="height:30px;background:#cbe6a1;">
        <td colspan="6">
            <b>订单信息</b>
            <span style="float:right;margin-right:15px;font-family:Arial Black;color:#993300;">预约时间：&nbsp;{%$order.subscribe_time%}</span>
            <span style="float:right;margin-right:15px;font-family:Arial Black;color:#993300;">订单号&nbsp;{%$order.id%}</span>
        </td>
    </tr>
    <tr style="height:28px;">
        <td width="10%" style="background:#f2f2f2;">近期预约</td>
        <td width="30%">{%$order.subscribe_time%}</td>
        <td width="10%" style="background:#f2f2f2;">订单类别</td>
        <td width="25%" name="type" id="editable__type" class="order_editable">{%$order.type%}</td>
        <td width="10%" style="background:#f2f2f2;">建站周期（天）</td>
        <td width="15%" name="order" id="editable__duration" class="order_editable">{%$order.duration%}</td>
    </tr>

    <tr style="height:28px;">
        <td style="background:#f2f2f2;">销售沟通记录</td>
        <td colspan="5">

        <div id="order_msg_hide">
            {%if $order.Communication%}
                <ul>
                    {%foreach from=$order.Communication item=oc%}
                        <li>
                            [{%$oc.created_at%}]
                            {%$oc.User.username%}
                            {%$oc.content%}
                        </li>
                    {%/foreach%}
                </ul>
            {%/if%}
        </div>
        </td>
    </tr>
</tbody></table>


<table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
    <tbody><tr style="height:30px;background:#cbe6a1;">
    <td colspan="6">
        <b>客户信息</b>
        <span style="float:right;margin-right:15px;font-family:Calibri,Arial;color:#009900;">客服&nbsp;{%$order.Customer.created_at%}</span>
    </td>
    </tr>
     <tr style="height:28px;">
        <td width="10%" style="background:#f2f2f2;">公司名称</td>
        <td width="30%">{%$order.Customer.company_name%}</td>
        <td width="10%" style="background:#f2f2f2;">负责人</td>
        <td width="25%">{%$order.Customer.name%}</td>
        <td width="10%" style="background:#f2f2f2;">负责人职务</td>
        <td width="15%">{%$order.Customer.duty%}</td>
      </tr>
      <tr style="height:28px;">
        <td style="background:#f2f2f2;">身份证号</td>
        <td name="customer" id="editable__card_no" class="order_editable">{%$order.Customer.card_no%}</td>
        <td style="background:#f2f2f2;">办公电话</td>
        <td>{%$order.Customer.telephone%}</td>
        <td style="background:#f2f2f2;">联系手机</td>
        <td name="customer" id="mobile">{%$order.Customer.mobile%}</td>
      </tr>
      <tr style="height:28px;">
        <td style="background:#f2f2f2;">联系邮箱</td>
        <td>{%$order.Customer.email%}</td>
        <td style="background:#f2f2f2;">联系人QQ</td>
        <td name="customer" id="qq">{%$order.Customer.name%}</td>
        <td style="background:#f2f2f2;">邮编</td>
        <td name="customer" id="editable__zip_no" class="order_editable">{%$order.Customer.zip_no%}</td>
     </tr>
     <tr style="height:28px;">
        <td style="background:#f2f2f2;">联系地址</td>
        <td colspan="3" name="customer" id="editable__address" class="order_editable">{%$order.Customer.address%}</td>
        <td style="background:#f2f2f2;">地区</td>
        <td name="customer" id="areas">{%$order.Customer.areas%}</td>
     </tr>
     <tr style="height:28px;">
        <td style="background:#f2f2f2;">示例网址</td>
        <td bgcolor="#FFFFFF">{%$order.example_url%}</td>
        <td style="background:#f2f2f2;">客户提供资料</td>
        <td>公司简介 <span class="ziliao_edit"> <a href="#" class="green83 aunder">重新上传</a></span></td>
        <td style="background:#f2f2f2;">上传附件</td>
        <td><a href="#" class="green83">预览</a></td>
     </tr>
     <tr style="height:30px;background:#cbe6a1;">
        <td colspan="6"><b>企事业单位信息</b></td>
     </tr>
     <tr style="height:28px;">
         <td style="background:#f2f2f2;">法人姓名</td>
         <td name="customer" id="legal_person">{%$order.Customer.com_username%}</td>
         <td style="background:#f2f2f2;">邮箱</td>
         <td name="customer" id="unit_email">{%$order.Customer.com_email%}</td>
         <td style="background:#f2f2f2;" colspan="2">单位通信地址（需精确到门牌号）</td>
      </tr>
      <tr style="height:28px;">
          <td style="background:#f2f2f2;">工商注册号码</td>
          <td name="customer" id="register_no">（企业填写）{%$order.Customer.com_code%}</td>
          <td style="background:#f2f2f2;">上传附件</td>
          <td><a href="#" class="green83">预览</a></td>
          <td name="customer" id="unit_address" colspan="2" rowspan="2">{%$order.Customer.com_address%}</td>
      </tr>
      <tr style="height:28px;">
           <td style="background:#f2f2f2;">组织机构代码证</td>
           <td name="customer" id="unit_no">（事业单位填写）{%$order.Customer.com_code2%}</td>
           <td style="background:#f2f2f2;">上传附件</td>
           <td><a href="#" class="green83">预览</a></td>
      </tr>
      <tr style="height:28px;">
        <td style="background:#f2f2f2;">客服沟通记录</td>
        <td colspan="5">
            {%if $order.community_log%}
                {%$order.community_log%}
            {%else%}
                没有客服沟通记录
            {%/if%}
        </div>
        </td>
      </tr>

</tbody>
</table>







<table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
    <tbody>
        <tr style="height:30px;background:#cbe6a1;">
            <td colspan="4"><b>客户方案</b>
                <span style="margin-left:60px;font-family:Calibri,Arial;color:#009900;">
                <input type="button" id="add_solution_button" value="添加方案" class="normal_button"></span>
                <div id="add_solution" title="添加方案" style="display:none;">
                    <form action="{%url action='order/new_solution'%}{%$order.id%}/" method="POST" enctype="multipart/form-data">
                        <table style="width:100%;">
                            <tr>
                                <td>方案编号</td>
                                <td>
                                    <input type="text" name="solution_code" />
                                </td>
                            </tr>
                            <tr>
                                <td>方案名称</td>
                                <td>
                                    <input type="text" name="name" />
                                </td>
                            </tr>
                            <tr>
                                <td>方案报价</td>
                                <td>
                                    <input type="text" name="price" />
                                </td>
                            </tr>
                            <tr>
                                <td>附件</td>
                                <td>
                                    <input type="file" name="attachment" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" value="提交" class="normal_button" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
        </tr>
        <tr style="height:28px;">
            <td width="15%" align="center" style="background:#f2f2f2;">方案编号</td>
            <td width="15%" align="center" style="background:#f2f2f2;">报 价</td>
            <td width="15%" align="center" style="background:#f2f2f2;">方案附件</td>
            <td width="15%" align="center" style="background:#f2f2f2;">确定时间</td>
        </tr>
        {%if $order.Solution%}
            {%foreach from=$order.Solution item=solution%}
            <tr style="height:28px;" align="center">
                <td width="15%">{%if $solution.state%}[当前选定]{%/if%}{%$solution.solution_code%}</td>
                <td width="15%" style="font-family:Arial Black;color:#993300;">{%$solution.price%}</td>
                <td width="15%"><a href="{%$solution.attachment%}" class="green83">查看</a></td>
                <td width="15%">{%$solution.updated_at%}</td>
            </tr>
            {%/foreach%}
        {%/if%}
    </tbody>
</table>


<table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
    <tbody>
        <tr style="height:30px;background:#cbe6a1;">
        <td colspan="7">
            <b>周边产品及服务</b>
                    <span style="margin-left:50px;font-family:Calibri,Arial;color:#009900;"><input type="button" onclick="showPeripheral('idn');" value="域  名" class="normal_button">&nbsp;&nbsp;<input type="button" onclick="showPeripheral('host');" value="虚拟主机" class="normal_button">&nbsp;&nbsp;<input type="button" onclick="showPeripheral('postoffice');" value="企业邮局" class="normal_button">&nbsp;&nbsp;<input type="button" onclick="showLate('show');" value="后期服务" class="normal_button"></span>
                </td>
        </tr>
        <form method="post" action="?dir=center&amp;sub=afterservice&amp;list=trail&amp;id=102"></form>
            <tr style="display:none;height:28px;" id="addlate">
                <td align="center" style="background:#f2f2f2;">服务类型</td>
                <td align="center" colspan="5">
                                <input type="radio" value="27" name="conf_afterservice" id="as0">
                    <label title="1980" for="as0">基本服务</label>&nbsp;
                                <input type="radio" value="28" name="conf_afterservice" id="as1">
                    <label title="3980" for="as1">高级服务</label>&nbsp;
                                <input type="radio" value="29" name="conf_afterservice" id="as2">
                    <label title="7000" for="as2">增值服务</label>&nbsp;
                                <input type="radio" value="30" name="conf_afterservice" id="as3">
                    <label title="" for="as3">打包服务</label>&nbsp;
                            <input type="text" style="width: 50px; border: 1px solid rgb(187, 187, 187);" name="pack_service_account">元
                </td>
                <td align="center">
                    <input type="submit" name="submit" value="添加" class="normal_button">&nbsp;&nbsp;&nbsp;
                    <input type="reset" onclick="showLate('hide');" value="取消">
                </td>
            </tr>

        <tr style="height:28px;">
          <td width="10%" style="background:#f2f2f2;" rowspan="1">域名信息</td>
          <td width="15%" align="center" style="background:#f2f2f2;">域名</td>
          <td width="5%" style="background:#f2f2f2;">购买年限</td>
          <td width="15%" align="center" style="background:#f2f2f2;">注册时间</td>
          <td width="10%" align="center" style="background:#f2f2f2;">域名类型</td>
          <td width="45%" align="center" colspan="2" style="background:#f2f2f2;">备注</td>
        </tr>
            <tr style="height:28px;">
          <td style="background:#f2f2f2;">400电话</td>
          <td colspan="7"></td>
        </tr>
        <tr style="height:28px;">
          <td style="background:#f2f2f2;">800客服</td>
          <td colspan="7"></td>
        </tr>
    </tbody>
</table>