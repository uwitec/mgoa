/*
 * extends  jQuery.hasAttr('attr');
 **/
$.fn.hasAttr = function(attr_name) {
    return $(this).attr(attr_name) != 'undefined';
}