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
const loadSessions = (sessionData)=>{
    sessionData.map((session)=>{
        const date =session.date.split('-');
        sessions.push(new OldTime(session.type,session.from,session.to,session.id,new Date(date[0],parseInt(date[1])-1,date[2]),session.hash,false));
    });
};
const loadByYear = (year)=>{
    sessions = [];
    $.ajax({
        type: 'GETYEAR',
        url: `/sessions/${year}`,
        success:(dataSessions)=>{
            loadSessions(dataSessions.sessions);
        },
        async : false
    });
};
const updateCalendar = ()=>{
    loadByYear($("#calendar").data('calendar').getYear());
    $('#calendar').data('calendar').setDataSource(sessions);
};
$(()=>{
    loadSessions(data);
    $('#calendar')[0].addEventListener('onYearChange',()=>{
        updateCalendar();
    }, false);
    $('.year-title').click(function(e) {
        console.log(123);
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
        $(newTime.target).find('.repeatEveryInput').val($('.repeatEveryInputForAll').val());
        newTime.UpdateTheValues();
    });

    $('.Save').click(()=>{
        $('.Errors').html('');
        let error = false;
        const editedNewSessions = currentTimes.filter(session => session instanceof NewTime);
        const readyForSubmitNewSessions ={items: editedNewSessions.map(session => session.getSaveObj())};
        const jsonNewSessions = JSON.stringify(readyForSubmitNewSessions);
        const validationError = ( errors, timesArray )=>{
            if(errors.length > 0 && errors!=="Sekmingai")
            {
                error = true;
                errors.map(( errorData )=>{
                    timesArray[errorData.timeIndex].target
                        .find('.'+errorData.errorElement)
                        .parents('.form-group')
                        .find('.Errors').append('• '+errorData.errorText+'<br>');
                });
            }
        };
        if(editedNewSessions.length > 0) {
            $.ajax({
                type: 'POST',
                url: "/sessions",
                data: jsonNewSessions,
                dataType: "json",
                async: false,
                success: (data)=>{
                    validationError(data,editedNewSessions);
                }
            });
        }

        const editedOldSessions = currentTimes.filter(session => session.enabled);
        const oldSessionsByHash = editedOldSessions.filter(session => session.applyForAll);
        const oldSessionsById = editedOldSessions.filter(session => !session.applyForAll);

        const readyForSubmitOldSessionsByHash =oldSessionsByHash.map(session => session.getSaveObj());
        const readyForSubmitOldSessionsById =oldSessionsById.map(session => session.getSaveObj());

        const jsonSessionsByHash = JSON.stringify(readyForSubmitOldSessionsByHash);
        const jsonSessionsById = JSON.stringify(readyForSubmitOldSessionsById);
        if(oldSessionsById.length > 0)
        {
            $.ajax({
                type: 'EDITID',
                url: "/sessions",
                data: jsonSessionsById,
                dataType: "json",
                async: false,
                success: (data)=>{
                    validationError(data,oldSessionsById);
                }
            });
        }

        if(oldSessionsByHash.length > 0)
        {
            $.ajax({
                type: 'EDITHASH',
                url: "/sessions",
                data: jsonSessionsByHash,
                dataType: "json",
                async: false,
                success: (data)=>{
                    validationError(data,oldSessionsByHash);
                }
            });
        }
        // if(!error)
        // location.reload();

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

export {getSessions,setSessions,updateCalendar};