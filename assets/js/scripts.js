/* Show/hide main category (top menu) */
$(".cat-heading").click(function() {
  if($(".main-category").hasClass("dsp-n")) {
			$(".main-category").removeClass("dsp-n");
	} else {
			$(".main-category").addClass("dsp-n");		
	}
});