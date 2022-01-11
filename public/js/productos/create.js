$.validator.addMethod('entero', function(value, element){
    var regex = new RegExp("^(0+[1-9]|[1-9])[0-9]*$");
    return regex.test(value);
},"Esta cantidad no puede ser menor o igual a 0");

$.validator.addMethod('dinero', function(value, element){
    var regex = new RegExp("^\\d+(?:\\.\\d{0,2})?$");
    return regex.test(value);
},"El producto no puede costar menos de Q 0.00");


$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción");


$.validator.addMethod("getProductos", function(value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "/productos/getProductos/",
        data: "descripcion=" + value,
        dataType: "json",
        success: function(msg) {
            valid = !msg;
        }
    });
    return valid;
}, "Este producto con ésta descripción ya fue ingresada al sistema");




$.validator.addMethod("getCodigos", function(value, element) {
    var valid = false;
    $.ajax({
        type: "GET",
        async: false,
        url: "/productos/getCodigos/",
        data: "codigo=" + value,
        dataType: "json",
        success: function(msg) {
            valid = !msg;
        }
    });
    return valid;
}, "Este código ya fue ingresada al sistema");



var validator = $("#ProductoForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        marca_id: {
            required: true,
            select: 'default'
        },
        codigo: {
            required: true,
            getCodigos: true
        },
        modelo_id: {
            required: true,
            select: 'default',
        },
        precio_venta: {
            required: true,
            number: true,
            dinero: true
        },
        compania_id: {
            required: true,
            select: 'default'
        },
        presentacion: {
            required: true,
            select: 'default'
        },
        descripcion: {
            getProductos: true
        },
    },
    messages: {
        marca_id: {
            required: 'Por favor, seleccione una marca',
        },
        codigo: {
            required: 'Por favor, ingrese un código',
        },
        modelo_id: {
            required: 'Por favor, seleccione un modelo'
        },
        precio_venta: {
            required: 'Por favor, ingrese el precio de venta',
            number: 'Este campo solo admite valores numéricos'
        },
        compania_id: {
            required: 'Por favor, seleccione una compañía',
        },
        presentacion: {
            required: 'Por favor, seleccione un grupo de producto',
        }
    }
});



$("#ButtonProducto").click(function (event) {
    if ($('#ProductoForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonProducto");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});

