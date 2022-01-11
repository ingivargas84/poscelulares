$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una marca");



$.validator.addMethod("getModelos", function(value, element) {
    var valid = false;
    var marca = $("#marca_id").val();
    var modelo = $("#modelo").val();
    $.ajax({
        type: "GET",
        async: false,
        url : "/modelos/getModelos/",
        data: {
            "modelo" : modelo,
            "marca" : marca
        },
        dataType: "json",
        success: function(msg) {
            valid = !msg;
        }
    });
    return valid;
}, "Este modelo con ésta marca ya existe en el sistema");



var validator = $("#ModeloForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        modelo: {
            required: true,
            getModelos: true
        },
        marca_id: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        modelo: {
            required: 'Por favor, ingrese el nombre de la marca',
        },
        marca_id: {
            required: 'Por favor, ingrese el nombre de la marca',
        }
    }
});


$("#ButtonModelo").click(function (event) {
    if ($('#ModeloForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonModelo");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});