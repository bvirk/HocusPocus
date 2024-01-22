/**
 * change property background-image of selector imageSelector to imageUrlFunc 
 * on hover on hoverSelector and back to the original value of property
 * on that hover's ending.
**/
var backgroundImageHoverOn = function(hoverSelector, imageSelector, imageUrlFunc) {
	let origImage= $(imageSelector).css('backgroundImage');
	$(hoverSelector).hover(
		 function (){ 
		 	 $(imageSelector).css("backgroundImage", imageUrlFunc);
		 }
		,function (){
			$(imageSelector).css("backgroundImage", origImage);
		}
	);
};
