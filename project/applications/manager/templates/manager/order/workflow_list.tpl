{%extends file="base_admin.tpl"%}

{%block content%}
    <table width="100%" class="table2">
        <tr>
            <th>ID</th>
            <th>工作流名称</th>
            <th>订单当前状态</th>
            <th>拥有查看权限</th>
            <th>操作</th>
        </tr>
        {%foreach from=$paginator.items item=item%}
            <tr align="center">
                <td>{%$item.id%}</td>
                <td>{%$item.name%}</td>
                <td>{%$item.state%}</td>
                <td>{%$item.roles%}</td>
                <td>
                    <a href="{%url action="manager/workflow_edit/"%}{%$item.id%}/">编辑</a>
                </td>
            </tr>
        {%/foreach%}
        <tr>
            <td colspan="6" align="right">{%include file="paginator.tpl"%}</td>
        </tr>
    </table>
{%/block%}