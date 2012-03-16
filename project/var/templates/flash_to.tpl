{%extends file="_layouts/base_layout.tpl"%}

{%block content%}
    <script type="text/javascript">
        var i = {%$timeout%};
        var reTime = setInterval(function(){
            i -= 1;
            if(i<0){

                window.location.href= '{%$flash_to_url%}'
                window.clearInterval(reTime);
                return;

            }
            document.getElementById("seconds").innerHTML = i;
        },1000);

    </script>
    <table width="50%" cellspacing="0" cellpadding="0" border="0" class="table_ddxq">
      <tbody><tr>
        <td width="163" bgcolor="#F3F7F0" align="left" class="table_ddxq_r"><b><font size="2" color="#FF0000">操作提示</font></b></td>
      </tr>
      <tr>
        <td bgcolor="#F7F7F7" align="left" class="table_ddxq_r"><font size="2" color="#FF6600">{%$message%}</font></td>
      </tr>
      <tr>
        <td height="154" align="center" class="table_ddxq_r">
            <p>&nbsp;</p>
            <p><img width="16" height="16" border="0" style="padding-top:8px;margin-right:10px;" src="{%$MEDIA_URL%}images/loading.gif">
                <strong>
                <span style="font-family:'Arial';color:#FF0033;padding-top:7px;margin-right:5px;font-size:16px;" id="seconds">{%$timeout%}</span>
                秒后自动返回
                </strong>
            </p>
            <p><a id="url" href="{%$flash_to_url%}">如果您的浏览器没有自动跳转，请点击这里！ </a>
            </p>
            <p>&nbsp;</p>
        </td>
      </tr>
    </tbody></table>
{%/block%}