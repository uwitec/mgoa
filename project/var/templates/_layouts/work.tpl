{%extends file="_layouts/base_layout.tpl"%}

{%block content%}
	<ul class="index_m_b2_ul1">
        <li><a title="工作流程" href="{%url action="articles/detail/workflow"%}">工作流程</a></li>
        <li><a title="值日表" href="{%url action="articles/category/duty"%}">值日表</a></li>
        <li><a title="精彩分享" href="{%url action="articles/category/share"%}">精彩分享</a></li>
        <li><a title="培训资料" href="{%url action="articles/category/train"%}">培训资料</a></li>
        <li><a title="规章制度" href="{%url action="articles/category/regulations"%}">规章制度</a></li>
        <li><a title="会议计划" href="{%url action="articles/category/mettings"%}">会议计划</a></li>
        <li><a title="入职表" href="{%url action="forms/injob"%}">入职表</a></li>
        <li><a title="请假单" href="{%url action="forms/leave"%}">请假单</a></li>
        <li><a title="出差申请" href="{%url action="forms/travel"%}">出差申请</a></li>
        <li><a title="工作计划" href="{%url action="mine/work_plan"%}">工作计划</a></li>
        <li><a title="修改密码" href="{%url action="accounts/change_password"%}">修改密码</a></li>
        <div class="clear"></div>
    </ul>
    <div class="clear"></div>
    {%$smarty.block.child%}
{%/block%}