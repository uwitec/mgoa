$(function() {
    $('#admin_site_menus div.admin_site_menu_title').click(function() {
        $(this).toggleClass('opened').next().slideToggle('fast');
    });
});
