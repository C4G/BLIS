/* =========================================================
// jquery.flipv.js
// Author: OpenStudio (Arnault PACHOT)
// Mail: apachot@openstudio.fr
// Web: http://www.openstudio.fr
// Copyright (c) 2008 OpenStudio http://www.openstudio.fr
========================================================= */


(function($) {

$.fn.flipv = function(options) {
	
	this.each(function(){ 	
		var htmlsav = $(this).html();
		var textsav = $(this).text();
		var fontsizesav = '13';
		if ($(this).css('font-size') != '') {
			fontsizesav = parseInt($(this).css('font-size'));
		}
		var heightsav = $(this).height();
		var widthsav = textsav.length*fontsizesav*.60;
		
		var colorsav = '#CCC';
		if ($(this).css('color'))
			colorsav = $(this).css('color');
			
		if ($.browser.msie) {
			$(this).css('font-size', fontsizesav).css('width', heightsav+'px').css('height', widthsav+'px').css('font-family', 'Verdana').css('writing-mode', 'tb-rl').css('font-weight', 'normal');
		} else {
			var my_id = "canvas"+parseInt(Math.random()*1000);
			$(this).empty().append("<canvas id='"+my_id+"' width='"+heightsav+"' height='"+widthsav+"'>"+htmlsav+"</canvas>");
			vertical_text(textsav, fontsizesav, colorsav, my_id);
		}
		
	});
	return $(this);
};
})(jQuery);

function vertical_text(mytext, fontsize, colorsav, my_id){
	var canvas = document.getElementById(my_id);
	if (canvas.getContext){
		var context = canvas.getContext('2d');
		set_textRenderContext(context);
		if(check_textRenderContext(context)) {
			context.translate(80,0);
			context.rotate(Math.PI/2);
			context.strokeStyle = colorsav;
			context.strokeText(mytext,3,60,fontsize-2);
			
		}
	}
}

$(document).ready(function(){
	$('.flipv').flipv();
});


