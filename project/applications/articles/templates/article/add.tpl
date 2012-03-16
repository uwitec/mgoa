{%extends file='_layouts/work.tpl'%}

{%block content%}
    <script type="text/javascript" src="{%$MEDIA_URL%}KindEditor/kindeditor.js"></script>
    <style type="text/css">
        .yform .as-p-data,.yform .as-p-label{padding:3px 5px;font-size:12px;}
    </style>
    <form class="yform" action="{%if $article.id%}{%url action="articles/edit"%}{%$article.id%}/{%else%}{%url action="articles/post"%}{%/if%}" method="POST" style="width:810px;margin:0 auto">
        <p class="as-p-data type-text">
            {%html_options name=category_id options=$categories selected=$selected_category%}
            <input type="text" name="name" id="name"  minlength="2"  maxlength="255" style="width:694px"  placeholder="请输入标题" value="{%$article.name%}" required="true" />
        </p>
        <p class="as-p-data type-text">
            <input type="text" name="alias" id="alias"  minlength="2"  maxlength="255" style="width:786px"  placeholder="请输入文章别名" value="{%$article.alias%}" />
        </p>
        <p class="as-p-data type-text">
            <script type="text/javascript">
                KE.show({
                    id : 'content',
                    width: '800px',
                    height: '400px',
                    imageUploadJson : '{%url action='editor/upload'%}',
                    afterCreate : function(id) {
                        KE.event.ctrl(document, 13, function() {
                            KE.util.setData(id);
                            document.forms['example'].submit();
                        });
                        KE.event.ctrl(KE.g[id].iframeDoc, 13, function() {
                            KE.util.setData(id);
                            document.forms['example'].submit();
                        });
                    }
                });
            </script>
            <textarea name="content" id="content"  width="800px"  height="400px" required="true">{%$article.content%}</textarea>
        </p>

        <div style="padding:5px;text-align:center;">
            <input type="submit" class="normal_button" value="提 交" style="width:70px;" />
        </div>
    </form>
{%/block%}