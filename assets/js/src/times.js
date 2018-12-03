$(()=>{

    const AddTime = ( type, from, to)=>{
        let Kids='',Adults='';
        console.log(type);
        if(type == 'Kids')
        {
            Kids = 'selected'
        }
        if(type == 'Adults')
        {
            Adults = 'selected'
        }
        const formTime = '<form class="formTime mb-4">\n' +'<div class="closeButton"><i class="fas fa-times"></i></div>'+
            '                    <div class="form-group col-md-12">\n' +
            '                        <label for="days">Type</label>\n' +
            '                        <select class="form-control Type">\n' +
            '                            <option ' + Kids + '>Kids</option>\n' +
            '                            <option ' + Adults + '>Adults</option>\n' +
            '                        </select>\n' +
            '                    </div>\n' +
            '                    <div class="form-group col-md-12">\n' +
            '                        <label for="timepicker">From</label>\n' +
            '                        <input type="text" name="timepicker" value="' + from + '" placeholder="12:00" class="form-control From" data-timepicker="" autocomplete="off">\n' +
            '                    </div>\n' +
            '                    <div class="form-group col-md-12">\n' +
            '                        <label for="timepicker">To</label>\n' +
            '                        <input type="text" name="timepicker" value="' + to + '" placeholder="12:00" class="form-control To" data-timepicker="" autocomplete="off">\n' +
            '                    </div>\n' +
            '                    <div class="form-group col-md-12">\n' +
            '                    <div class="input-group mb-3">\n' +
            '                        <div class="input-group-prepend">\n' +
            '                            <div class="input-group-text">\n' +
            '                                <input class="repeatEveryCheckbox" type="checkbox" aria-label="Checkbox for following text input">\n' +
            '                                <span class="" id="">&nbsp;&nbsp; repeat every </span>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                        <input type="number" class="repeatEveryInput form-control" aria-label="Text input with checkbox">\n' +
            '                    </div>\n' +
            '                    </div>\n' +
            '                </form>';
        $('.times').append(formTime);
        createTimePicker();

    };
    createTimePicker();
    $('#calendar').calendar({
        dataSource: dates
    });
    $('#calendar').clickDay(function(e){
        const clickedDate = e.date.getDay();
        //const isRegistered = ($(e.element).hasClass('adults') || $(e.element).hasClass('kids') || $(e.element).hasClass('mixed')) ;
        $('.formTime').remove();
        e.events.map((el)=>{
            console.log(el);
            AddTime(el.type,el.from,el.to);
        });
        $('#modalNew').modal('show');
    });

    $('.addButton').click(()=>{
        AddTime( 'Kids','','');
    });
});