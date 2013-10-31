$(document).ready(function() {
    $('.flexslider').flexslider({
        animation: "slide"
    });
  
    $('img')
    .wrap('<span style="display:inline-block"></span>')
    .css('display', 'block')
    .parent()
    .zoom();
    
    $(".date").mask("99/99/9999");
    $(".phone").mask("(999) 999-9999");
    $(".tin").mask("99-9999999");
    $(".ssn").mask("999-99-9999");
    $(".zip").mask("99999-9999");
    $( ".accordion" ).accordion();
});