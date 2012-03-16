{%extends file='_layouts/work.tpl'%}

{%block page_table_title append%}
    <div style="float:right;font-weight:normal">
        <a href="{%url action="articles/post"%}?category={%$category.id%}">发布</a>
    </div>
{%/block%}

{%block content%}
<table width="1266" cellspacing="0" cellpadding="0" border="0" class="table1">
    <thead>
      <tr>
        <td align="center">ID</td>
        <td align="center">主题</td>
        <td align="center">发布者</td>
        <td align="center">发布时间</td>
        <td align="center">最后更新</td>
        <td align="center">操作</td>
      </tr>
    </thead>
    <tbody bgcolor="#ffffff">
        {%foreach from=$paginator.items item=ai%}
            <tr ondblclick="location.href='{%url action="articles/detail"%}{%$ai.id%}'" style="height:28px;" class="trCol">
                <td align="center">{%$ai.id%}</td>
                <td align="center">{%$ai.name%}</td>
                <td align="center">{%$ai.Author.username%}</td>
                <td align="center">{%$ai.created_at%}</td>
                <td align="center">{%$ai.updated_at%}</td>
                <td align="center">
                    <a href="{%url action="articles/detail"%}{%$ai.id%}/">查看</a>
                    <a href="{%url action="articles/edit"%}{%$ai.id%}/">编辑</a>
                    <a href="{%url action="articles/delete"%}{%$ai.id%}/">删除</a>
                </td>
            </tr>
        {%foreachelse%}
            <tr>
                <td colspan="6" style="padding:10px;" align="center">没有找到相关的信息</td>
            </tr>
        {%/foreach%}
        <tr align="right">
            <td align="right" style="background:#f2f2f2; height:28px; padding-right:15px;" colspan="6">
                {%include file="paginator.tpl"%}
            </td>
        </tr>
    </tbody>
</table>
{%/block%}