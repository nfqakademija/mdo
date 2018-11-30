$(()=>{
    let SelectedForDeletion = null;
    console.log(SelectedForDeletion);
    createTimePicker();
    $('.AddButton').click((e)=>{
        const target = $(e.target);
        const index = target.parent().index();
        const table = target.closest('table');
        const DayOfTheWeek = table.find('.header th').eq(index).html();
        $('.modal-body form')[0].reset();
        $('.modal').attr('data-day',DayOfTheWeek);
        $('.modal-title').html("Add time to " + DayOfTheWeek);
    });
    $('.Save').click(()=>{
        $.post( "/time-slot-submit", { Type : $('.Type').val(), Time : $('.Time').val(),Price : $('.Price').val(), From : $('.From').val(),To : $('.To').val(),Day : $('.modal').attr('data-day')} )
            .done(()=>{
                //location.reload();
                console.log('gerai');
            });

    });
    $('.DeleteButtonConfirmation').click(()=>{
        $.post( "/time-slot-delete", { id :  SelectedForDeletion} )
            .done(()=>{
                //location.reload();
                console.log('gerai');
            });

    });
    $('#warningDelete').on('hide.bs.modal', function (e) {
        SelectedForDeletion = null;
        console.log(SelectedForDeletion);
    });
    $('.DeleteTheTime').click((e)=>{
        const target = $(e.target);
        const TimeButton = target.parents('.TimeButton');
        SelectedForDeletion = TimeButton.attr("data-id");
        console.log(SelectedForDeletion);
    });
});
