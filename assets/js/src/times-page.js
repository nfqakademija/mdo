import {Time} from "./classes/Time";
import {OldTime} from "./classes/OldTime";
import {NewTime} from "./classes/NewTime";

let sessions = [];
const months    = ['January','February','March','April','May','June','July','August','September','October','November','December'];
let currentDate = null;
let currentTimes = [];
const getSessions = ()=>{
    return [...sessions];
};
const setSessions = (newsessions)=>{
    sessions = [...newsessions];
};
$(()=>{
    data.map((session)=>{
        const date =session.reservedAt.split('-');
        sessions.push(new OldTime(session.type,session.startAt,session.endsAt,session.id,new Date(date[0],parseInt(date[1])-1,date[2]),session.hash,false));
    });

    $('#calendar').calendar({
         dataSource: sessions,
    });

    createTimePicker();

    $('#calendar').clickDay((e)=>{
        currentTimes = Time.findTime(sessions,e.date);
        currentTimes.map((time)=>{
            console.log(time);
            time.addTime();
        });
        currentDate = e.date;
        $('#modalNew').modal('show');
        $('.modalNew__title').html(months[e.date.getMonth()] + " " + e.date.getDate() + " times. ");
    });
    $('.addButton').click(()=>{
        const newTime = new NewTime(currentDate);
        currentTimes.push(newTime);
        newTime.addTime();
        $(newTime.target).find('.repeatEveryInput').val($('.repeatEveryInputForAll').val());
        newTime.UpdateTheValues();
    });

    $('.Save').click(()=>{
        const editedSessions = currentTimes.filter(session=> session instanceof NewTime || session.enabled);
        const readyForSubmitSessions ={items: editedSessions.map(session => session.getSaveObj())};
        const jsonSessions = JSON.stringify(readyForSubmitSessions);
        $.ajax({
            type: 'POST',
            url: "/sessions",
            data: jsonSessions,
            success:()=>{
                location.reload();
            },
            dataType: "json",
            async: false
        });
    });
    $('#modalNew').on('hidden.bs.modal',(e) => {
        currentTimes = [];
        $('.times').html('');
    });
    $('.repeatEveryInputForAll').change(()=>{
        $('.repeatEveryInput').val($('.repeatEveryInputForAll').val());
        currentTimes.map(time=>time.UpdateTheValues());
    });
});

export {getSessions,setSessions};