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
        const date =session.date.split('-');
        sessions.push(new OldTime(session.type,session.from,session.to,session.id,new Date(date[0],parseInt(date[1])-1,date[2]),session.hash,false));
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
        const editedNewSessions = currentTimes.filter(session => session instanceof NewTime);
        const readyForSubmitNewSessions ={items: editedNewSessions.map(session => session.getSaveObj())};
        const jsonNewSessions = JSON.stringify(readyForSubmitNewSessions);
        if(editedNewSessions.length > 0) {
            $.ajax({
                type: 'POST',
                url: "/sessions",
                data: jsonNewSessions,
                dataType: "json",
                async: false
            });
        }

        const editedOldSessions = currentTimes.filter(session => session.enabled);
        const oldSessionsByHash = editedOldSessions.filter(session => session.applyForAll);
        const oldSessionsById = editedOldSessions.filter(session => !session.applyForAll);

        const readyForSubmitOldSessionsByHash =oldSessionsByHash.map(session => session.getSaveObj());
        const readyForSubmitOldSessionsById =oldSessionsById.map(session => session.getSaveObj());

        const jsonSessionsByHash = JSON.stringify(readyForSubmitOldSessionsByHash);
        const jsonSessionsById = JSON.stringify(readyForSubmitOldSessionsById);
        console.log(jsonSessionsById);
        if(oldSessionsById.length > 0)
        {
            $.ajax({
                type: 'EDITID',
                url: "/sessions",
                data: jsonSessionsById,
                dataType: "json",
                async: false
            });
        }

        if(oldSessionsByHash.length > 0)
        {
            $.ajax({
                type: 'EDITHASH',
                url: "/sessions",
                data: jsonSessionsByHash,
                dataType: "json",
                async: false
            });
        }

        location.reload();

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