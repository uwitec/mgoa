{%extends file='_layouts/base_layout.tpl'%}


{%block aside%}
    <script type="text/javascript" src="{%$MEDIA_URL%}admin/admin.js"></script>

    <div id="admin_site_menus">
        {%foreach from=$admin_menus item=menu_groups%}
            <div class="menu_items">
                <div class="admin_site_menu_title" name="{%$menu_groups.name%}">
                    {%$menu_groups.name%}
                </div>
                <ul class="hidden">
                    {%foreach from=$menu_groups.items item=menu_item%}
                        <li>
                            <a href="{%url name=$menu_item.action_name%}">{%$menu_item.label%}</a>
                        </li>
                    {%/foreach%}
                </ul>
            </div>
        {%/foreach%}
    </div>
{%/block%}