{%extends file="base_admin.tpl"%}

{%block content%}
    <form method="POST" action="{%url action="manager/workflow_edit/"%}{%$workflow.id%}/">
    <table width="100%" class="table2">
        <tr>
            <th width="120">工作流名称</th>
            <td>
                {%$workflow.name%}
            </td>
        </tr>
        <tr>
            <th width="120">工作流别名</th>
            <td>
                {%$workflow.alias%}
            </td>
        </tr>
        <tr>
            <th width="120">拥有权限者</th>
            <td>
                {%html_checkboxes options=$all_roles selected=$roles name='roles'%}
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <input type="submit" class="normal_button" value="提 交" />
            </td>
        </tr>
    </table>
{%/block%}