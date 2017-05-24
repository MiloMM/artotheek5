var toggle_state = false;               // de staat van het navigatie menu (uitgeklapt of niet)
var search_toggle_state = false;        // de staat van de zoekbalk (uitgeklapt of niet)
var filter_state = false;               // de staat van van de filters (uitgeklapt of niet)
var busy_animating_menu = false;        // of het navigatiemenu wordt geanimeerd
var busy_animating_searchmenu = false;  // of het zoekmenu wordt geanimeerd
var busy_animating_filters = false;     // of de filters worden geanimeerd

function button_slide() // Zorgt dat de menuknoppen naar links en rechts schuiven
{
    if (toggle_state && !search_toggle_state || !toggle_state && search_toggle_state) // Javascript XOR
    {
        $('.custom-navbar-right').animate({marginRight:'0px'}, 300);
    }
}

function menu_toggle_function() // Zorgt voor het openen van het navigatie menu
{
    if (!busy_animating_menu)
    {
        busy_animating_menu = true;
        if (!toggle_state)
        {
            $('#custom_navmenu').animate({right:'0px'}, 300, function(){busy_animating_menu = false;}); //opent het menu
            $('.custom-navbar-right').animate({marginRight:'380px'}, 300); //beweegt de knoppen
            toggle_state = true;
            if (search_toggle_state) //als het zoekmenu open is wordt het gesloten
            {
                search_toggle_function();
            }
			setTimeout(function(){
				$("#searchtoggle").addClass("menuButtonsHidden");
				$("#custom_navbar_toggle").addClass("menuButtonsHidden");
			}, 100);
        }
        else
        {
            $('#custom_navmenu').animate({right:'-800px'}, 300, function(){busy_animating_menu = false;}); // sluit het menu
            button_slide();
            toggle_state = false;
			setTimeout(function(){
				$("#searchtoggle").removeClass("menuButtonsHidden");
				$("#custom_navbar_toggle").removeClass("menuButtonsHidden");
			}, 100);
        }
    }
}

function search_toggle_function() // Zorgt voor het openen van het zoekbalk menu
{
    if (!busy_animating_searchmenu)
    {
        busy_animating_searchmenu = true;
        if (!search_toggle_state) 
        {
            $('#custom_searchmenu').animate({right:'0px'}, 300, function(){busy_animating_searchmenu = false;});
            $('.custom-navbar-right').animate({marginRight:'380px'}, 300);
            search_toggle_state = true;
            if (toggle_state) //als het navigatiemenu open is wordt het gesloten
            {
                menu_toggle_function();
            }
            if (!filter_state)
            {
                filter_toggle_function();
            }
			setTimeout(function(){
				$("#searchtoggle").addClass("menuButtonsHidden");
				$("#custom_navbar_toggle").addClass("menuButtonsHidden");
			}, 100);
        }
        else
        {
            $('#custom_searchmenu').animate({right:'-800px'}, 300, function(){busy_animating_searchmenu = false;}); // sluit de zoekbalk
            button_slide();
            search_toggle_state = false;
            if (filter_state)
            {
                filter_toggle_function();
            }
			setTimeout(function(){
				$("#searchtoggle").removeClass("menuButtonsHidden");
				$("#custom_navbar_toggle").removeClass("menuButtonsHidden");
			}, 100);
        }
    }
}

function filter_toggle_function() // Zorgt dat de filters uitklappen in het zoekbalk menu
{
    if (!busy_animating_filters)
    {
        busy_animating_filters = true;
        if (!filter_state)
        {
            $('#filterbox').slideDown(400, function(){busy_animating_filters = false;});
            $('#expandtext').html("Filters (optioneel)");
            filter_state = true;
        }
        else
        {
            //$('#filterbox').slideUp(400, function(){busy_animating_filters = false;});
            $('#expandtext').html("Filters (optioneel)");
            filter_state = false;
        }
    }
}

$("#expandtext").on('click',function(){filter_toggle_function()});
$("#searchtoggle").on('click',function(){search_toggle_function()});
$("#searchtoggle_two").on('click',function(){search_toggle_function()});
$("#searchbutton_menu").on('click',function(){search_toggle_function()});
$("#custom_navbar_toggle").on('click',function(){menu_toggle_function()});
$("#custom_navbar_toggle_two").on('click',function(){menu_toggle_function()});