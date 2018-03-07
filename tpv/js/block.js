$(document).ready(function() {
    $.ajax({
        url: 'product_ajax/block',
        type: 'get',
        dataType: 'json',
    }).done(
        function(data) {
            var status = data.status;
            console.log(status);
            if (status == 'true') {
                $(".blur").css('filter', 'blur(40px)');
                $("#modalBlock").css('display', 'block');
                blockDangerousKeys();
            }
            else {
                $(".blur").css('filter', 'blur(0px)');
                $("#modalBlock").css('display', 'none');
                unblockDangerousKeys();
            }
        }
    ).fail(
        function() {
            console.log("Hubo un error.");
        }
    );

    $("#passblock").change(function() {
        $("#unblock").removeClass("errorShake");
    });

    $("#unblock").click(function() {
        var pass = $("#passblock").val();

        // Obtener contraseña XML y comparar con var pass.
        var ok = false;
        if (pass != '') {
            $.ajax({
                url: 'product_ajax/block',
                type: 'get',
                dataType: 'json',
                data: {
                    pass: pass,
                    status: false
                }
            }).done(
                function(data) {
                    var status = data.status;
                    console.log(status);
                    if (status == 'false') {
                        $(".blur").css('filter', 'blur(0px)');
                        $("#modalBlock").css('display', 'none');
                        unblockDangerousKeys();
                    }
                    else {
                        $("#unblock").addClass("errorShake");
                    }
                }
            ).fail(
                function() {
                    console.log("Hubo un error.");
                    $("#unblock").removeClass("errorShake");
                    $("#unblock").addClass("errorShake");
                }
            );
        }
    });


    $("#blockscreen").click(function() {
        $("#passblock").val('');
        $.ajax({
            url: 'product_ajax/block',
            type: 'get',
            dataType: 'json',
            data: {
                status: true
            }
        }).done(
            function(data) {
                $(".blur").css('filter', 'blur(40px)');
                $("#modalBlock").css('display', 'block');

                //se quedaban residuos en la ventana, asi que borro todo menos el span donde se pide la contraseña
                $('#modalBlock .modal-content').find('span').siblings().remove();

                blockDangerousKeys();
            }
        ).fail(
            function() {
                console.log("Hubo un error.");
            }
        );
    });

    function unblockDangerousKeys() {
        $(document).unbind();
    }

    function blockDangerousKeys() {
        $(document).keydown(function(evt) {
            var keycode = evt.which;
            if (keycode >= 111 && keycode <= 123) { //Enter key's keycode
                $("#unblock").attr("style", "border: 2px solid red");
                setTimeout(function() {
                    $("#unblock").attr("style", "border: 2px solid white");
                }, 200);
                return false;
            }
        });
        $(document).on("contextmenu", function() {
            $("#unblock").attr("style", "border: 2px solid red");
            setTimeout(function() {
                $("#unblock").attr("style", "border: 2px solid white");
            }, 200);
            return false;
        });
    }

    /* Ya que el bloqueo está en todos lados pondré aquí el código de las tostadas de error. */
    
    /* Esta forma no funciona porque crea bucles infinitos. */
    // $('#error, .error').on("DOMSubtreeModified", function(e) {
    //     var that = $(this);
    //     $(this).addClass("show");
    //     setTimeout(function() {
    //         that.removeClass("show");
    //         that.text('');
    //         e.stopInmediatePropagation();
    //     }, 3000);
    // });
    
    var targetNodes         = $("#error, .error");
    var MutationObserver    = window.MutationObserver || window.WebKitMutationObserver;
    var myObserver          = new MutationObserver(mutationHandler);
    var obsConfig           = { childList: true, characterData: true, attributes: true, subtree: true };

    //--- Añade un observador a cada nodo.
    targetNodes.each (function () {
        myObserver.observe (this, obsConfig);
    });
    
    /**
     * Cada vez que cambia uno de los mensajes de error, este se muestra el 
     * el toast.
     * En el caso de los formularios más grandes donde cada campo tiene un mensaje
     * de error, todos los mensajes convergen en una una etiqueta y ésta es la que salta.
     * Pasados 3 segundos desactiva el observador y lo reactiva para evitar el loop.
     */
    function mutationHandler (mutationRecords) {
        mutationRecords.forEach (function (mutation) {
            $("#error").addClass("show");
            setTimeout(function() {
                $("#error").removeClass("show");
                $("#error").text('');
                myObserver.disconnect();
                setTimeout(function() {
                    targetNodes.each (function () {
                        myObserver.observe (this, obsConfig);
                    });
                });
            }, 3000);
        } );
    }
    
    $('#error, .error').click(function() {
        $(this).removeClass("show");
        $(this).text('');
    });
});
