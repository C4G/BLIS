/*
 * jWizard jQuery Plugin
 * http://jquery.redllama.net/jwizard
 *
 * Author: Boofer T Justice
 * Based off: Cody Lindley's CSS Step Menu - http://codylindley.com/CSS/325/css-step-menu
 *       and: Anthony (LeBoeuf|Brown)'s Jquery Wizard Plugin - http://worcesterwideweb.com/2007/06/04/jquery-wizard-plugin/
 *       and: Jerod Santo's jQuery Wizard Redux - http://blog.jerodsanto.net/2008/08/jquery-wizard-redux/
 *
 * Date: 2009-08-14 14:10:16 -0500 (Fri, 14 Aug 2009)
 * Revision: ????
 */


$(document).ready(function(){
	// all content starts hidden
	$('.jwizard div').hide();
});

(function($){
	$.fn.jwizard = function(options) {
		var defaults = {
			selectedIndex: 0,
			titles: ["Step 1","Step 2","Step 3","Step 4"],
			descriptions: ["","","",""],
			width: 750,
			height: 300,
			backText: "Back",
			nextText: "Next",
			completedText: "Finish",
			imageDirectory: "/images/",
			liClasses: ["zero","one","two","three","four","five","six","seven"]

		};
		var options = $.extend(defaults, options);
		return this.each(function() {
			var wiz = $(this);
			var wiz_content = wiz.html();
			wiz.wrapInner("<div id=\"jwizard_content\"></div>");
			wiz.find("#jwizard_content").before("<h3></h3>");
			wiz.find("#jwizard_content").after("<div class=\"jwizard_buttons\"><button type=\"submit\" class=\"previous\"><img src=\"" + options.imageDirectory + "jwizard_arrow_left.png\" alt=\"\"/> " + options.backText + " </button><button type=\"submit\" class=\"next\"> " + options.nextText + " <img src=\"" + options.imageDirectory + "jwizard_arrow_right.png\" alt=\"\" /> </button></div><ul></ul><div style=\"clear:both\"></div>");
			wiz.find("h3").html(options.titles[options.selectedIndex]);
			wiz.find("#jwizard_content > div:eq(" + options.selectedIndex + ")").show();
			$(options.titles).each(function(index, title) {
				wiz.find("ul").addClass(options.liClasses[options.titles.length]).append("<li><a title=\"\"><em></em><span></span></a></li>");
				wiz.find("li:eq(" + index + ") > a > em").html(title);
				wiz.find("li:eq(" + index + ") > a > span").html(options.descriptions[index]);
				//if(index == options.selectedIndex) wiz.find("li:eq(" + index + ")").addClass("current");
				//if(index < options.selectedIndex != 0) wiz.find("li:eq(" + index + ")").addClass("done");
				//if(index == (this.length - 1)) wiz.find("li:eq(" + index + ")").addClass("last");
			});
			wiz.find("li:eq(" + (options.selectedIndex - 1) + ")").addClass("last");
			wiz.find("li:lt(" + options.selectedIndex + ")").addClass("completed");
			wiz.find("li:eq(" + options.selectedIndex + ")").addClass("current");
			wiz.find("li:last").addClass("last");
			$(".previous", wiz).click( function() {
				wiz.hide();
				wiz.html(wiz_content);
				new_options = { selectedIndex: (options.selectedIndex - 1) };
				new_options = $.extend(options, new_options);
				wiz.jwizard(new_options);
				//wiz.fadeIn("fast");
				//wiz.show();
				$('#wiz_'+(options.selectedIndex-1)).show();
			});
			$(".next", wiz).click( function() {
				wiz.hide();
				wiz.html(wiz_content);
				new_options = { selectedIndex: (options.selectedIndex + 1) };
				new_options = $.extend(options, new_options);
				wiz.jwizard(new_options);
				//wiz.fadeIn("fast");
				//wiz.show();
				$('#wiz_'+(options.selectedIndex+1)).show();
			});
			if(options.selectedIndex == 0) $(".previous", wiz).attr("disabled","diabled").find("img").attr("src", options.imageDirectory + "jwizard_arrow_left_disabled.png");
			if(options.selectedIndex >= options.titles.length - 1) $(".next", wiz).attr("disabled","diabled").find("img").attr("src", options.imageDirectory + "jwizard_arrow_right_disabled.png");
		});
	};
})(jQuery);