{%extends file="_layouts/base_layout.tpl"%}

{%block extra_statics append%}
<link href="{%$MEDIA_URL%}jquery-ui/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{%$MEDIA_URL%}jquery-ui/jquery-ui-1.8.11.min.js"></script>
{%/block%}

{%block content%}
    <style type="text/css">
        td.as-table-label, td.as-table-data{padding:3px 5px;}
        .normal_table td, .normal_table th{padding:5px 5px; text-align:center;}
    </style>
    {%if $paginator.items%}
    <table class="normal_table" style="float:right;width:50%">
        <thead>
            <tr bgcolor="#ddd">
                <th>请假人</th>
                <th>请假时间</th>
                <th>请假原因</th>
                <th>类型</th>
                <th>状态</th>
                {%if $has_role%}
                    <th>操作</th>
                {%/if%}
            </tr>
        </thead>
        <tbody>
            {%foreach from=$paginator.items item=item%}
                <tr>
                    <td>{%$item.Owner.username%}</td>
                    <td>{%$item.form_data.leave_time%} ~ {%$item.form_data.end_time%}</td>
                    <td>{%$item.form_data.reason%}</td>
                    <td>{%$item.form_data.type%}</td>
                    <td>{%$item.state%}</td>
                    {%if $has_role%}
                        <td>
                            <a href="{%url action="forms/state"%}?id={%$item.id%}&state=1">同意</a>
                            <a href="{%url action="forms/state"%}?id={%$item.id%}&state=2">拒绝</a>
                        </td>
                    {%/if%}
                </tr>
            {%/foreach%}
            <tr>
                <td colspan="5">{%include file="paginator.tpl"%}</td>
            </tr>
        </tbody>
    </table>
    {%/if%}
    
    <form action="{%url action="forms/leave"%}" method="POST" style="float:left;width:40%">
        <table style="width:630px;">
            {%$leave_form|as_table%}
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="提交请假申请" class="normal_button" />
                </td>
            </tr>
        </table>
    </form>
    <div class="clear"></div>
{%/block%}