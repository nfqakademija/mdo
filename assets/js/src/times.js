const Session = '<div class="Session col-lg-6 p-3">\n' +
    '            <div class="inside card-body">\n' +
    '                <div class="row">\n' +
    '                    <div class="form-group col-md-6">\n' +
    '                        <label for="days">Day of the week</label>\n' +
    '                        <select class="form-control" id="days">\n' +
    '                            <option>Monday</option>\n' +
    '                            <option>Tuesday</option>\n' +
    '                            <option>Wednesday</option>\n' +
    '                            <option>Thursday</option>\n' +
    '                            <option>Friday</option>\n' +
    '                            <option>Saturday</option>\n' +
    '                            <option>Sunday</option>\n' +
    '                        </select>\n' +
    '                    </div>\n' +
    '                    <div class="form-group col-md-6">\n' +
    '                        <label for="days">Type</label>\n' +
    '                        <select class="form-control" id="days">\n' +
    '                            <option>Kids</option>\n' +
    '                            <option>Adults</option>\n' +
    '                        </select>\n' +
    '                    </div>\n' +
    '                </div>\n' +
    '                <div class="row">\n' +
    '                    <div class="form-group col-md-6">\n' +
    '                        <label for="timepicker">From</label>\n' +
    '                        <input type="text" name="timepicker" value="" placeholder="12:00" class="form-control" data-timepicker="" autocomplete="off">\n' +
    '                    </div>\n' +
    '                    <div class="form-group col-md-6">\n' +
    '                        <label for="timepicker">To</label>\n' +
    '                        <input type="text" name="timepicker" value="" placeholder="12:00" class="form-control" data-timepicker="" autocomplete="off">\n' +
    '                    </div>\n' +
    '                </div>\n' +
    '                <div class="row">\n' +
    '                    <div class="form-group col-md-6">\n' +
    '                        <label for="price">Price</label>\n' +
    '                        <div class="input-group">\n' +
    '                            <input type="number" class="form-control">\n' +
    '                            <div class="input-group-append">\n' +
    '                                <span class="input-group-text">€</span>\n' +
    '                            </div>\n' +
    '                        </div>\n' +
    '                    </div>\n' +
    '                    <div class="form-group col-md-4">\n' +
    '                        <label for="timepicker"> ​</label>\n' +
    '                        <input type="button" value="Remove" class="RemoveButton btn--gray form-control">\n' +
    '                    </div>\n' +
    '                </div>\n' +
    '            </div>\n' +
    '        </div>';
createTimePicker();
$('.AddButton').click(()=>{
    $('.Sessions').append(Session);
    createTimePicker();
});
$(document).on( "click", '.RemoveButton', (e)=>{
    $(e.target).parents('.Session').remove();
});
