import {Time} from './Time.js';
import {updateCalendar} from "../times-page";
class OldTime extends Time{
    constructor(type, from, to, id, date, asHash, enabled) {
        super(type, from, to, date);
        this._id = id;
        this._asHash = asHash;
        this._applyForAll = false;
        this._enabled = enabled;
        super.target = this.getForm();
    }


    get applyForAll() {
        return this._applyForAll;
    }

    set applyForAll(value) {
        this._applyForAll = value;
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
                            <input type="checkbox" class="custom-control-input editCheckbox" id="editTime${this.id}">
                            <label class="custom-control-label" for="editTime${this.id}">Edit</label>
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
                        <input type="checkbox" class="custom-control-input" id="customCheck1${this.id}">
                        <label class="custom-control-label" for="customCheck1${this.id}">Apply for all</label>
                    </div>
                </div>
            
            </form>
        `);
    }

    addTime() {
        super.addTime();
        $(super.target.find('.editCheckbox')).change(()=>{
            this.enabled = !this.enabled;
            if(this.enabled){ super.target.find('.DisableOverlay').hide();super.target.find('.bottomButtons').css('color','black') }
            if(!this.enabled){ super.target.find('.DisableOverlay').show();super.target.find('.bottomButtons').css('color','white') }
        });
    }

    UpdateTheValues() {
        super.UpdateTheValues();
        this._applyForAll = super.target.find('.ApplyForAll').find('input').prop('checked');
    }

    getSaveObj() {
        return Object.assign(super.getSaveObj(), {id:this._id,hash:this._asHash,applyForAll:this._applyForAll});
    }
    CloseAction(){
        const target = super.target;
        const that = this;
        $.confirm({
            title: '<i class="fas fa-exclamation-triangle" style="color: #e74d3d;"></i> WARNING!',
            content: 'Are you sure that you want to cancel this registration?',
            type: 'red',
            buttons: {
                confirm: {
                    btnClass: 'btn-red',
                    action : function(){
                        if(that._applyForAll){
                            $.ajax({
                                type: 'DELETEHASH',
                                url: `/sessions/${that.asHash}`,
                                success:()=>{
                                    target.remove();
                                    updateCalendar();
                                    this.close();
                                }
                            });
                        }
                        else{
                            $.ajax({
                                type: 'DELETE',
                                url: `/sessions/${that.id}`,
                                success:()=>{
                                    target.remove();
                                    updateCalendar();
                                    this.close();
                                }
                            });
                        }
                        return false;

                    }
                },
                cancel: {
                    action : ()=>{}
                },
            }
        });
    }
}
export {OldTime};