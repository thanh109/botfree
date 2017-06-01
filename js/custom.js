
/* Configs */
var sliderSpeed = 4000;
var endDate = "january 01, 2016 01:00:00";

/* Main code - DO NOT EDIT */
$(document).ready(function(){
    
    $("#countdown").countdown({
        htmlTemplate: '<div id="countdown_day" class="countdown c4eq"><div><span>%d</span>Ngày</div></div><div id="coundown_hour" class="countdown c4eq"><div><span>%h</span>Giờ</div></div><div id="coundown_min" class="countdown c4eq"><div><span>%i</span>Phút</div></div><div id="coundown_sec" class="countdown c4eq c_last"><div><span>%s</span>Giây</div></div>',
        date: endDate,
        hoursOnly: false,
        leadingZero: true
    });
    
    setInterval(function(){
        
        var next;
        var act = $('.bg.active');
    
        if(act.next('.bg').length > 0){
            next = act.next('.bg');
        }
        else{
            next = $('.bg').first();
        }
    
        act.removeClass('active');
        next.addClass('active');
    
    },sliderSpeed);

});