$(()=>{
    var random = function random() {
        return Math.round(Math.random() * 100);
    };

    var lineChart = new Chart($('.RegistrationChart'), {
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
    $('.CancelButton').click(()=>{
        alert("are you sure?");
        //TODO : https://craftpip.github.io/jquery-confirm/
    });
});
