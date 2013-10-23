$(document).ready(function() {
  $('.flexslider').flexslider({
    animation: "slide"
  });
  $('img')
    .wrap('<span style="display:inline-block"></span>')
    .css('display', 'block')
    .parent()
    .zoom();
});