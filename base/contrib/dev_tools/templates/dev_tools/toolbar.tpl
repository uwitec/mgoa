{%extends 'empty.tpl'%}
{%block content%}
    <link href="{%$MEDIA_URL%}dev_toolbar/style.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="{%$MEDIA_URL%}dev_toolbar/toolbar.js"></script>
    <script type="text/javascript" src="{%$MEDIA_URL%}dev_toolbar/firebug-lite.js"></script>
    <script type="text/javascript">
        $(function(){
            $('#devel_toolbar_show').click(function(){
                var right = parseInt($('#devel_toolbar_container').css('right'));
                if(right < 0) {
                    $('#devel_toolbar_container').animate({right: '0px'}, 200);
                } else {
                    $('#devel_toolbar_container').animate({right: '-274px'}, 200);
                }
                
            });

        });
    </script>
    <div id="devel_toolbar_container">
        
        <div id="devel_toolbar_show" class="float_left"><img src="{%$MEDIA_URL%}dev_toolbar/logo.gif" alt="Devel Toolbar" /></div>
        <div id="devel_toolbar" class="float_left">
            <div class="devel_toolbar_item">
                <ul>
                    <li>
                        <span onclick="javascript:reload_js_and_css()">{%trans%}Reload the JS and CSS{%/trans%}</span>
                    </li>
                    <li>
                        <span onclick="javascript:reload_image()">{%trans%}Reload the images{%/trans%}</span>
                    </li>
                    <li>
                        <span>{%trans%}Press F12 open the firebug{%/trans%}</span>
                    </li>
                </ul>
            </div>
            <div class="devel_toolbar_item">
                <ul>
                    <li>
                        <span>Current action: {%$config.runtime.application%}/{%$config.runtime.action%}</span>
                    </li>
                    <li>
                        <span>
                            {%trans%}Run-Mode:{%/trans%} {%$config.base.RUN_MODE%}<br />
                            {%trans%}Default cache backend:{%/trans%} {%$config.base.CACHE_BACKEND%}<br />
                            {%trans%}Installed applications:{%/trans%}
                            <ul style="text-align:right;">
                                {%foreach from=$config.base.INSTALLED_APPS item=app%}
                                    <li>{%$app%}</li>
                                {%/foreach%}
                            </ul>
                        </span>
                    </li>

                </ul>
            </div>
            <div class="devel_toolbar_item">
                <ul>
                    <li>
                        {%nocache%}<span>Processed in {%$processed_in%}</span>{%/nocache%}
                    </li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    </div>
{%/block%}