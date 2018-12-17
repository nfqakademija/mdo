$(()=>{
    var random = function random() {
        return Math.round(Math.random() * 100);
    };

    const lineChart = new Chart($('.RegistrationChart'), {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Succesfull',
                backgroundColor: 'rgba(75,181,67, 0.2)',
                borderColor: 'rgba(75,181,67, 1)',
                pointBackgroundColor: 'rgba(75,181,67, 1)',
                pointBorderColor: '#fff',
                data: [random(), random(), random(), random(), random(), random(), random()]
            }, {
                label: 'Cancelled',
                backgroundColor: 'rgba(166,50,50, 0.2)',
                borderColor: 'rgba(166,50,50, 1)',
                pointBackgroundColor: 'rgba(166,50,50, 1)',
                pointBorderColor: '#fff',
                data: [random(), random(), random(), random(), random(), random(), random()]
            }]
        },
        options: {
            responsive: true
        }
    });
    $('#table_id').DataTable();
    $('.CancelButton').click((e)=>{
        const id = parseInt(($(e.currentTarget).parents('tr').attr('id') + "").replace('registration-',''));
        $.confirm({
            title: '<i class="fas fa-exclamation-triangle" style="color: #e74d3d;"></i> WARNING!',
            content: 'Are you sure that you want to cancel this registration?',
            type: 'red',
            buttons: {
                confirm: {
                    btnClass: 'btn-red',
                    action : function(){
                        $.ajax({
                            type: 'POST',
                            url: "/cancel-reservation/"+id,
                            success:()=>{
                                location.reload();
                            },
                            async: false
                        });
                        return false;
                    }
                },
                cancel: {
                    action : ()=>{}
                },
            }
        });
    });
});
