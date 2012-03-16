{%extends file='_layouts/base_layout.tpl'%}

{%block extra_style append%}
    <link href="{%$MEDIA_URL%}yaml/screen/forms.css" rel="stylesheet" type="text/css" />
{%/block%}

{%block aside%}
    register
{%mailto address='xiaolan@golehe.net' encode="javascript" subject="Hello"%}
{%html_select_date%}
{%/block%}

{%block content%}
<div>
    {%if $register_form.messages%}
        <ul>
        {%foreach from=$register_form.messages item=msg%}
            <li>{%$msg%}</li>
        {%/foreach%}
        </ul>
    {%/if%}
</div>
<form action="{%url action='accounts/register' param=$params%}" method="POST" class="yform page-login-form">
    {%$register_form|as_div%}
    {%csrf_protected%}
    <div class="type-button">
        <input type="button" value="Button" />
        <input type="reset" value="Reset" />
        <input type="submit" value="Submit" />
    </div>
</form>

{%/block%}