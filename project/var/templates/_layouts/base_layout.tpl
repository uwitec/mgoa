{%extends 'base.tpl'%}
{%block content%}
<div class="index_m">
	<div class="ny_m_title">

    	  {%block page_table_title%}<span>{%$page_title%}</span>{%/block%}

    </div>
    <div class="index_m_b">
    	<div class="index_m_b2">
        {%$smarty.block.child%}
      </div>
    </div>

</div>
{%/block%}