import {Time} from "./classes/Time";
import {OldTime} from "./classes/OldTime";
import {NewTime} from "./classes/NewTime";

$(()=>{
    const months    = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    const sessions = [];
    let currentDate = null;
    let currentTimes = [];
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
    });
    $('.addButton').click(()=>{
        const newTime = new NewTime(currentDate);
        currentTimes.push(newTime);
        newTime.addTime();
    });

    $('.Save').click(()=>{
        const editedSessions = currentTimes.filter(session=> session instanceof NewTime || session.enabled);
        console.log(editedSessions);
    });
    $('#modalNew').on('hidden.bs.modal',(e) => {
        currentTimes = [];
        $('.times').html('');
    });
});