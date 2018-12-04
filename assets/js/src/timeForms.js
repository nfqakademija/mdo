const getNewForm = ( ) =>
{

    const formTime = '<form class="formTime mb-4 timeAdults">\n' +'<div class="closeButton"><i class="fas fa-times"></i></div>'+
        '                    <div class="form-group col-md-12">\n' +
        '                        <label for="days">Type</label>\n' +
        '                        <select class="form-control Type">\n' +
        '                            <option>Kids</option>\n' +
        '                            <option .disabledFormselected>Adults</option>\n' +
        '                        </select>\n' +
        '                    </div>\n' +
        '                    <div class="form-group col-md-12">\n' +
        '                        <label for="timepicker">From</label>\n' +
        '                        <input type="text" name="timepicker"  placeholder="12:00" class="form-control From" data-timepicker="" autocomplete="off">\n' +
        '                    </div>\n' +
        '                    <div class="form-group col-md-12">\n' +
        '                        <label for="timepicker">To</label>\n' +
        '                        <input type="text" name="timepicker"  placeholder="12:00" class="form-control To" data-timepicker="" autocomplete="off">\n' +
        '                    </div>\n' +
        '                    <div class="form-group col-md-12">\n' +
        '                    <div class="input-group mb-3">\n' +
        '                        <div class="input-group-prepend">\n' +
        '                            <div class="input-group-text">\n' +
        '                                <input class="repeatEveryCheckbox" type="checkbox" aria-label="Checkbox for following text input">\n' +
        '                                <span class="" id="">&nbsp;&nbsp; repeat for </span>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                        <input type="number" min="1" class="repeatEveryInput form-control" value="1" aria-label="Text input with checkbox">\n' +
        '                        <div class="input-group-append">\n' +
        '                            <div class="input-group-text">\n' +
        '                                <span class="" id=""> week(s) </span>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                    </div>\n' +
        '                </form>';
    return formTime;
};
const getOldForm = (type,from, to) =>
{
    let Kids='',Adults='',formType = '';
    if(type === 'Kids')
    {
        Kids = 'selected';
        formType = 'timeKids';
    }
    if(type === 'Adults')
    {
        Adults = 'selected';
        formType = 'timeAdults';
    }
    const formTime = '<form class="disabledForm formTime mb-4 ' + formType + '">\n' +'<div class="closeButton"><i class="fas fa-times"></i></div>'+
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
        '                </form>';
    return formTime;
};
export {getOldForm,getNewForm}