{%extends file="_layouts/work.tpl"%}

{%block content%}
    <script type="text/javascript">
        function check_pp_form() {
            if(!$('input[name="old_password"]') || !$('input[name="new_password"]') || !$('input[name="repeat_password"]')) {
                alert('请仔细填写');
                return false;
            }
        }
    </script>
    <form method="POST" action="{%url action="accounts/change_password"%}" onsubmit="return check_pp_form()">
        <table class="table9" style="width:500px;margin:0 auto;">
            <tr>
                <td align="right">原密码 </td>
                <td><input type="password" name="old_password" required /></td>
            </tr>
            <tr>
                <td align="right">新密码 </td>
                <td><input type="password" name="new_password" required /></td>
            </tr>
            <tr>
                <td align="right">重复新密码 </td>
                <td><input type="password" name="repeat_password" required /></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" class="normal_button" value="修改密码" /></td>
            </tr>
        </table>
    </form>
{%/block%}