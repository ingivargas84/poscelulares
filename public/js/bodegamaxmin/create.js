$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una marca");



$.validator.addMethod("getMaxmin", function(value, element) {
    var valid = false;
    var tienda = $("#tienda_id").val();
    var producto = $("#producto_id").val();
    $.ajax({
        type: "GET",
        async: false,
        url : "/bodegamaxmin/getMaxmin/",
        data: {
            "tienda" : tienda,
            "producto" : producto
        },
        dataType: "json",
        success: function(msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El registro de máximos y mínimos para ésta tienda y producto ya se encuentra en el sistema");



var validator = $("#MaximoMinimoForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        tienda_id: {
            required: true,
            select: 'default',
            getMaxmin: true
        },
        producto_id: {
            required: true,
            select: 'default'
        },
        stock_maximo: {
            required: true
        },
        stock_minimo: {
            required: true
        }
    },
    messages: {
        tienda_id: {
            required: 'Por favor, ingrese el nombre de la marca',
        },
        producto_id: {
            required: 'Por favor, ingrese el nombre de la marca',
        },
        stock_maximo: {
            required: 'Por favor, ingrese el stock máximo',
        },
        stock_minimo: {
            required: 'Por favor, ingrese el stock mínimo',
        },
    }
});


$("#ButtonMaximoMinimo").click(function (event) {
    if ($('#MaximoMinimoForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonMaximoMinimo");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});