import {Time} from './Time.js';
class NewTime extends Time{
    constructor(date,type = "Adults", from = "", to = "",repeatFor = 1) {
        super(type, from, to, date);
        this._repeatFor = repeatFor;
        this._date = date;
    }

    get date() {
        return this._date;
    }

    set date(value) {
        this._date = value;
    }

    get repeatFor() {
        return this._repeatFor;
    }

    set repeatFor(value) {
        this._repeatFor = value;
    }

    getForm(){
        return $(`
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
        `);
    }

    UpdateTheValues() {
        super.UpdateTheValues();
        const ticked = $(super.target).find('.repeatEveryCheckbox').prop( "checked" );
        this.repeatFor = (ticked) ? $(super.target).find('.repeatEveryInput').val() : 1;
    }
}
export {NewTime};