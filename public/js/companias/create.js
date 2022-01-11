
$.validator.addMethod("nombreunico", function(value, element){
    var valid = false;
    $.ajax({
        type: "GET",
        async: false,
        url: "/companias/nombreDisponible/",
        data:"nombre=" + value,
        dataType: "json",
        success: function(msg) {
            valid = !msg;
        }
    });
    return valid;
}, "Esta compañía ya existe en el sistema");



    var validator = $("#CompaniaForm").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            compania: {
                    required : true,
                    nombreunico : true
            }
        },
        messages: {
            compania: {
                required: "Por favor, ingrese el nombre de la compañía"
            }
        }
    });



    $("#ButtonCompania").click(function (event) {
        if ($('#CompaniaForm').valid()) {
            $('.loader').addClass("is-active");
            var btnAceptar=document.getElementById("ButtonCompania");
            var disableButton = function() { this.disabled = true; };
            btnAceptar.addEventListener('click', disableButton , false);
        } else {
            validator.focusInvalid();
        }
    });