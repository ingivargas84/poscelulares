$.validator.addMethod("nombreunico", function(value, element){
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "/formas_pago/nombreDisponible/",
        data:"nombre=" + value,
        dataType: "json",
        success: function (msg) {
            valid=!msg;
        }
    });
    return valid;
    }, "La forma de pago ya esta registrada en el sistema");


var validator = $("#InsertarForm").validate({
    ignore: [],
    onkeyup: false,
    onfocusout: false,
    rules: {
        nombre: {
            required: true,
            nombreUnico: true
        }
    },
    messages: {
        nombre: {
            required: 'Por favor, ingrese el nombre de la forma de pago',
        }
    }
});

$("#btnInsertar").click(function (event) {
    if ($('#InsertarForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("btnInsertar");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});
