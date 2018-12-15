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
        let alldone = 0;
        const editedNewSessions = currentTimes.filter(session => session instanceof NewTime);
        const readyForSubmitNewSessions ={items: editedNewSessions.map(session => session.getSaveObj())};
        const jsonNewSessions = JSON.stringify(readyForSubmitNewSessions);
        $.ajax({
            type: 'POST',
            url: "/sessions",
            data: jsonNewSessions,
            success:()=>{
                if(alldone >= 3)
                    location.reload();
                alldone++;
            },
            dataType: "json",
            async: false
        });

        const editedOldSessions = currentTimes.filter(session => session.enabled);
        const oldSessionsByHash = editedOldSessions.filter(session => session.applyForAll);
        const oldSessionsById = editedOldSessions.filter(session => !session.applyForAll);

        const readyForSubmitOldSessionsByHash ={items: oldSessionsByHash.map(session => session.getSaveObj())};
        const readyForSubmitOldSessionsById ={items: oldSessionsById.map(session => session.getSaveObj())};

        const jsonSessionsByHash = JSON.stringify(readyForSubmitOldSessionsByHash);
        const jsonSessionsById = JSON.stringify(readyForSubmitOldSessionsById);

        $.ajax({
            type: 'EDITID',
            url: "/sessions",
            data: jsonSessionsByHash,
            success:()=>{
                if(alldone >= 3)
                    location.reload();
                alldone++;
            },
            dataType: "json",
            async: false
        });

        $.ajax({
            type: 'EDITHASH',
            url: "/sessions",
            data: jsonSessionsById,
            success:()=>{
                if(alldone >= 3)
                    location.reload();
                alldone++;
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