$('li.removable').on('mouseenter', function(event){
    $('.navigator').show();
    var element = $(event.target).parent();
    var position = $(element).position();
    var elemnt = {
        height: $(element).height() - 5 ,
        width: $(element).width() 
    };
    $('.navigator').css({'top': (position.top + elemnt.height), 'left': position.left, 'width' : elemnt.width});
});

$('li.removable').on('mouseleave', function(event){
    $('.navigator').hide();
});

$(document).ready(function(){
    var pathname = window.location.pathname;
    var element = $('li.removable a[href="'+pathname+'"]');
    var listItem = $(element).parent();
    $(listItem).addClass('active');
    var position = $(listItem).position();
    var elemnt = {
        height: $(listItem).height() - 5 ,
        width: $(listItem).width() 
    };
    $('.notMoving').css({'top': (position.top + elemnt.height), 'left': position.left, 'width' : elemnt.width});

    $(window).resize(function () {
        var el =  $("nav li.active");
        var staticNav = $(".notMoving");
        var objEl = $(el).position();
        var top = objEl.top + $(el).innerHeight() -5
        $(staticNav).css({"width":$(el).innerWidth(),"left": objEl.left, "top":top});
    });
    $(window).trigger('resize');
});

