{%extends file='_layouts/base_layout.tpl'%}

{%block content%}
<table width="95%" cellspacing="0" cellpadding="5" border="0" class="table9" style="margin:10px auto;">
    <tbody>
        <tr style="height:30px;background:#cbe6a1;">
            <td colspan="6">
                <b>订单方案列表 - 订单号： {%$order.id%}</b>
                - <a href="{%url action="order/detail"%}{%$order.id%}/" target="_blank">查看订单详情</a>
            </td>
        </tr>
        <tr style="height:28px;">
            <td width="20%" align="center" style="background:#f2f2f2;">方案编号</td>
            <td width="20%" align="center" style="background:#f2f2f2;">报 价</td>
            <td width="20%" align="center" style="background:#f2f2f2;">方案附件</td>
            <td width="20%" align="center" style="background:#f2f2f2;">确定时间</td>
            <td width="20%" align="center" style="background:#f2f2f2">操作</td>
        </tr>
        {%foreach from=$order.Solution item=solution%}
        <tr style="height:28px;{%if $solution.state == 1%}{%assign var="is_selected" value="true"%}color:#534F50{%/if%}" align="center">
            <td width="20%">{%$solution.solution_code%}</td>
            <td width="20%" style="font-family:Arial Black;color:#993300;">{%$solution.price%}</td>
            <td width="20%"><a href="{%$solution.attachment%}" class="green83">查看</a></td>
            <td width="20%">{%$solution.updated_at%}</td>
            <td width="20%">
                <a href="{%url action="order/contract"%}{%$order.id%}/solution/?id={%$solution.id%}">选择此方案</a>
                {%if $solution.state == 1%}(已选定此方案){%/if%}
            </td>
        </tr>
        {%/foreach%}
        {%if $is_selected%}
        <tr>
            <td colspan="6" align="right" style="padding-right:5px;">
                <a href="{%url action="order/contract"%}{%$order.id%}/paper/">如果您已经选定方案， 请直接进入下一步</a>
            </td>
        </tr>
        {%/if%}
    </tbody>
</table>
{%/block%}