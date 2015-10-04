// JavaScript Document
var isBoxPopup = [];
var beforeBoxPopup = null;
jQuery.fn.popupBox = function(width, height){ 
	isBoxPopup[isBoxPopup.length] = this;
	$(this).hide();
	var posLeft = parseInt(($(window).width()/2)-(width/2));
	var posTop = parseInt(($(window).height()/2)-(height/2))-50;
	$(this).css({ "width": width, "height": height, position: "fixed", top: posTop, left: posLeft, "z-index": 100 });
	$(this).css({ "-webkit-border-radius": 10, "-moz-border-radius": 10, "border-radius": 10 });
	$(this).html('<span id="box-close" onClick="$(this).popupClose()"></span>' + $(this).html());

}
jQuery.fn.popupClose = function(){
	for(var bloop=0;bloop<isBoxPopup.length;bloop++) $(isBoxPopup[bloop]).fadeOut('fast');	
	beforeBoxPopup = null;
}
jQuery.fn.popupOpen = function(){
	if(beforeBoxPopup!=$(this).attr('id')) {
		$(this).popupClose();
		$(this).fadeIn('fast');
		beforeBoxPopup = $(this).attr('id');
	}
}