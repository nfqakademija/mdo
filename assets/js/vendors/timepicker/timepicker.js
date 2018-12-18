const createTimePicker = () => {
    $('body').on('blur','*[data-timepicker]',function(e){
        console.log('test');
        const target = e.target;
        target.type = 'tel';
        const input = target.value;
        let values = input.split(':').map(function(v){return v.replace(/\D/g, '')});
        console.log(values);
        if(values[0].length === 1)
        {
            values[0] = '0' + values[0];
        }
        if(values[1] && values[1].length !==0) {
            if(values[1].length===1) values[1] = values[1] + '0';
        }
        else{
            values[1] = '00';
        }
        if(values[0] === '')
            target.value = '';
        else
            target.value = values[0] + ':' + values[1];
    });
    $('body').on('input','*[data-timepicker]',(e)=>{
        const target = e.target;
        target.type = 'text';
        var input = target.value;
        console.log(e.originalEvent.inputType);
        if(e.originalEvent.inputType != "insertText")
        {
            if(/:$/.test(input)) input = input.substr(0, 2);
            target.value = input;
        }
        else{
            var values = input.split(':').map(function(v){return v.replace(/\D/g, '')});
            console.log(values);
            let output = "";
            if(values[0]) values[0] = checkValue(values[0], 24);
            if(values[1]) values[1] = checkValue(values[1].substr(0,2), 59);

            if((values[1] && values[1].length > 0))
            {
                output = values[0]+':'+values[1];
            }
            else{
                if(values[0].length<=1)
                output = values[0];
                else output = values[0]+':';
            }
            target.value = output.substr(0, 5);
        }
    });
    function checkValue(str, max){
        if(str.charAt(0) !== '0'){
            var num = parseInt(str);
            if(isNaN(num) || num <= 0) num = 1;
            if(num > max) num = max;
            str = num > parseInt(max.toString().charAt(0)) && num.toString().length == 1 ? '0' + num : num.toString();
        };
        return str;
    };
};
export {createTimePicker};