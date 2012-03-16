{%extends file="_layouts/base_layout.tpl"%}

{%block extra_statics append%}
<link href="{%$MEDIA_URL%}jquery-ui/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{%$MEDIA_URL%}jquery-ui/jquery-ui-1.8.11.min.js"></script>
{%/block%}


{%block page_table_title append%}
    <ul class="ul2" id="order_navigation">
        {%nocache%}
        {%if $operations.action%}
            <li><a href="{%url action=$operations.action%}{%$order.id%}/">{%$operations.label%}</a></li>
        {%else%}
            {%foreach from=$operations item=opera%}
                <li><a href="{%url action=$opera.action%}{%$order.id%}/">{%$opera.label%}</a></li>
            {%/foreach%}
        {%/if%}
        {%/nocache%}
    </ul>
{%/block%}

{%block js_init append%}
    $('#add_communication').click(function(){
        $('#communication_dialog').dialog({
            'modal': true
        });

        $('#communication_dialog input[type="button"]').click(function(){
            var content = $('#communication_dialog textarea').val();
            $.post('{%url action='order/communication'%}{%$order.id%}/',
            {
                'content': content
            }, function(data){
                if(data == 'ok') {
                    window.location.href = window.location.href.replace('#nogo', '')
                } else {
                    alert('您没有权限进行此操作');
                }
            });
        });
    });

    $('#add_solution_button').click(function(){
        $('#add_solution').dialog({'modal': true, 'width': '400px'})
    });

    {%* 双击可编辑选项 *%}
    $('td.order_editable').dblclick(function(){
        var old_text = $(this).text();
        var obj = $(this);
        var id = this.id;
        if(id == 'editable__content') {
            var html = '<textarea name="'+id+'" class="input_text" style="width:90%;height:80px;">'+old_text+'</textarea>';
        } else if(id == 'editable__subscribe_time') {
            var html = '<input type="text" id="'+id+'" readonly="true" name="'+id+'" class="book_time" />';
        }else {
            var html = '<input type="text" name="'+id+'" class="input_text" value="'+old_text+'" style="width:90%" />';
        }
        
        $(this).html(html);
        if(id == 'editable__subscribe_time') {
            $('#subscribe_time').datepicker({
                'monthNames': ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
                'dayNamesMin': ['日','一','二','三','四','五','六',],
                'dateFormat': 'yy-mm-dd '
            });
        }
        $('[name="'+id+'"]').focus().blur(function(){
            var content = $(this).val();
            var key = $(this).attr('name');
            if(content && content != old_text) {
                $.post('{%url action="order/editable"%}{%$order.id%}/', {
                    'key': key,
                    'content': content
                }, function(data){
                    if(data) {
                        alert(data);
                    }
                    obj.text(content)
                });
            } else{
                obj.text(old_text)
            }
        });
    });
{%/block%}


{%block content%}

    {%if $order.Payment[0]->is_payed != '未付款'%}
    <table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
        <tbody>
            <tbody><tr style="height:30px;background:#cbe6a1;">
                <td colspan="6"><b>客户付款信息</b></td>
                </tr>
                <tr style="height:28px;">

                    <td style="background:#f2f2f2;">总价</td>
                    <td><font size="2" color="#33CC00">{%$order->Solution[0]->price%}</font>元</td>
                    <td style="background:#f2f2f2;">欠款</td>
                    <td><font size="2" color="#33CC00">{%$not_payed%}</font>元</td>
                    <td style="background:#f2f2f2;">接单日期</td>
                    <td>{%$order->created_at%}</td>

                </tr>
                <tr style="height:28px;">
                    <td style="background:#f2f2f2;">款额类别</td>
                    <td style="background:#f2f2f2;">支付金额</td>
                    <td width="15%" style="background:#f2f2f2;">支付日期</td>
                    <td style="background:#f2f2f2;">是否到账</td>
                    <td colspan="2" style="background:#f2f2f2;">其他</td>
                </tr>
                <tr style="height:28px;">
                    <td>首付款</td>
                    <td><font size="2" color="#33CC00">{%$order.Payment[0]->price%}</font>元</td>
                    <td>{%$order.Payment[0]->updated_at%}</td>
                    <td>{%$order.Payment[0]->is_payed%}</td>
                    <td>是否开票</td>
                    <td>{%$order.Payment[0]->invoice%}</td>
                </tr>
                <tr style="height:28px;">
                    <td>二期款</td>
                    <td><font size="2" color="#33CC00">{%$order.Payment[1]->price%}</font>元</td>
                    <td>{%$order.Payment[1]->updated_at%}</td>
                    <td>{%$order.Payment[1]->is_payed%}</td>
                    <td>是否对公</td>
                    <td>{%$order.Payment[0]->public%}</td>
                </tr>
                <tr style="height:28px;">
                    <td>尾款</td>
                    <td><font size="2" color="#33CC00">{%$order.Payment[2]->price%}</font>元</td>
                    <td>{%$order.Payment[2]->updated_at%}</td>
                    <td>{%$order.Payment[2]->is_payed%}</td>
                    <td>支付银行</td>
                    <td>{%$order.Payment[0]->bank%}</td>
                </tr>
            </tbody>
        </tbody>
    </table>
    {%/if%}

    <table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
        <tbody><tr style="height:30px;background:#cbe6a1;">
            <td colspan="6">
                <b style="float:left;">订单信息</b>
                <span style="float:right;margin-right:15px;diaplay:inline;font-family:Arial Black;color:#993300;">预约时间：&nbsp;{%$order.subscribe_time%}</span>
                <span style="float:right;margin-right:15px;diaplay:inline;font-family:Arial Black;color:#993300;">订单号&nbsp;{%$order.id%} - {%$order.Workflow.state%} -</span>
            </td>
        </tr>
        <tr style="height:28px;">
            <td width="10%" style="background:#f2f2f2;">近期预约</td>
            <td width="30%" class="order_editable" id="editable__subscribe_time">{%$order.subscribe_time%}</td>
            <td width="10%" style="background:#f2f2f2;">订单类别</td>
            <td width="25%" name="type" id="editable__type" class="order_editable">{%$order.type%}</td>
            <td width="10%" style="background:#f2f2f2;">建站周期（天）</td>
            <td width="15%" name="order" id="editable__duration" class="order_editable">{%$order.duration%}</td>
        </tr>
        <tr style="height:28px;">
            <td width="10%" style="background:#f2f2f2;">首页确认书</td>
            <td width="30%">
                {%if $order.index_decide_attachment%}
                    <a href="{%$order.index_decide_attachment%}" target="_blank">点击查看</a>
                {%/if%}
            </td>
            <td width="10%" style="background:#f2f2f2;">内页确认书</td>
            <td width="25%">
                {%if $order.inner_decide_attachment%}
                    <a href="{%$order.inner_decide_attachment%}" target="_blank">点击查看</a>
                {%/if%}
            </td>
            <td width="10%" style="background:#f2f2f2;">程序确认书</td>
            <td width="15%">
                {%if $order.programe_decide_attachment%}
                    <a href="{%$order.programe_decide_attachment%}" target="_blank">点击查看</a>
                {%/if%}
            </td>
        </tr>
        

        <tr style="height:28px;">
            <td style="background:#f2f2f2;">销售沟通记录</td>
            <td colspan="5">

            <div id="order_msg_hide">
                {%if $order.Communication%}
                    <ul>
                        {%foreach from=$order.Communication item=oc%}
                            <li>
                                [{%$oc.created_at%}]
                                {%$oc.User.username%}
                                {%$oc.content%}
                            </li>
                        {%/foreach%}
                    </ul>
                {%/if%}
            </div>
            <input type="button" value="添加沟通记录" id="add_communication" class="normal_button">

            <div style="display:none;" id="communication_dialog" title="添加沟通记录">
                <textarea style="width:100%;height:120px;"></textarea>
                <p style="text-align:right;padding:5px 8px;font-size:12px;">
                    <input type="button" class="normal_button" value="提交" />
                </p>
            </div>
            </td>
        </tr>
        <tr>
            <td width="10%" style="background:#f2f2f2;">其他信息</td>
            <td colspan="5" id="editable__content" class="order_editable">{%$order.content%}</td>
        </tr>
    </tbody></table>


    <table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
        <tbody><tr style="height:30px;background:#cbe6a1;">
        <td colspan="6">
            <b>客户信息</b>
            <span style="float:right;margin-right:15px;font-family:Calibri,Arial;color:#009900;">客服&nbsp;{%$order.CustomerService.username%}&nbsp;{%$order.Customer.created_at%}</span>
        </td>
        </tr>
         <tr style="height:28px;">
            <td width="10%" style="background:#f2f2f2;">公司名称</td>
            <td width="30%" id="editable__company_name" class="order_editable">{%$order.Customer.company_name%}</td>
            <td width="10%" style="background:#f2f2f2;">负责人</td>
            <td width="25%" id="editable__name" class="order_editable">{%$order.Customer.name%}</td>
            <td width="10%" style="background:#f2f2f2;">负责人职务</td>
            <td width="15%" id="editable__duty" class="order_editable">{%$order.Customer.duty%}</td>
          </tr>
          <tr style="height:28px;">
            <td style="background:#f2f2f2;">身份证号</td>
            <td name="customer" id="editable__card_no" class="order_editable">{%$order.Customer.card_no%}</td>
            <td style="background:#f2f2f2;">办公电话</td>
            <td id="editable__telephone" class="order_editable">{%$order.Customer.telephone%}</td>
            <td style="background:#f2f2f2;">联系手机</td>
            <td name="customer" id="editable__mobile" class="order_editable">{%$order.Customer.mobile%}</td>
          </tr>
          <tr style="height:28px;">
            <td style="background:#f2f2f2;">联系邮箱</td>
            <td id="editable__email" class="order_editable">{%$order.Customer.email%}</td>
            <td style="background:#f2f2f2;">联系人QQ</td>
            <td name="customer" id="editable__qq" class="order_editable">{%$order.Customer.qq%}</td>
            <td style="background:#f2f2f2;">邮编</td>
            <td name="customer" id="editable__zip_no" class="order_editable">{%$order.Customer.zip_no%}</td>
         </tr>
         <tr style="height:28px;">
            <td style="background:#f2f2f2;">联系地址</td>
            <td colspan="3" name="customer" id="editable__address" class="order_editable">{%$order.Customer.address%}</td>
            <td style="background:#f2f2f2;">地区</td>
            <td name="customer" id="editable__areas" class="order_editable">{%$order.Customer.areas%}</td>
         </tr>
         <tr style="height:28px;">
            <td style="background:#f2f2f2;">示例网址</td>
            <td bgcolor="#FFFFFF" id="editable__example_url" class="order_editable">{%$order.example_url%}</td>
            <td style="background:#f2f2f2;">客户提供资料</td>
            <td colspan="3">
                <a href="{%$order.Customer.docs%}" target="_blank">点击查看</a>
            </td>
         </tr>
         <tr style="height:30px;background:#cbe6a1;">
            <td colspan="6"><b>企事业单位信息</b></td>
         </tr>
         <tr style="height:28px;">
             <td style="background:#f2f2f2;">法人姓名</td>
             <td name="customer" id="editable__com_username" class="order_editable">{%$order.Customer.com_username%}</td>
             <td style="background:#f2f2f2;">邮箱</td>
             <td name="customer" id="editable__com_email" class="order_editable">{%$order.Customer.com_email%}</td>
             <td style="background:#f2f2f2;" colspan="2">单位通信地址（需精确到门牌号）</td>
          </tr>
          <tr style="height:28px;">
              <td style="background:#f2f2f2;">工商注册号码</td>
              <td name="customer" id="editable__com_code" class="order_editable">（企业填写）{%$order.Customer.com_code%}</td>
              <td style="background:#f2f2f2;">上传附件</td>
              <td><a href="#" class="green83">预览</a></td>
              <td name="customer" colspan="2" rowspan="2" id="editable__com_address" class="order_editable">{%$order.Customer.com_address%}</td>
          </tr>
          <tr style="height:28px;">
               <td style="background:#f2f2f2;">组织机构代码证</td>
               <td name="customer" id="editable__com_code2" class="order_editable">（事业单位填写）{%$order.Customer.com_code2%}</td>
               <td style="background:#f2f2f2;">上传附件</td>
               <td><a href="#" class="green83">预览</a></td>
          </tr>
          <tr style="height:28px;">
            <td style="background:#f2f2f2;">客服沟通记录</td>
            <td colspan="5">
                {%if $order.community_log%}
                    {%$order.community_log%}
                {%else%}
                    没有客服沟通记录
                {%/if%}
            </div>
            </td>
          </tr>
          
    </tbody>
    </table>





    <table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
		<tbody>
            <tr style="height:30px;background:#cbe6a1;">
                <td colspan="5"><b>客户方案</b>
                    <span style="margin-left:60px;font-family:Calibri,Arial;color:#009900;">
                    <input type="button" id="add_solution_button" value="添加方案" class="normal_button"></span>
                    <div id="add_solution" title="添加方案" style="display:none;">
                        <form action="{%url action='order/new_solution'%}{%$order.id%}/" method="POST" enctype="multipart/form-data">
                            <table style="width:100%;">
                                <tr>
                                    <td>方案编号</td>
                                    <td>
                                        <input type="text" name="solution_code" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>方案名称</td>
                                    <td>
                                        <input type="text" name="name" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>方案报价</td>
                                    <td>
                                        <input type="text" name="price" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>附件</td>
                                    <td>
                                        <input type="file" name="attachment" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <input type="submit" value="提交" class="normal_button" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </td>
            </tr>
            <tr style="height:28px;">
                <td width="20%" align="center" style="background:#f2f2f2;">方案编号</td>
                <td width="20%" align="center" style="background:#f2f2f2;">报 价</td>
                <td width="20%" align="center" style="background:#f2f2f2;">方案附件</td>
                <td width="20%" align="center" style="background:#f2f2f2;">确定时间</td>
                <td width="20%" align="center" style="background:#f2f2f2;">操作</td>
            </tr>
            {%if $order.Solution%}
                {%foreach from=$order.Solution item=solution%}
                <tr style="height:28px;" align="center">
                    <td width="20%">{%if $solution.state%}[当前选定]{%/if%}{%$solution.solution_code%}</td>
                    <td width="20%" style="font-family:Arial Black;color:#993300;">{%$solution.price%}</td>
                    <td width="20%"><a href="{%$solution.attachment%}" class="green83">查看</a></td>
                    <td width="20%">{%$solution.updated_at%}</td>
                    <td width="20%">{%$solution.updated_at%}</td>
                </tr>
                {%/foreach%}
            {%/if%}
        </tbody>
    </table>


    <table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
        <tbody>
            <tr style="height:30px;background:#cbe6a1;">
            <td colspan="7">
                <b>周边产品及服务</b>
                        <span style="margin-left:50px;font-family:Calibri,Arial;color:#009900;"><input type="button" onclick="showPeripheral('idn');" value="域  名" class="normal_button">&nbsp;&nbsp;<input type="button" onclick="showPeripheral('host');" value="虚拟主机" class="normal_button">&nbsp;&nbsp;<input type="button" onclick="showPeripheral('postoffice');" value="企业邮局" class="normal_button">&nbsp;&nbsp;<input type="button" onclick="showLate('show');" value="后期服务" class="normal_button"></span>
                    </td>
            </tr>
            <form method="post" action="?dir=center&amp;sub=afterservice&amp;list=trail&amp;id=102"></form>
                <tr style="display:none;height:28px;" id="addlate">
                    <td align="center" style="background:#f2f2f2;">服务类型</td>
                    <td align="center" colspan="5">
                                    <input type="radio" value="27" name="conf_afterservice" id="as0">
                        <label title="1980" for="as0">基本服务</label>&nbsp;
                                    <input type="radio" value="28" name="conf_afterservice" id="as1">
                        <label title="3980" for="as1">高级服务</label>&nbsp;
                                    <input type="radio" value="29" name="conf_afterservice" id="as2">
                        <label title="7000" for="as2">增值服务</label>&nbsp;
                                    <input type="radio" value="30" name="conf_afterservice" id="as3">
                        <label title="" for="as3">打包服务</label>&nbsp;
                                <input type="text" style="width: 50px; border: 1px solid rgb(187, 187, 187);" name="pack_service_account">元
                    </td>
                    <td align="center">
                        <input type="submit" name="submit" value="添加" class="normal_button">&nbsp;&nbsp;&nbsp;
                        <input type="reset" onclick="showLate('hide');" value="取消">
                    </td>
                </tr>

            <tr style="height:28px;">
              <td width="10%" style="background:#f2f2f2;" rowspan="1">域名信息</td>
              <td width="15%" align="center" style="background:#f2f2f2;">域名</td>
              <td width="5%" style="background:#f2f2f2;">购买年限</td>
              <td width="15%" align="center" style="background:#f2f2f2;">注册时间</td>
              <td width="10%" align="center" style="background:#f2f2f2;">域名类型</td>
              <td width="45%" align="center" colspan="2" style="background:#f2f2f2;">备注</td>
            </tr>
                <tr style="height:28px;">
              <td style="background:#f2f2f2;">400电话</td>
              <td colspan="7"></td>
            </tr>
            <tr style="height:28px;">
              <td style="background:#f2f2f2;">800客服</td>
              <td colspan="7"></td>
            </tr>
        </tbody>
    </table>




{%/block%}