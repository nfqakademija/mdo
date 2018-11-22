$('.timepicker').wickedpicker({twentyFour: true});
const TheFirstSession = $($( ".Session" )[0]);
$('.AddButton').click(()=>{
    const TheLastSession = $(".Session")[$(".Session").length-1];
    TheFirstSession.clone().insertAfter( TheLastSession );
});