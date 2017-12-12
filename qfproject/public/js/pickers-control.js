$(function ()
{            
    //Date picker
    $('#datepicker').datepicker({
        autoclose: true
    })

    //Timepicker
    $('.timepicker').timepicker({
        showInputs: false,
        minuteStep: 60,
        //showMeridian: false
    }).on('changeTime.timepicker',
    function(e)
    {
        //Limitando hora de 7:00 AM a 06:00 PM
        var h = e.time.hours;
        var mer = e.time.meridian;
        if (h != 12) {
            if (mer == 'AM' && h < 7 || mer == 'PM' && h > 6) $('.timepicker').timepicker('setTime', '07:00 AM');
        }
    });
})