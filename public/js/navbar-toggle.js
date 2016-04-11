var sidebar_nav = document.getElementById("custom_navmenu");
var searchbar_nav = document.getElementById("customSearchControlDiv");
var toggleState = 0;
var sBarToggleState = 0;
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
function searchbarToggleFunction() {
    if (sBarToggleState == 0) {
        searchbar_nav.style.transition = "top 0.3s ease-out 0s";
        searchbar_nav.style.top = '51px';
        sBarToggleState = 1;
    }
    else {
        searchbar_nav.style.transition = "top 0.3s ease-out 0s";
        searchbar_nav.style.top = '-200px';
        sBarToggleState = 0;
    }
}
$("#custom_navbar_toggle").click(function() {menuToggleFunction()});
$("#custom_navbar_toggle_two").click(function() {menuToggleFunction()});
$("#customSearchControlBtn").click(function() {searchbarToggleFunction()});