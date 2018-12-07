const getNewForm = ( ) =>
{

    return `
    <form class="formTime mb-4 timeAdults">
         <div class="topButtons topButtons--old">
            <div class="closeButton"><i class="fas fa-times"></i></div>
        </div>
        <div class="form-group col-md-12">
            <label for="days">Type</label>
            <select class="form-control Type">
                <option>Kids</option>
                <option selected>Adults</option>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label for="timepicker">From</label>
            <input type="text" name="timepicker" placeholder="12:00" class="form-control From" data-timepicker=""
                   autocomplete="off">
        </div>
        <div class="form-group col-md-12">
            <label for="timepicker">To</label>
            <input type="text" name="timepicker" placeholder="12:00" class="form-control To" data-timepicker=""
                   autocomplete="off">
        </div>
        <div class="form-group col-md-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input class="repeatEveryCheckbox" type="checkbox" aria-label="Checkbox for following text input">
                        <span class="" id="">&nbsp;&nbsp; repeat for </span>
                    </div>
                </div>
                <input type="number" min="1" class="repeatEveryInput form-control" value="1"
                       aria-label="Text input with checkbox">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="" id=""> week(s) </span>
                    </div>
                </div>
            </div>
        </div>
    </form>
    `;

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
    return`
    <form class="formTime mb-4 ${formType}">
        <div class="topButtons topButtons--old">
            <div class="closeButton"><i class="fas fa-times"></i></div>
        </div>
        
        <div class="bottomButtons">
            <div class="form-group col-md-12">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                    <label class="custom-control-label" for="customCheck2">Edit</label>
                </div>
            </div>
        </div>
        
        <div class="form-group col-md-12">
            <label for="days">Type</label>
            <select class="form-control Type">
                <option ${Kids}>Kids</option>
                <option ${Adults}>Adults</option>
            </select>
        </div>
        
        <div class="form-group col-md-12">
            <label for="timepicker">From</label>
            <input type="text" name="timepicker" value=" ${from} " placeholder="12:00" class="form-control From"
                   data-timepicker="" autocomplete="off">
        </div>
        
        <div class="form-group col-md-12">
            <label for="timepicker">To</label>
            <input type="text" name="timepicker" value=" ${to}" placeholder="12:00" class="form-control To"
                   data-timepicker="" autocomplete="off">
        </div>
        
        <div class="DisableOverlay">
        </div>
        
        <div class="form-group col-md-12 ApplyForAll">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Apply for all</label>
            </div>
        </div>
    
    </form>
    `;

};
export {getOldForm,getNewForm}