{%extends file='base.tpl'%}

{%block content%}



<div class="index_m">
	<div class="index_m_title">
		 <a href="{%url action="order/new"%}">
            <img src="{%$MEDIA_URL%}images/web/bus_btn_img8.jpg">
		 </a>
		 <a href="{%url action="order/list"%}">
            <img src="{%$MEDIA_URL%}images/web/web_03.jpg">
		 </a>
		 <span style="width:300px;margin-top:10px;">麦谷OA系统 - 管理首页<font color="#006666"> &gt;&gt; Maganet OA</font></span>
    </div>
	<div class="index_m_b">
        <div class="index_m_b2">

            <div class="index_m_b2_contant">
                <div class="index_m_b2_contant_l">
                    <div class="index_m_b2_contant_l_title">
                        最新消息 <font face="candara">News</font>
                    </div>
                    <ul class="index_m_b2_contant_l_ul">
                        {%foreach from=$news item=n%}
                            <li>
                                <span>{%$n.created_at%}</span>
                                <a href="{%url action="articles/detail"%}{%$n.id%}/">{%$n.name%}</a>
                            </li>
                        {%/foreach%}
                    </ul>
                </div>
                <div class="index_m_b2_contant_r">
                    <div class="index_m_b2_contant_l_title">
                       待办事项 <font face="candara">Waiting for the matter at issue</font>
                    </div>
                    <ul class="index_m_b2_contant_l_ul">
                        <li><span>2011-05-06</span><a title="?dir=myself" href="?dir=myself">设置工作计划</a></li>
                        <li><span>2011-05-06</span><a title="?dir=myself&amp;nav=injob" href="?dir=myself&amp;nav=injob">填写您的入职信息表</a></li>
                        <li><span>2011-05-06</span><a title="?dir=myself&amp;nav=vacation" href="?dir=myself&amp;nav=vacation">员工请假</a></li>
                        <li><span>2011-05-06</span><a title="?dir=myself&amp;nav=meeting" href="?dir=myself&amp;nav=meeting">会议：</a></li>
                    </ul>
                </div>
                {%if $long_not_orders%}
                <div class="index_m_b2_contant_l mt-10">
                    <div class="index_m_b2_contant_l_title">
                       最近十个长时间未联系订单 
                    </div>
                    <ul class="index_m_b2_contant_l_ul">
                        {%foreach from=$long_not_orders item=lno%}
                            <li>
                                <a href="{%url action="order/detail"%}{%$lno.id%}/">{%$lno.Customer.company_name%} - {%$lno.Customer.name%}</a>
                            </li>
                        {%/foreach%}
                    </ul>
                </div>
                {%/if%}
                <div class="clear"></div>
            </div>
        </div>
	</div>
</div>



{%/block%}