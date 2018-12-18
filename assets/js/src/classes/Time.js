import {getSessions, setSessions} from "../times-page";

class Time {
    constructor(type, from, to, date) {
        this._date = date;
        this._type = type;
        this._from = from;
        this._to = to;
        this._target = null;
    }
    get target() {
        return this._target;
    }

    set target(value) {
        this._target = value;
    }

    get date() {
        return this._date;
    }

    set date(value) {
        this._date = value;
    }

    get type() {
        return this._type;
    }

    set type(value) {
        this._type = value;
    }

    get from() {
        return this._from;
    }

    set from(value) {
        this._from = value;
    }

    get to() {
        return this._to;
    }

    set to(value) {
        this._to = value;
    }

    getForm(){
        throw new Error('You have to implement the method getForm!');
    }

    CloseAction(){
        this.target.remove();
        setSessions(getSessions().map(session => session.target!==this.target));
    }

    getSaveObj(){
        return {
            date: this._date.getFullYear() + "-" + (this._date.getMonth()+1) + "-" + this._date.getDate(),
            type: this._type,
            to: this._to,
            from: this._from
        }
    }

    UpdateTheValues(){
        this.type = $(this.target).find('.Type').val();
        this.from = $(this.target).find('.From').val();
        this.to = $(this.target).find('.To').val();
        (this.type === 'Kids') ?$(this.target).removeClass('timeAdults').addClass('timeKids') :$(this.target).removeClass('timeKids').addClass('timeAdults');
        this.target.find('.closeButton').off('click').click(()=>{
            this.CloseAction();
        });
    }

    addTime() {
        $('.times').append(this.target);
        this.UpdateTheValues();
        $(this.target).change((e)=>{
          $(e.target).parents('.form-group').find('.Errors').html('');
            this.UpdateTheValues();
        });
    }
    static findTime( arr,date )
    {
        return arr.filter( time => time.date.getTime() === date.getTime() );
    }

}
export {Time};