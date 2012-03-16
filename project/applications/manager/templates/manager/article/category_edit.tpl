{%extends file="base_admin.tpl"%}

{%block content%}
    <form method="POST" action="{%url action="manager/category_edit/"%}{%$category.id%}/">
    <table width="100%" class="table2">
        <tr>
            <th width="120">分类名称</th>
            <td>
                <input type="text" value="{%$category.name%}" name="name" />
            </td>
        </tr>
        <tr>
            <th width="120">分类别名</th>
            <td>
                <input type="text" value="{%$category.alias%}" disabled="disabled" />
            </td>
        </tr>
        <tr>
            <th width="120">拥有权限者</th>
            <td>
                {%html_checkboxes options=$roles selected=$checked name='roles'%}
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <input type="submit" class="normal_button" value="提 交" />
            </td>
        </tr>
    </table>
{%/block%}