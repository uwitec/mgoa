/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function reload_js_and_css() {
    $('script[src]').each(function() {
        rs = $(this).attr('src').indexOf('firebug');
        if(rs < 0) {
            $(this).attr('src', $(this).attr('src')+'?v='+Math.random());
        }
    });
    
    $('link[href]').each(function() {
        $(this).attr('href', $(this).attr('href')+'?v='+Math.random());
    });
}

function reload_image() {
    $('img[src]').each(function() {
        $(this).attr('src', $(this).attr('src')+'?random='+Math.random());
    });
}
