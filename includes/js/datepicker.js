$(function() {
    $( "#datepicker1" ).datepicker({
        yearRange: "1900:y",
        changeMonth: true,
        changeYear: true,
        showAnim: "clip" 
    });

    $( "#datepicker1b" ).datepicker({
        yearRange: "1900:y",
        changeMonth: true,
        changeYear: true,
        showAnim: "clip" 
    });

    $( "#datepicker2" ).datepicker({
        yearRange: "-10y:+10y",
        changeMonth: true,
        changeYear: true,
        showAnim: "clip" 
    });

    $( "#bdate" ).datepicker({
        yearRange: "-80y:-15y",
        changeMonth: true,
        changeYear: true,
        showAnim: "clip"  
    });

    $( "#from" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function( selectedDate ) {
            $( "#to" ).datepicker( "option", "minDate", selectedDate );
        }
    });

    $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        onClose: function( selectedDate ) {
            $( "#from" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
});
