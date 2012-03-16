/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$.fn.validator = function(options) {

    $(this).submit(function(){
        var length = $(this).children('.type-text, type-select').length;;

        for(var i=0; i<length; i++) {
            var obj = $(this).children('.type-text, type-select').eq(i).children('input, select, textarea');
            if(obj.attr('required') == 'true') {
                //this.required(obj);
            }
        }

    });

    this.required = function(obj) {
        if(obj.val() != obj.attr('default') && $.trim(obj.val())) {
            alert('ok');
        } else {
            alert('no');
        }
    }
}