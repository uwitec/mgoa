{%extends file="base.tpl"%}

{%block content%}
    <style type="text/css">
        #page_left, #page_content{float:left;display:inline;padding:10px;line-height:180%;}
        /*1290*/
        #page_left{width:200px;}
        #page_content{width:1010px;border-left:1px solid #ddd}

        #page_left dt, #page_left dd{padding:2px 4px;margin-right:10px;}
        #page_left dt{background:#777;color:#fff;font-size:14px;padding-left:5px}
    </style>
    <div id="page_left">
        <dl>
            <dt>内容设置</dt>
            <dd>
                <a href="{%url action="articles/post"%}?category=2">发布公告</a>
            </dd>
            <dd>
                <a href="{%url action="articles/post"%}">发布新内容</a>
            </dd>
            <dd>
                <a href="{%url action="manager/article_categories"%}">文章分类设置</a>
            </dd>
            <dt>工作相关设置</dt>
            <dd>
                <a href="{%url action="manager/workflow_permission"%}">工作流权限管理</a>
            </dd>
            <dt>员工/权限设置</dt>
            <dd>
                <a href="{%url action="manager/new_user"%}">新增员工</a>
            </dd>
            <dd>
                <a href="{%url action="manager/user_list"%}">员工列表</a>
            </dd>
            <dd>
                <a href="{%url action="manager/user_group"%}">用户组管理</a>
            </dd>
            <dd>
                <a href="{%url action="manager/roles"%}">角色/权限管理</a>
            </dd>
        </dl>
    </div>
    <div id="page_content">{%$smarty.block.child%}</div>
    <div class="clear"></div>
{%/block%}