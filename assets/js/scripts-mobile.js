function switchMobNav() {
	if($("#m-menu-main-category").hasClass("on")) {
		closeMobMainCat();
	}	
	if(!$("#m-menu-main").hasClass("on")) {
			openMobNav();
	}	else {
			closeMobNav();
	}
}

function openMobNav() {
	$("#overlay-menu").css("display", "block");
	$("#m-menu-main").css("display", "block");
	if(!$("#m-menu-main").hasClass("on")) {
		$("#m-menu-main").addClass("on");
	}
}

function closeMobNav() {
	$("#overlay-menu").css("display", "none");
	$("#m-menu-main").css("display", "none");
	if($("#m-menu-main").hasClass("on")) {
		$("#m-menu-main").removeClass("on");
	}	
}

function openMobMainCat() {
	closeMobNav();
	$("#overlay-menu").css("display", "block");
	$("#m-menu-main-category").css("display", "block");
	if(!$("#m-menu-main-category").hasClass("on")) {
		$("#m-menu-main-category").addClass("on");
	}
}

function closeMobMainCat() {
	closeMobNav();
	$("#m-menu-main-category").css("display", "none");
	if($("#m-menu-main-category").hasClass("on")) {
		$("#m-menu-main-category").removeClass("on");
	}	
}

function switchTopCartItems() {
	if($(".shopping-top-items").hasClass("elm-invisible")) {
			$(".shopping-top-items").removeClass("elm-invisible");
	} else {
			$(".shopping-top-items").addClass("elm-invisible");		
	}
}

function switchTopSearchBar() {
	if($(".search-bar-top-a").hasClass("on")) {
			$(".topnav").css("height", "50px");
			$(".search-bar-top-a").removeClass("on");
	} else {
			$(".topnav").css("height", "auto");
			$(".search-bar-top-a").addClass("on");
	}
}

function openMobFilters() {
	$("#overlay-menu").css("display", "block");
	$("#m-filters").css("display", "block");
	if(!$("#m-filters").hasClass("on")) {
		$("#m-filters").addClass("on");
	}
}

function closeMobFilters() {
	$("#overlay-menu").css("display", "none");
	$("#m-filters").css("display", "none");
	if($("#m-filters").hasClass("on")) {
		$("#m-filters").removeClass("on");
	}	
}

$("#filters-m").click(function() {
  openMobFilters();
});

$("#filters-clear").click(function() {
  closeMobFilters();
});

$(".user-profile-menu-sw").click(function() {
	if($(".user-profile-menu-l").hasClass("dsp-n")) {
			$(".user-profile-menu-l").removeClass("dsp-n");
	} else {
			$(".user-profile-menu-l").addClass("dsp-n");
	}
});