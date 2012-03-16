{%extends file="base_admin.tpl"%}

{%block content%}
    <form method="POST" class="yform" action="{%url action="manager/new_user"%}">
        <table>
            {%if $register_form.messages%}
                {%foreach from=$register_form.messages item=rm%}
                    <tr>
                        <td colspan="2" class="error">{%$rm%}</td>
                    </tr>
                {%/foreach%}
            {%/if%}
            <tr></tr>
            {%$register_form|as_table%}
            <tr>
                <td>所属用户组</td>
                <td>
                    {%html_options options=$all_groups name="group"%}
                </td>
            </tr>
            <tr>
                <td>角色</td>
                <td>
                    {%foreach from=$all_roles item=ar name="ar"%}
                        <input type="checkbox" name="roles[]" value="{%$ar.id%}" /> {%$ar.name%}
                    {%/foreach%}
                </td>
            </tr>
            <tr>
                <td>是否启用</td>
                <td>
                    <input type="radio" name="is_active" value="1" checked="true" />是
                    <input type="radio" name="is_active" value="0" />否
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" class="normal_button" value="添加新员工" />
                </td>
            </tr>
        </table>
    </form>
{%/block%}