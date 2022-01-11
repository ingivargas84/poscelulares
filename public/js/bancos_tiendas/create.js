$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción");


var validator = $("#BancosTiendasForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        banco_id: {
            required: true,
            select: 'default'
        },
        tienda_id: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        banco_id: {
            required: 'Seleccione una opción',
        },
        tienda_id: {
            required: 'Seleccione una opción',
        }
    }
});

$("#ButtonBancosTiendas").click(function (event) {
    if ($('#BancosTiendasForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonBancosTiendas");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});

