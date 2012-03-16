{%extends file='_layouts/base_layout.tpl'%}

{%block content%}
<table width="95%" cellspacing="0" cellpadding="5" border="0" class="table9" style="margin:10px auto;">
    <tbody>
        <tr style="height:30px;background:#cbe6a1;">
            <td colspan="6">
                <b>上传合同附件 - 订单号： {%$order.id%}</b>
                - <a href="{%url action="order/detail"%}{%$order.id%}/" target="_blank">查看订单详情</a>
            </td>
        </tr>
        <tr>
            <td align="left" style="padding:10px;">
                <form enctype="multipart/form-data" method="POST" action="{%url action="order/contract"%}{%$order.id%}/paper/">
                    <input type="file" name="paper_attachment" style="border:1px solid #ddd" />
                    <input type="submit" class="normal_button" value="上传合同附件" />
                    {%if $order.paper_attachment%}
                        已经上传过合同附件， <a href="{%$order.paper_attachment%}">点击查看</a>
                    {%/if%}
                </form>
            </td>
        </tr>
        <tr>
            <td align="right" style="padding-right:10px;">
                <a href="{%url action='order/contract'%}{%$order.id%}/solution/">返回上一步 选择方案</a>
                {%if $order.paper_attachment%}
                    , <a href="{%url action='order/contract'%}{%$order.id%}/payment/">您已经上传过合同附件， 请点击进入下一步</a>
                {%/if%}
            </td>
        </tr>
    </tbody>
</table>
{%/block%}