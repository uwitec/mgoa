


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
                    <a href="{%url action='customer/select_designer'%}{%$order.id%}/{%$di.id%}">选择我</a>
                </td>
            </tr>
        {%/foreach%}
    </tbody>
</table>






<!--
<div id="ydy_contant">
<div class="khjt_title"></div>
	<div><img src="{%$MEDIA_URL%}customer/images/web/web_ydy_02.gif"></div>
    <div class="ydy_contant_m">
    	<div class="ydy_contant_m_title"><img src="{%$MEDIA_URL%}customer/images/web/web_ydy_03.gif"></div>
        <p class="ydy_contant_m_p">由于部分设计师工作量达到饱和，为保证您的设计质量，请选择以下设计师中的一位为您服务：</p>
        <ul class="ydy_contant_m_ul">
		        	<li style="margin-left:0px;" class="">
				<a href="?dir=viewdesign&amp;id=4" src="{%$MEDIA_URL%}customer/images/web/web_ydy_06.gif" class="ydy_contant_m_a score-0">
				<img src="{%$MEDIA_URL%}customer/images/staff_photo/32.gif">
				</a>
				23
			</li>
			        	<li style="margin-left:0px;" class="">
				<a href="?dir=viewdesign&amp;id=7" src="{%$MEDIA_URL%}customer/images/web/web_ydy_06.gif" class="ydy_contant_m_a score-0">
				<img src="{%$MEDIA_URL%}customer/images/staff_photo/32.gif">
				</a>
				32
			</li>
			        	<li style="margin-left:0px;" class="">
				<a href="?dir=viewdesign&amp;id=12" src="{%$MEDIA_URL%}customer/images/web/web_ydy_06.gif" class="ydy_contant_m_a score-0">
				<img src="{%$MEDIA_URL%}customer/images/staff_photo/32.gif">
				</a>
				44
			</li>
			        	<li style="margin-left:0px;" class="show_img_active">
				<a href="?dir=viewdesign&amp;id=15" src="{%$MEDIA_URL%}customer/images/web/web_ydy_06.gif" class="ydy_contant_m_a score-0">
				<img src="{%$MEDIA_URL%}customer/images/staff_photo/32.gif">
				</a>
				61
			</li>
			        	<li style="margin-left:0px;">
				<a href="?dir=viewdesign&amp;id=32" src="{%$MEDIA_URL%}customer/images/web/web_ydy_06.gif" class="ydy_contant_m_a score-0">
				<img src="{%$MEDIA_URL%}customer/images/staff_photo/32.gif">
				</a>
				设计师
			</li>
			        </ul>
    </div>
    <div><img src="{%$MEDIA_URL%}customer/images/web/web_ydy_01.gif"></div>
	<div class="show_img">
	    	<div class="show_img_contant" style="display: none; ">
			<p style="text-align:right; padding-right:60px; margin:8px 0px 12px;">
			目前参与项目：<span>2</span> 客户评分：<span>2</span>分
			</p>
			<p style="width:655px;">
			23:我叫孟果，19岁，性格活泼，开朗自信，是一个不轻易服输的人。带着十分的真诚，怀着执着希望来参加贵单位的招聘，希望我的到来能给您带来惊喜，给我带来希望。

			</p>
			<p></p>
        </div>
	    	<div class="show_img_contant" style="display: none; ">
			<p style="text-align:right; padding-right:60px; margin:8px 0px 12px;">
			目前参与项目：<span>2</span> 客户评分：<span>2</span>分
			</p>
			<p style="width:655px;">
			32:我叫孟果，19岁，性格活泼，开朗自信，是一个不轻易服输的人。带着十分的真诚，怀着执着希望来参加贵单位的招聘，希望我的到来能给您带来惊喜，给我带来希望。

			</p>
			<p></p>
        </div>
	    	<div class="show_img_contant" style="display: none; ">
			<p style="text-align:right; padding-right:60px; margin:8px 0px 12px;">
			目前参与项目：<span>2</span> 客户评分：<span>3</span>分
			</p>
			<p style="width:655px;">
			44:我叫孟果，19岁，性格活泼，开朗自信，是一个不轻易服输的人。带着十分的真诚，怀着执着希望来参加贵单位的招聘，希望我的到来能给您带来惊喜，给我带来希望。

			</p>
			<p></p>
        </div>
	    	<div class="show_img_contant" style="display: block; ">
			<p style="text-align:right; padding-right:60px; margin:8px 0px 12px;">
			目前参与项目：<span>2</span> 客户评分：<span>5</span>分
			</p>
			<p style="width:655px;">
			61:我叫孟果，19岁，性格活泼，开朗自信，是一个不轻易服输的人。带着十分的真诚，怀着执着希望来参加贵单位的招聘，希望我的到来能给您带来惊喜，给我带来希望。

			</p>
			<p></p>
        </div>
	    	<div class="show_img_contant" style="display: none; ">
			<p style="text-align:right; padding-right:60px; margin:8px 0px 12px;">
			目前参与项目：<span>2</span> 客户评分：<span>8</span>分
			</p>
			<p style="width:655px;">
			设计师:我叫孟果，19岁，性格活泼，开朗自信，是一个不轻易服输的人。带着十分的真诚，怀着执着希望来参加贵单位的招聘，希望我的到来能给您带来惊喜，给我带来希望。

			</p>
			<p></p>
        </div>
	    </div>
</div>
-->