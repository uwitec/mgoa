// JavaScript Document
$(function(){
	$(".chi_main_contant_help").hover(function(){
		var index = $(".chi_main_contant_help").index(this);
		$(this).children(".chi_main_contant_help_num").children("img").attr("src",'images/web/'+(index+11)+'.jpg');
		
	},function(){
		var index = $(".chi_main_contant_help").index(this);
		$(this).children(".chi_main_contant_help_num").children("img").attr("src",'images/web/'+(index+1)+'.jpg');
	})		   
})


























