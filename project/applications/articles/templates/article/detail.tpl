{%extends file="_layouts/work.tpl"%}
{%block content%}
		<div class="wzxx_title">
        	<h3>{%$article.name%}</h3>
            <p>
                发布人：{%$article.Author.username%}
                发布时间：{%$article.created_at%}
                <a href="{%url action="articles/edit"%}{%$article.id%}/">修改</a>
                <a href="{%url action="articles/delete"%}{%$article.id%}/">删除</a>
            </p>
        </div>
		<div class="wzxx_contant">
            {%$article.content%}
		</div>
      
{%/block%}