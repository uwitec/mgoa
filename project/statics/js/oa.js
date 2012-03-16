// JavaScript Document
$(function(){
	$(".table1 tbody tr").hover(function(){
		$(this).toggleClass("colorw"); 									 
	})
	var _li = $(".ul2 > li");
	var _dl = $(".ul2 > li > dl");
	_dl.css("display","none");
	_li.hover(function(){
		$(this).children("dl").toggle().css("opacity","0.8");
	})
	$(".table111 tr:even").css("backgroundColor","#f7f7f7");
	$(".table_xx_xx_contant").hover(function(){
		$(this).children(".table_xx_xx_title").toggleClass("table_xx_xx_title_active");										 
	})

    $('tr td').hover(function(){
        $(this).parent('tr').attr('bgcolor', '#f2f2f2');
    }, function() {
        $(this).parent('tr').attr('bgcolor', '#ffffff');
    });
})


























