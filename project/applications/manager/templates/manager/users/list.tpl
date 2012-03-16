{%extends file="base_admin.tpl"%}

{%block content%}
    <table width="100%" class="table2">
        <tr>
            <th>姓名</th>
            <th>密码</th>
            <th>用户组</th>
            <th>角色</th>
            <th>操作</th>
        </tr>
        {%foreach from=$paginator.items item=item%}
            <tr align="center">
                <td>{%$item.username%}</td>
                <td>{%$item.password%}</td>
                <td>{%$item.Group.name%}</td>
                <td>
                    {%foreach from=$item.Role item=ir name="ir"%}
                        {%$ir.name%}
                        {%if !$smarty.foreach.ir.last%} 、{%/if%}
                    {%/foreach%}
                </td>
                <td>操作</td>
            </tr>
        {%/foreach%}
        <tr>
            <td colspan="6" align="right">{%include file="paginator.tpl"%}</td>
        </tr>
    </table>
{%/block%}