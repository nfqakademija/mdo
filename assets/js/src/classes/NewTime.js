import {Time} from './Time.js';
class NewTime extends Time{
    constructor(date,type = "Adults", from = "", to = "",repeatFor = 1) {
        super(type, from, to, date);
        this._repeatFor = repeatFor;
        super.target = this.getForm();
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
                     <small class="Errors form-text text-danger"></small>
                </div>
                <div class="form-group col-md-12">
                    <label for="timepicker">From</label>
                    <input type="text" name="timepicker" placeholder="" class="form-control From" data-timepicker=""
                           autocomplete="off">
                     <small class="Errors form-text text-danger"></small>
                </div>
                <div class="form-group col-md-12">
                    <label for="timepicker">To</label>
                    <input type="text" name="timepicker" placeholder="" class="form-control To" data-timepicker=""
                           autocomplete="off">
                     <small class="Errors form-text text-danger"></small>
                </div>
                <div class="form-group col-md-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                             <div class="input-group-text">
                                <span> Repeat for </span>
                            </div>
                        </div>
                        <input type="number" min="1" class="repeatEveryInput form-control" value=""
                               aria-label="Text input with checkbox">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span> week(s) </span>
                            </div>
                        </div>
                    </div>
                    <small class="Errors form-text text-danger"></small>
                </div>
            </form>
        `);
    }

    UpdateTheValues() {
        super.UpdateTheValues();
        this.repeatFor = $(super.target).find('.repeatEveryInput').val();
    }

    getSaveObj() {
        return Object.assign(super.getSaveObj(), {repeatFor:parseInt(this._repeatFor)});
    }



}
export {NewTime};