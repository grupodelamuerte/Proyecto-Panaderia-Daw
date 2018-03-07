$(document).ready(function(){
    
    $('#save-ticket').on('click',saveTicket);
    //guarda los detalles de un ticket en la base de datos
    
    function saveTicket(){
        if($(this).hasClass('disabled')){
            //alert('me salgo');
            return;
        }
        $.ajax(
            // Hago la llamada
            {
                url: 'ticket_detail_ajax/save_ticket',
                type: 'get',
                dataType: 'json',
                data: {
                    'idticket': $('#id_ticket').val()
                }
            }
        ).done(
            // Recibo la respuesta.
            function(json){
                var result = json.res;
                //alert(result);
                //muestro mensaje de haber guardado correctamente
                /*$(".blur").css('filter', 'blur(10px)');
                $('.close').siblings().remove();
                $("#modalEdit").css('display', 'block');
                
                var message = $('<h1>Ticket saved correctly</h1>');
                $('.modal-content').find('.close').after(message);*/
                
                $('#error').append('<p>Ticket saved correctly</p>');
                
                //crear un nuevo ticket
                createTicket();
                
            }
        ).fail(
            // No recibo la respuesta y hay un error
            function(){
                alert('Ha fallado guardar ticket');
            }
        ).always(
            // Se ejecuta siempre
            function(){
                
            }
        );
    }
    
});