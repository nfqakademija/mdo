import {Time} from './Time.js';
class OldTime extends Time{
    constructor(type, from, to, id, date, asHash, enabled) {
        super(type, from, to, date);
        this._id = id;
        this._asHash = asHash;
        this._enabled = enabled;
        this._date = date;
    }
    get date() {
        return this._date;
    }
    set date(value) {
        this._date = value;
    }

    get id() {
        return this._id;
    }

    set id(value) {
        this._id = value;
    }

    get asHash() {
        return this._asHash;
    }

    set asHash(value) {
        this._asHash = value;
    }

    get enabled() {
        return this._enabled;
    }

    set enabled(value) {
        this._enabled = value;
    }

    getForm() {
        let Kids='',Adults='',formType = '';
        if(this.type === 'Kids')
        {
            Kids = 'selected';
            formType = 'timeKids';
        }
        if(this.type === 'Adults')
        {
            Adults = 'selected';
            formType = 'timeAdults';
        }
        return $(`
            <form class="formTime mb-4 ${formType}">
                <div class="topButtons topButtons--old">
                    <div class="closeButton"><i class="fas fa-times"></i></div>
                </div>
                
                <div class="bottomButtons">
                    <div class="form-group col-md-12">
                        <div class="custom-control custom-checkbox editTime">
                            <input type="checkbox" class="custom-control-input" id="editTime">
                            <label class="custom-control-label" for="editTime">Edit</label>
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
                    <input type="text" name="timepicker" value=" ${this.from} " placeholder="12:00" class="form-control From"
                           data-timepicker="" autocomplete="off">
                </div>
                
                <div class="form-group col-md-12">
                    <label for="timepicker">To</label>
                    <input type="text" name="timepicker" value=" ${this.to}" placeholder="12:00" class="form-control To"
                           data-timepicker="" autocomplete="off">
                </div>
                
                <div class="DisableOverlay"></div>
                
                <div class="form-group col-md-12 ApplyForAll">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Apply for all</label>
                    </div>
                </div>
            
            </form>
        `);
    }

    addTime() {
        super.addTime();
        $(super.target.find('#editTime')).change(()=>{
            this.enabled = !this.enabled;
            if(this.enabled){ super.target.find('.DisableOverlay').hide();super.target.find('.bottomButtons').css('color','black') }
            if(!this.enabled){ super.target.find('.DisableOverlay').show();super.target.find('.bottomButtons').css('color','white') }
        });
    }
}
export {OldTime};