{%extends file="base_admin.tpl"%}

{%block content%}
    <table width="100%" class="table2">
        <tr>
            <th>分类ID</th>
            <th>分类名称</th>
            <th>分类别名</th>
            <th>文章数量</th>
            <th>拥有权限者</th>
            <th>操作</th>
        </tr>
        {%foreach from=$paginator.items item=item%}
            <tr align="center">
                <td>{%$item.id%}</td>
                <td>{%$item.name%}</td>
                <td>{%$item.alias%}</td>
                <td>
                    {%$item.Article|@count%}
                </td>
                <td>{%$item.manager%}</td>
                <td>
                    <a href="{%url action="manager/category_edit"%}{%$item.id%}/">编辑</a>
                    <a href="{%url action="manager/category_delete"%}{%$item.id%}/" onclick="return confirm('确定要删除分类吗？ 建议您不要这样做！！')">删除</a>
                </td>
            </tr>
        {%/foreach%}
        <tr>
            <td colspan="6" align="right">{%include file="paginator.tpl"%}</td>
        </tr>
    </table>
{%/block%}