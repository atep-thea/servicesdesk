$(document).ready(function() {
    $('select[name="id_team"]').on('change', function(){
        var idTeam = $(this).val();
        if(idTeam) {
            $.ajax({
                url: '/new_tiket/getAgen/'+idTeam,
                type:"GET",
                dataType:"json",

                success:function(data) {
                    
                    $('select[name="agen_id"]').empty();
                    console.log(data);
                    $.each(data, function(key, value){
                        key
                        $('select[name="agen_id"]').append('<option value="'+ key +'">' + value + '</option>');
                    });
                },

            });
        } else {
            $('select[name="agen_id"]').empty();
        }

    });
});