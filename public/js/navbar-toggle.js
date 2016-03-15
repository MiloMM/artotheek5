var sidebar_nav = document.getElementById("custom_navmenu");
var toggleState = 0;
function menuToggleFunction() {
	if (toggleState == 0) {
        sidebar_nav.style.transition = "right 0.3s ease-out 0s";
        sidebar_nav.style.right = 0;
        toggleState = 1;
    }
    else {
    	sidebar_nav.style.transition = "right 0.3s ease-out 0s";
        sidebar_nav.style.right = '-300px';
        toggleState = 0;
    }
}
$("#custom_navbar_toggle").click(function() {menuToggleFunction()});
$("#custom_navbar_toggle_two").click(function() {menuToggleFunction()});