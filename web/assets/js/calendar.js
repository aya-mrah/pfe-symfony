
// afficher les calendriers

$(document).ready(function(){
    $(".calendar_button").click(function(){
        $(".calendar").toggle();
    });
$(".calendar_button_1").click(function(){
        $(".calendar_1").toggle();
    });
});

// modifier les dates

function myFunction(date_calendar,date_input,calendar) {
        var x = document.getElementById(date_calendar).value;
        y = x.replace("-", "/");
        z = y.replace("-", "/");
        document.getElementById(date_input).value = z;
        $(calendar).hide();
}