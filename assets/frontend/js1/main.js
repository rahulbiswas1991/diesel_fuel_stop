function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".more-less")
        .toggleClass('glyphicon-plus glyphicon-minus');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);

$(document).ready(function(){
$('.panel-heading').on('click', function(){
$(".panel-heading").removeClass('Current');
$(this).addClass('Current');    
});  
});

$(document).ready(function(){
$('.filter-button').on('click', function(){
$(".filter-button").removeClass('g_img');
$(this).addClass('g_img');    
});  
});
    
$(document).ready(function(){

    $(".filter-button").click(function(){
        var value = $(this).attr('data-filter');
        
        if(value == "all")
        {
            //$('.filter').removeClass('hidden');
            $('.filter').show('1000');
        }
        else
        {
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
            $(".filter").not('.'+value).hide('3000');
            $('.filter').filter('.'+value).show('3000');
            
        }
    });
    
    if ($(".filter-button").removeClass("active")) {
$(this).removeClass("active");
}
$(this).addClass("active");

});

$(document).ready(function(){
    $(window).scroll(function(){
            var pos= $(this).scrollTop();
            $(".sknvacustom").removeClass("scroll-nav");
            if(pos>=800){
                $(".sknvacustom").addClass("scroll-nav");
            }
    });

    $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
    
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
        $('#back-to-top').tooltip('show');

    $("#showcontactbox").click(function(){
        $("#contactboxdata").toggleClass("box-status");
        
    });
 $("#contact_boxclose").click(function(){
        $("#contactboxdata").toggleClass("box-status");
    });    
});
    
            $(".back").click(function (){
                $('html, body').animate({
                    scrollTop: $(".downbox").offset().top
                }, 2000);
            });

     $(".back2").click(function (){
                $('html, body').animate({
                    scrollTop: $(".downbox2").offset().top
                }, 2000);
            });
 $(".back3").click(function (){
                $('html, body').animate({
                    scrollTop: $(".downbox3").offset().top
                }, 2000);
            });
     
 $(".back4").click(function (){
                $('html, body').animate({
                    scrollTop: $(".downbox4").offset().top
                }, 2000);
            });
 $(".back5").click(function (){
                $('html, body').animate({
                    scrollTop: $(".downbox5").offset().top
                }, 2000);
            });
 $(".back6").click(function (){
                $('html, body').animate({
                    scrollTop: $(".downbox6").offset().top
                }, 2000);
            });

