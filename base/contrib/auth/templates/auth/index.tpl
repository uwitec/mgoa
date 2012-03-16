{%extends '_layouts/right_sidebar.tpl'%}

{%block content%}
    {%$user.info.username%}
{%/block%}

{%block aside%}

{%load plugin='gravatar.gravatar'%}
{%gravatar email=$user.info.email onerror="`$MEDIA_URL`.statics"%}

{%/block%}
