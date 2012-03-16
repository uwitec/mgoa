{%extends file="_layouts/base_layout.tpl"%}



{%block content%}


    <table width="95%" cellspacing="0" cellpadding="5" border="0" style="margin:10px auto;" class="table9">
        <tbody>
            <tr style="height:30px;background:#cbe6a1;">
                <td colspan="7">
                    <b>选择设计师</b>
                </td>
            </tr>
            {%foreach from=$designer item=di%}
                <tr>
                    <td>{%$di.name%}</td>
                    <td>
                        <a href="{%url action='order/select_designer'%}{%$order.id%}/designer/{%$di.id%}/">选择我</a>
                        {%if $di.id == $order.designer_id%}[当前选择]{%/if%}
                    </td>
                </tr>
            {%/foreach%}
            <tr style="height:30px;background:#cbe6a1;">
                <td colspan="7">
                    <b>选择布局师</b>
                </td>
            </tr>
            {%foreach from=$layouter item=di%}
                <tr>
                    <td>{%$di.name%}</td>
                    <td>
                        <a href="{%url action='order/select_designer'%}{%$order.id%}/layouter/{%$di.id%}/">选择我</a>
                        {%if $di.id == $order.layouter_id%}[当前选择]{%/if%}
                    </td>
                </tr>
            {%/foreach%}
            <tr style="height:30px;background:#cbe6a1;">
                <td colspan="7">
                    <b>选择程序员</b>
                </td>
            </tr>
            {%foreach from=$programmer item=di%}
                <tr>
                    <td>{%$di.name%}</td>
                    <td>
                        <a href="{%url action='order/select_designer'%}{%$order.id%}/programmer/{%$di.id%}/">选择我</a>
                        {%if $di.id == $order.programmer%}[当前选择]{%/if%}
                    </td>
                </tr>
            {%/foreach%}
        </tbody>
    </table>























{%/block%}