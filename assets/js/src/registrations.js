$(()=>{
    $('#table_id').DataTable();
    $('.CancelButton').click((e)=>{
        const id = parseInt(($(e.currentTarget).parents('tr').attr('id') + "").replace('registration-',''));
        $.confirm({
            title: '<i class="fas fa-exclamation-triangle" style="color: #e74d3d;"></i> WARNING!',
            content: 'Are you sure that you want to cancel this registration?',
            type: 'red',
            buttons: {
                confirm: {
                    btnClass: 'btn-red',
                    action : function(){
                        $.ajax({
                            type: 'POST',
                            url: "/cancel-reservation/"+id,
                            success:()=>{
                                location.reload();
                            },
                            async: false
                        });
                        return false;
                    }
                },
                cancel: {
                    action : ()=>{}
                },
            }
        });
    });
    $('.Comment').each((el)=>{
        console.log($(el).html())
    })
});
