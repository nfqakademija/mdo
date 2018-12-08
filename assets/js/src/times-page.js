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
        sessions.push(new OldTime(session.type,session.from,session.to,session.id,new Date(session.reservedAt.Y,session.reservedAt.m,session.reservedAt.d),session.hash,false));
    });

    $('#calendar').calendar({
         dataSource: sessions,
    });

    createTimePicker();

    $('#calendar').clickDay((e)=>{
        currentTimes = Time.findTime(sessions,e.date);
        currentTimes.map((time)=>{
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
    });

    $('.Save').click(()=>{
        const editedSessions = currentTimes.filter(session=> session instanceof NewTime || session.enabled);
        const readyForSubmitSessions = editedSessions.map(session => session.getSaveObj());
        $.ajax({
            type: 'POST',
            url: "/time-slot-submit",
            data: {'Sessions[]' : readyForSubmitSessions},
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

});

export {getSessions,setSessions};