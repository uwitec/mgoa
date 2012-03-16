{%extends file="_layouts/base_layout.tpl"%}


{%block page_table_title%}
<span style="width:300px;">{%$page_title%} <font color="#006666"> &gt;&gt;Order Resource Center </font></span>
<ul class="ul2" id="order_navigation">
    {%nocache%}
    {%foreach from=$order_navigation item=nav_item%}
        <li>
            <a href="{%url action=$nav_item.action%}">{%$nav_item.name%}</a>
            {%if $nav_item.Children%}
            <dl>
                {%foreach from=$nav_item.Children item=nc%}
                    <dt>
                        <a href="{%url action=$nc.action%}">{%$nc.name%}</a>
                    </dt>
                {%/foreach%}
            </dl>
            {%/if%}
        </li>
    {%/foreach%}
    {%if $is_customer_service%}
        <li><a href="{%url action="order/contacted"%}">我录入的所有订单</a></li>
    {%/if%}
    {%/nocache%}
</ul>
{%/block%}




{%block content%}

<table width="1248" cellspacing="0" cellpadding="0" border="0" class="table2">
	<!-- ======================表头========================== -->
	<thead>
	<tr>
        {%nocache%}
        <td align="center">订单ID</td>
        <td align="center">客服</td>
        {%if $paginator.items[0].Seller%}
            <td align="center">销售顾问</td>
        {%/if%}
        <td align="center">最近预约时间</td>
        <td align="center">公司名称</td>
        <td align="center">负责人</td>
        <td align="center">联系电话</td>
        <td align="center">客户地区</td>
        <td align="center">状态</td>
        {%if $operations%}
            <td align="center">操作</td>
        {%/if%}
        {%/nocache%}
    </tr>
	</thead>
        <!-- ======================内容========================== -->
		<tbody>
            {%nocache%}
            {%foreach from=$paginator.items item=item%}
            <tr align="center" ondblclick="location.href='{%url action='order/detail'%}{%$item.id%}'" class="trCol">

                <td>{%$item.id%}</td>
                <td>{%$item.CustomerService.username%}</td>
                {%if $item.Seller%}
                <td>{%$item.Seller.username%}</td>
                {%/if%}
                <td>{%$item.subscribe_time%}</td>
                <td>{%$item.Customer.company_name%}</td>
                <td>{%$item.Customer.name%}</td>
                <td>{%$item.Customer.telephone%}</td>
                <td>{%$item.Customer.areas%}</td>
                {%if $item.Workflow.state%}
                    <td align="center">{%$item.Workflow.state%}</td>
                {%else%}
                    <td align="center">{%$item.Workflow.alias%}</td>
                {%/if%}
                
                {%if $operations%}
                    <td>
                        {%* 这里要根据不同角色和不同的工作流程显示不同的操作 *%}
                        {%if $operations.action%}
                            <a href="{%url action=$operations.action%}{%$item.id%}/">{%$operations.label%}</a>
                        {%else%}
                            {%foreach from=$operations item=opera%}
                                <a href="{%url action=$opera.action%}{%$item.id%}/">{%$opera.label%}</a>
                            {%/foreach%}
                        {%/if%}
                    </td>
                {%/if%}
            </tr>
            {%foreachelse%}
            <tr>
                <td colspan="14" style="padding:10px;" align="center">没有找到相关的订单</td>
            </tr>
            {%/foreach%}
            
        <tr>
            <td align="right" style="background:#f2f2f2; height:28px; padding-right:15px;" colspan="11">
                {%include file="paginator.tpl"%}
            </td>
		</tr>
        {%/nocache%}
</tbody></table>

{%/block%}