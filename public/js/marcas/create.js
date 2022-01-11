
$.validator.addMethod("marcaUnica", function(value, element){
    var valid = false;
    $.ajax({
        type: "GET",
        async: false,
        url: "/marcas/marcaDisponible/",
        data: "marca=" + value,
        dataType: "json",
        success: function (msg) {
            valid=!msg;
        }
    });
    return valid;
}, "Esta marca ya está registrada en el sistema");


var validator = $("#MarcaForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        marca: {
            required: true,
            marcaUnica: true
        }
    },
    messages: {
        marca: {
            required: 'Por favor, ingrese el nombre de la marca',
        }
    }
});


$("#ButtonMarca").click(function (event) {
    if ($('#MarcaForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonMarca");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});