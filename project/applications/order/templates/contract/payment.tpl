{%extends file='_layouts/base_layout.tpl'%}

{%block content%}
<style type="text/css">
    table{border:none;border-left:1px solid #ddd;border-bottom:1px solid #ddd}
    table td{border-top:1px solid #ddd;border-right:1px solid #ddd;padding:0px 5px;}
</style>
<form method="POST" action="{%url action="order/contract"%}{%$order.id%}/payment/">
    <table  style="margin:30px auto;" cellspacing="0" cellpadding="5" width="70%">
    <tr style="height:30px;background:#cbe6a1;;">
        <td colspan="4">
            <b>填写客户需付款信息</b>
            - <a href="{%url action="order/detail"%}{%$order.id%}/" target="_blank">查看订单详情</a>
        </td>
    </tr>
    <tr style="height:28px;background:#ffffff;cursor:hand;">
        <td align="center" style="height:28px;">首付款</td>
        <td><input type="text" name="deposit" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"></td>
        <td align="center" style="height:28px;">是否开票</td>
        <td><input type="checkbox" id="invoice" name="invoice" value="1"><label for="invoice">  是</label></td>
    </tr>
    <tr style="height:28px;background:#ffffff;cursor:hand;">

        <td align="center" style="height:28px;">二期款</td>
        <td><input type="text" name="payment" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"></td>

        <td align="center" style="height:28px;">是否对公</td>
        <td><input type="checkbox" id="pub" name="pub" value="1"><label for="pub">  是</label></td>

    </tr>
    <tr style="height:28px;background:#ffffff;cursor:hand;">
        <td align="center" style="height:28px;">尾  款</td>
        <td><input type="text" name="last_pay" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"></td>
        <td align="center" style="height:28px;">支付银行</td>
        <td>
        <select name="bank">
                <option value="中国银行">中国银行</option>
                <option value="中国工商银行">中国工商银行</option>
                <option value="中国农业银行">中国农业银行</option>
                <option value="中国建设银行">中国建设银行</option>
                <option value="中国交通银行">中国交通银行</option>
                <option value="北京银行">北京银行</option>
                <option value="深圳银行">深圳银行</option>
                <option value="中国发展银行">中国发展银行</option>
                <option value="齐鲁银行">齐鲁银行</option>
            </select>
        </td>
    </tr>
    <tr style="height:30px;background:#cbe6a1;;">
        <td colspan="4">客户已支付款项</td>
    </tr>
    <tr style="height:28px;background:#ffffff;cursor:hand;">
        <td align="left" style="height:28px;" colspan="4">
            <input type="checkbox" name="is_deposit" id="py1" value="1"> <label for="py1"> 首付款 </label>
            <input type="checkbox" name="is_payment" id="py2" value="2"> <label for="py2"> 二期款 </label>
            <input type="checkbox" name="is_last_pay" id="py3" value="3"> <label for="py3"> 尾   款  </label>
        </td>
    </tr>
    <tr>
        <td align="center" colspan="4"><input type="submit" class="normal_button" value="提交表单， 完成订单签约" /></td>
    </tr>
    <tr>
        <td align="right" colspan="4" style="padding:3px 5px;height:22px;line-height:22px;">
            <a href="{%url action="order/contract"%}{%$order.id%}/paper/">返回上一步， 重新上传合同附件</a>&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
    </table>
</form>
{%/block%}