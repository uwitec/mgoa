{%extends file="_layouts/base_layout.tpl"%}

{%block extra_statics append%}
<link href="{%$MEDIA_URL%}jquery-ui/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{%$MEDIA_URL%}jquery-ui/jquery-ui-1.8.11.min.js"></script>
{%/block%}

{%block js_init append%}
    $('#book_time').datepicker({
        'monthNames': ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        'dayNamesMin': ['日','一','二','三','四','五','六',],
        'dateFormat': 'yy-mm-dd '
    });
{%/block%}

{%block content%}
    <script type="text/javascript" src="{%$MEDIA_URL%}js/check_form_old.js"></script>
    <script type="text/javascript">
        function targetSub(sub)
        {
            if(sub=="file")
            {
                document.form2.action="common/func/upload.func.php";
                document.form2.enctype="multipart/form-data";
                document.form2.target="post_frame";
            }
            else
            {
                document.form2.action="?dir=center&sub=customer";
            }
            form2.submit();
        }
        function callback(imgs)
        {
            alert('上传成功!');
            //alert(imgs);
            form2.solution.value=imgs;
            $("#frm_sub_file").hide();
            $("#subspan").hide();
            $("#filespan").show();
            $("#filespan img").show();
        }
        $(document).ready(function(){
            $('#departchange').change(function(){
                var id=$('#departchange').val();
                var size=$("#departchange option").length;
                for(var i=1;i<=size;i++)
                {
                    if(i!=id)
                    {
                        $("#stafflist"+i).hide();
                    }else
                    {
                        $("#stafflist"+id).show();
                    }
                }
            });

            $('#subspan').click(function(){
                $("#frm_sub_file").toggle();
            });
            $('#filespan img').click(function(){
                $(this).hide();
                $("#frm_sub_file").show();
            });
        })
    </script>
    <form name="form2" action="{%url action="order/new"%}" class="form2" method="post" onSubmit="return input_checkform(this);" enctype="multipart/form-data">
        <table class="table9"  border="0" cellspacing="0" cellpadding="0" width="95%" align="center">
          <tr style="height:28px;">
            <td style="height:28px;background:#f2f2f2;" width="10%">公司名称</td>
            <td width="40%"><input type="text" name="company_name" class="company" value="无" style="width:80%;"/></td>
            <td style="height:28px;background:#f2f2f2;" width="10%">负责人姓名</td>
            <td width="40%"><input type="text" name="name" class="fzr_name" value="" /></td>
          </tr>
          <tr style="height:28px;">
            <td style="height:28px;background:#f2f2f2;">预约时间</td>
            <td>
            <input type="text" id="book_time" readonly="true" name="subscribe_time" class="book_time" />
            <select name="book_hour">
                {%section name=p loop=12%}
                    <option value="{%$smarty.section.p.index+8%}">{%$smarty.section.p.index+8%}</option>
                {%/section%}
            </select>
            <select name="book_minu">
                {%section name=p loop=6%}
                    <option value="{%$smarty.section.p.index*10%}">{%$smarty.section.p.index*10%}</option>
                {%/section%}
            </select>
            </td>
            <td style="height:28px;background:#f2f2f2;">负责人职务</td>
            <td><input type="text" name="duty" class="hr" value="无" /></td>
          </tr>
          <tr style="height:28px;">
            <td style="height:28px;background:#f2f2f2;">所属部门</td>
            <td>
            <input name="group_id" type="radio" checked="checked" value="0" />自动<input name="group_id" type="radio" value="3" />商务一部<input name="group_id" type="radio" value="4" />商务二部
            </td>
            <td style="height:28px;background:#f2f2f2;">联系人手机</td>
            <td><input type="text" name="mobile" class="lx_phone" value="" /></td>
          </tr>
          <tr style="height:28px;">
            <td style="height:28px;background:#f2f2f2;">办公电话</td>
            <td><input type="text" name="telephone" class="bg_phone" value="无" /></td>
            <td style="height:28px;background:#f2f2f2;">联系邮箱</td>
            <td><input type="text" name="email" class="lx_email" value="无" /></td>
          </tr>
          <tr style="height:28px;">
            <td style="height:28px;background:#f2f2f2;">联系QQ</td>
            <td><input type="text" name="qq" class="lx_qq" value="无" /></td>
            <td style="height:28px;background:#f2f2f2;">客户地区</td>
            <td><input type="text" name="areas" class="lx_dq" value="无" /></td>
          </tr>
          <tr style="height:28px;">
            <td style="height:28px;background:#f2f2f2;">示例网址</td>
            <td><input type="text" name="example_url" value="http://" style="width:290px;color:#0066FF"/></td>
            <td style="height:28px;background:#f2f2f2;">客户提供资料</td>
            <td class="floats">
                <input type="file" name="cus_docs" />
            </td>
          </tr>
          <tr style="height:28px;">
            <td style="height:28px;background:#f2f2f2;">客服沟通记录</td>
            <td><textarea cols="55" rows="5" name="community_log" style="height:80px"></textarea></td>
            <td style="height:28px;background:#f2f2f2;">其他</td>
            <td><textarea cols="55" rows="5" name="remark" class="qt" style="height:80px"></textarea></td>
          </tr>
          <tr style="height:28px;">
            <td colspan="4"><input type="submit" name="sub4" class="sub4 normal_button" value="提交表单" /></td>
          </tr>
        </table>
    </form>
    <form style="display:none;" id="frm_sub_file" name="form1" method="POST" action="common/func/upload.func.php" target="post_frame" enctype="multipart/form-data">
    <iframe name='post_frame' id="post_frame" style="display:none;" style="display:none;"></iframe>
    <input type="file" name="Filedata" />
    <input type="submit" value="上传图片" name="submit" />
    </form>
{%/block%}