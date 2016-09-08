var toggle_state = false;           // de staat van het navigatie menu (uitgeklapt of niet)
var search_toggle_state = false;    // de staat van de zoekbalk (uitgeklapt of niet)
var filter_state = false;           // de staat van van de filters (uitgeklapt of niet)
var busy_animating_menu = false;    // of er op het moment een animatie afspeelt

function button_slide() // Zorgt dat de menuknoppen naar links en rechts schuiven
{
    if (toggle_state && !search_toggle_state || !toggle_state && search_toggle_state) // Javascript XOR
    {
        $('.custom-navbar-right').animate({marginRight:'0px'}, 300);
    }
}

function define_z_index() //Bepaalt de z-index van het menu dat word geopend
{
    if (toggle_state)
    {
        $('#custom_navmenu').css('z-index', 4);
        $('#custom_searchmenu').css('z-index', 5);
    }
    else if (search_toggle_state)
    {
        $('#custom_navmenu').css('z-index', 5);
        $('#custom_searchmenu').css('z-index', 4);
    }
}

function menu_toggle_function() // Zorgt voor het openen van het navigatie menu
{
    if (!busy_animating_menu)
    {
        busy_animating_menu = true;
        if (!toggle_state)
        {
            define_z_index();
            $('#custom_navmenu').animate({right:'0px'}, 300, function(){busy_animating_menu = false;}); //opent het menu
            $('.custom-navbar-right').animate({marginRight:'380px'}, 300); //beweegt de knoppen
            toggle_state = true;
        }
        else if (toggle_state && search_toggle_state && $('#custom_navmenu').css('z-index') == 4) // Kijkt of bijde menu's open zijn en of het menu achter de andere staat
        {
            $('#custom_navmenu').css('z-index', 5);
            $('#custom_searchmenu').css('z-index', 4);
            busy_animating_menu = false;
        }
        else
        {
            $('#custom_navmenu').animate({right:'-380px'}, 300, function(){busy_animating_menu = false;}); // sluit het menu
            button_slide();
            toggle_state = false;
        }
    }
}

function search_toggle_function() // Zorgt voor het openen van het zoekbalk menu
{
    if (!busy_animating_menu)
    {
        busy_animating_menu = true;
        if (!search_toggle_state) 
        {
            define_z_index();
            $('#custom_searchmenu').animate({right:'0px'}, 300, function(){busy_animating_menu = false;});
            $('.custom-navbar-right').animate({marginRight:'380px'}, 300);
            search_toggle_state = true;
        }
        else if (toggle_state && search_toggle_state && $('#custom_searchmenu').css('z-index') == 4) // Kijkt of bijde menu's open zijn en of het menu achter de andere staat
        {
            $('#custom_navmenu').css('z-index', 4);
            $('#custom_searchmenu').css('z-index', 5);
            busy_animating_menu = false;
        }
        else
        {
            $('#custom_searchmenu').animate({right:'-380px'}, 300, function(){busy_animating_menu = false;}); // sluit de zoekbalk
            button_slide();
            search_toggle_state = false;
        }
    }
}

function filter_toggle_function() // Zorgt dat de filters uitklappen in het zoekbalk menu
{
    if (!busy_animating_menu)
    {
        busy_animating_menu = true;
        if (!filter_state)
        {
            $('#filterbox').slideDown(400, function(){busy_animating_menu = false;});
            $('#expandtext').html("Filters Verbergen");
            filter_state = true;
        }
        else
        {
            $('#filterbox').slideUp(400, function(){busy_animating_menu = false;});
            $('#expandtext').html("Filters Weergeven");
            filter_state = false;
        }
    }
}

$("#expandtext").on('click',function(){filter_toggle_function()});
$("#searchtoggle").on('click',function(){search_toggle_function()});
$("#custom_navbar_toggle").on('click',function(){menu_toggle_function()});
$("#custom_navbar_toggle_two").on('click',function(){menu_toggle_function()});