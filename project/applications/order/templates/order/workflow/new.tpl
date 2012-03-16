{%extends file="_layouts/base_layout.tpl"%}

{%block page_table_title%}
<span style="width:300px;">订单资源中心 <font color="#006666"> &gt;&gt;Order Resource Center </font></span>
<ul class="ul2">
<li>
    <a class="ny_m_title_a_hover" href="{%url action="order/ls/1"%}"> 新增订单管理</a>

    <dl style="opacity: 0.8; display: block;">
    </dl>
</li>
<li>
        <a href="{%url action="order/ls/2"%}">跟进订单管理</a>
        <dl style="opacity: 0.8; display: none;">
        <dt><a href="?dir=center&amp;list=trail&amp;t=A">A[一周]</a></dt>
        <dt><a href="?dir=center&amp;list=trail&amp;t=B">B[一月]</a></dt>
        <dt><a href="?dir=center&amp;list=trail&amp;t=C">C[一季]</a></dt>
        <dt><a href="?dir=center&amp;list=trail&amp;t=D">D[一年]</a></dt>
</dl>
</li>
<li>
    <a href="{%url action="order/ls/3"%}">长期跟进订单管理</a>
    <dl style="display: none;">
</dl>
</li>
<li>
                <a href="{%url action="order/ls/4"%}">拉黑订单管理</a>
<dl style="display: none;">
                        </dl>
</li>
<li>
                <a href="{%url action="order/ls/5"%}">签约订单管理</a>
                <dl style="display: none;">
        <dt><a href="?dir=center&amp;list=sign&amp;type=deposit">定金付款</a></dt>
        <dt><a href="?dir=center&amp;list=sign&amp;type=program">项目订单</a></dt>
        <dt><a href="?dir=center&amp;list=sign&amp;type=payment">二期付款</a></dt>
        <dt><a href="?dir=center&amp;list=sign&amp;type=last_pay">尾款付款</a></dt>
        <dt><a href="?dir=center&amp;list=sign&amp;type=done">完成订单</a></dt>
    </dl>
</li>
<li>
                <!--<a href="?dir=center&amp;list=wpullblack">待拉黑订单管理</a>-->
                <dl style="display: none;">
                        </dl>
</li>
</ul>
{%/block%}





{%block content%}

<table width="1248" cellspacing="0" cellpadding="0" border="0" class="table2">
	<!-- ======================表头========================== -->
	<thead>
	<tr>
				<td align="center">订单ID</td>
				<td align="center">客服</td>
				<td align="center">销售顾问</td>
				<td align="center">最近预约时间</td>
				<td align="center">公司名称</td>
				<td align="center">联系电话</td>
				<td align="center">负责人</td>
				<td align="center">客户地区</td>
				<td align="center">最后联系时间</td>
				<td align="center">沟通记录</td>
				<td align="center">报价</td>
			</tr>
	</thead>
	<!-- ======================内容========================== -->
		<tbody>
            {%foreach from=$paginator.items item=item%}
            <tr align="center" ondblclick="javascript:window.location.href='{%url action="order/detail"%}{%$item.id%}/'" class="trCol">
                <td>{%$item.id%}</td>
                <td>kf</td>
                <td>xsjl</td>
                <td>{%$item.Customer.subscribe_time%}</td>
                <td>{%$item.Customer.company_name%}</td>
                <td>{%$item.Customer.telephone%}</td>
                <td>{%$item.Customer.name%}</td>
                <td>{%$item.Customer.areas%}</td>
                <td>没有联系记录</td>
                <td><span title="添加沟通记录">添加沟通记录...</span></td>
                <td>暂无报价</td>
            </tr>
            {%/foreach%}
		<!--====================分页========================= -->
	<tr>
		<td align="right" style="background:#f2f2f2; height:28px; padding-right:15px;" colspan="11">
            Pages:
            <span class="">共{%$paginator.num_objects%}条记录 共{%$paginator.num_pages%}页 当前是第{%$paginator.current_page%}页</span>
            {%if $paginator.has_previous%}
                <a href="{%url action="posts/lists/"%}{%$paginator.previous%}/">Previous</a>
            {%/if%}
            {%foreach from=$paginator.page_range item="page"%}
                {%if $page == $paginator.current_page%}
                    <span class="current_page">{%$page%}</span>
                {%else%}
                    <a href="{%url action="posts/lists/page"%}">{%$page%}</a>
                {%/if%}
            {%/foreach%}
            {%if $paginator.has_next%}
                <a href="{%url action="posts/lists"%}{%$paginator.next%}/">Next</a>
            {%/if%}
		</td>
		</tr>
</tbody></table>

{%/block%}