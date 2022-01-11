$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");

$.validator.addMethod("diff", function(value, element, arg){
    if ($('#tienda_envia').val() == $('#tienda_recibe').val()) {
        return false
    }else{
        return true
    }
},"La tienda que recibe no puede ser la misma que envia");


var validator = $("#RecargastForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        tienda_envia: {
            select: 'default',
        },
        tienda_recibe: {
            select: 'default',
            diff: true,
        },
        compania_id: {
            select: 'default',
        },
        total: {
            required: true
        },
    },
    messages: {
        total: {
            required: 'Por favor, ingrese el Saldo a Trasladar',
        },
    }
});

$("#ButtonRecargat").click(function (event) {
    if ($('#RecargastForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonRecargat");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});
