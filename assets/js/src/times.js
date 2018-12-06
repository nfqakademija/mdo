import {getOldForm,getNewForm} from './timeForms.js';
$(()=>{

    const months    = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    let currentDate = [];

    const UpdateEvents = (target) => {
        const id = $( ".formTime" ).index( $(target) );
        console.log('id - ' + id);
        const type = $(target).find('.Type').val();
        const from = $(target).find('.From').val();
        const to = $(target).find('.To').val();
        const ticked = $(target).find('.repeatEveryCheckbox').prop( "checked" );
        const repeatFor = (ticked) ? $(target).find('.repeatEveryInput').val() : 1;
        (type === 'Kids') ?$(target).removeClass('timeAdults').addClass('timeKids') :$(target).removeClass('timeKids').addClass('timeAdults');
        const timeObj = {
            color: "#F5BB00",
            date: currentDate,
            from: from,
            repeatFor: repeatFor,
            to: to,
            type: type,
            old: false
        };
        $('#calendar').data('calendar').updateEvents(currentDate,timeObj,id);
    };
    const AddEvent = (target) => {
        const id = $( ".formTime" ).index( $(target) );
        console.log('id - ' + id);
        const type = $(target).find('.Type').val();
        const from = $(target).find('.From').val();
        const to = $(target).find('.To').val();
        const ticked = $(target).find('.repeatEveryCheckbox').prop( "checked" );
        const repeatFor = (ticked) ? $(target).find('.repeatEveryInput').val() : 1;
        (type === 'Kids') ?$(target).removeClass('timeAdults').addClass('timeKids') :$(target).removeClass('timeKids').addClass('timeAdults');
        const timeObj = {
            color: "#F5BB00",
            date: currentDate,
            from: from,
            repeatFor: repeatFor,
            to: to,
            type: type
        };
        $('#calendar').data('calendar').addEvents(timeObj);
    };
    const AddNewTime = ()=>{
        let form = $(getNewForm());
        $('.times').append(form)
        console.log(form);
        createTimePicker();
        AddEvent(form);

        $('.closeButton').click((e)=>{
            console.log( $(e.target));
            $(e.target).parents('.formTime').remove();
        });

        $('.formTime').change((e)=>{
            const target = e.currentTarget;
            UpdateEvents(target);
        });
    };
    const AddOldTime = (type,from,to)=>{

        $('.times').append(getOldForm(type,from,to));

        createTimePicker();

        $('.closeButton').click((e)=>{
            $(e.target).parents('.formTime').remove(); //TODO: Add warning message
        });

        $('.formTime').change((e)=>{
            const target = e.currentTarget;
            UpdateEvents(target);
        });
    };

    $('#calendar').calendar({
        dataSource: dates,
    });

    $('#calendar').clickDay((e)=>{
        let clickedDay = months[e.date.getMonth() ]+ " " + e.date.getDate();
        $('.modal-title').html('Add time to ' + clickedDay);
        $('.formTime').remove();
        currentDate = e.date;

        e.events.map((el,index)=>{
            console.log(el);
           AddOldTime(el.type,el.from,el.to);
        });
        $('#modalNew').modal('show');
    });

    $('.addButton').click(()=>{
        AddNewTime();
    });

    $('.Save').click(()=>{
        let newTimesArray = [];
        $('#calendar').data('calendar').getEvents(currentDate).map((el)=>{
            if(!el.old)newTimesArray.push(el);
        });
        newTimesArray = newTimesArray.map((el)=>{
            el.date = el.date.getFullYear()+"-"+ (el.date.getMonth())+"-"+el.date.getDate();
            return el;
        });
        $.post( "/time-slot-submit", newTimesArray[0] );
        console.log(newTimesArray);
    });
});