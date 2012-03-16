{%extends file='_layouts/one_column.tpl'%}

{%block content%}
<div style="text-align:center;margin-top:50px;" class="warning">
    {%trans%}Warning: make sure you really in devel Run-Mode, and there isn't important data database.{%/trans%}
    <a href="{%url action="dev/syncdb"%}?confirm=true">{%trans%}Yes, I'm sure.{%/trans%}</a>,
    <a href="{%url action="dev/syncdb"%}?confirm=true&ignore_yaml=true">Yes, and ignore YAML</a>
</div>
{%/block%}