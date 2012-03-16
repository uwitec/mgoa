{%extends file='_layouts/customer.tpl'%}
{%block extra_statics append%}
<link href="{%$MEDIA_URL%}jquery-ui/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{%$MEDIA_URL%}jquery-ui/jquery-ui-1.8.11.min.js"></script>
{%/block%}
{%block content%}
    <style type="text/css">
        table.table2{margin-top:30px;}
        #customer_head{width:1248px;margin:0 auto;margin-top:30px;}
        #ajax_response{margin-top:20px;padding:10px;}
    </style>
    <div id="customer_head">
        您好 {%$customer.CustomerUser.username%}， 欢迎您使用麦谷网络客户操作中心。
        <a href="{%url action='accounts/logout'%}">退出登录</a>

        <table width="1248" cellspacing="0" cellpadding="0" border="0" class="table2">
            <thead>
                <tr align="center">
                    <td>订单ID</td>
                    <td>订单状态</td>
                    <td>客服</td>
                    <td>销售顾问</td>
                    <td>公司名称</td>
                    <td>联系人</td>
                    <td>操作</td>
                </tr>
            </thead>
            <tbody>
                {%foreach from=$orders item=order%}
                    <tr align="center">
                        <td>{%$order.id%}</td>
                        <td>{%$order.Workflow.state%}</td>
                        <td>{%$order.CustomerService.username%}</td>
                        <td>{%$order.Seller.username%}</td>
                        <td>{%$order.Customer.company_name%}</td>
                        <td>{%$order.Customer.name%}</td>
                        <td>
                            <a href="{%url action='customer/detail'%}{%$order.id%}/" id="click_get_order_detail" class="ajax_element">订单详情</a>
                            {%if $order.Workflow.sequence == '8'%}
                                <a href="{%url action='customer/select_designer'%}{%$order.id%}/" class="ajax_element" id="click_select_designer">选择设计师</a>
                            {%/if%}
                            {%if $order.Workflow.sequence == '10'%}
                                <a href="#nogo" onclick="javascript:$('#decide_index').dialog({'modal':true})">确定首页效果图</a>
                                <div id="decide_index" title="首页效果图确认" style="display:none; ">
                                    <form method="POST" action="{%url action='customer/decide_index'%}{%$order.id%}/" style="text-align:center;line-height:30px;" enctype="multipart/form-data">
                                        请您上传首页效果图确认书：<br />
                                        <input type="file" name="attachment" />
                                        <br /><br />
                                        <input type="submit" value="提交" class="normal_button" />
                                    </form>
                                </div>
                            {%/if%}

                            {%if $order.Workflow.sequence == '15'%}
                                <a href="{%url action='customer/decide_inner'%}{%$order.id%}/">确定内页效果图</a>
                            {%/if%}

                            {%if $order.Workflow.sequence == '19'%}
                                <a href="#nogo" onclick="javascript:$('#decide_program').dialog({'modal':true})">确定网站程序</a>
                                <div id="decide_program" title="网站程序确认" style="display:none; ">
                                    <form method="POST" action="{%url action='customer/decide_programe'%}{%$order.id%}/" style="text-align:center;line-height:30px;" enctype="multipart/form-data">
                                        请您上传网站程序验收确认书：<br />
                                        <input type="file" name="attachment" />
                                        <br /><br />
                                        <input type="submit" value="提交" class="normal_button" />
                                    </form>
                                </div>
                            {%/if%}
                        </td>
                    </tr>
                {%/foreach%}
            </tbody>
        </table>

        <div id="ajax_response">

        </div>
    </div>

        
{%/block%}

{%block js_init%}
    $('.ajax_element').each(function(){
        var ajax_url = $(this).attr('href');
        $(this).attr('href', "javascript:void(0)");
        $(this).click(function(){
            $.get(ajax_url, function(data){
                $('#ajax_response').html(data).fadeIn();
            });
        });
    });
{%/block%}