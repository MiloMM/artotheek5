$(window).scroll(function(){
  var sticky = $('#headerLogo'),
      scroll = $(window).scrollTop();

  if (scroll >= 35) sticky.addClass('changeOnScroll');
  else sticky.removeClass('changeOnScroll');
});