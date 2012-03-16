Pages:
<span class="">共{%$paginator.num_objects%}条记录 共{%$paginator.num_pages%}页 当前是第{%$paginator.current_page%}页</span>
{%if $paginator.has_previous%}
    <a href="?page={%$paginator.previous%}">Previous</a>
{%/if%}
{%foreach from=$paginator.page_range item="page"%}
    {%if $page == $paginator.current_page%}
        <span class="current_page">{%$page%}</span>
    {%else%}
        <a href="?page={%$page%}">{%$page%}</a>
    {%/if%}
{%/foreach%}
{%if $paginator.has_next && $paginator.items%}
    <a href="?page={%$paginator.next%}">Next</a>
{%/if%}