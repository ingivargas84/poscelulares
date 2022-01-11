var pedidos_table = $('#pedidos-table').DataTable({
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [10, 25, 50, -1],
        ['10 filas', '25 filas', '50 filas', 'Mostrar todo']
    ],

    "buttons": [
        'pageLength',
        {
            extend: 'excelHtml5',
            title: 'Pedidos',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5]
            }
        }
    ],

    "paging": true,
    "language": {
        "sdecimal": ".",
        "sthousands": ",",
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],

    "columns": [
            {
        "title": "No. de Venta",
        "data": "no_pedido",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
    {
        "title": "Fecha",
        "data": "fecha",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Cliente",
        "data": "cliente",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
    {
        "title": "Bodega",
        "data": "bodega",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Vendedor",
        "data": "vendedor",
        "responsivePriority": 4,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Total",
        "data": "total",
        "responsivePriority": 2,
        "className": "text-right",
        "render": function (data, type, full, meta) {
            return 'Q. ' + Number.parseFloat((data)).toFixed(2);
        },
    },

    {
        "title": "Acciones",
        "orderable": false,
        "responsivePriority": 1,
        "width": "15%",
        "className": "text-center",
        "render": function (data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("#urlActual").val();

            if (rol_user == 'Super-Administrador' || rol_user == 'Administrador') {
                return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-center col-lg-6'>" +
                    "<a href='" + urlActual + "/" + full.id + "' class='show-pedido' >" +
                    "<i class='fas fa-info-circle' title='Ver detalles de la Venta'></i>" +
                    "</a>" + "</div></div>" +
                    "<div class='float-center col-lg-6'>" +
                    "<a href='#' class='remove-pedido' data-method='delete' data-bodega_id='" + full.bodega_id + "' data-id='" + full.id + "' data-target='#modalConfirmarAccion' data-toggle='modal'>" +
                    "<i class='fas fa-trash-alt' title='Eliminar Venta'></i>" +
                    "</a>" + "</div></div>";
            } else {
                return "<div id='" + full.id + "' class='text-center'>" +
                "<div class='float-center col-lg-12'>" +
                "<a href='" + urlActual + "/" + full.id + "' class='show-pedido' >" +
                "<i class='fas fa-info-circle' title='Ver detalles de la Venta'></i>" +
                "</a>" + "</div></div>";
            }
        },
        "responsivePriority": 5
    }]

});

$("#btnConfirmarAccion").click(function (event) {
    event.preventDefault();
    confirmarAccion();
});


function confirmarAccion(button) {
    $('.loader').fadeIn();
    var formData = $("#ConfirmarAccionForm").serialize();
    var id = $("#idConfirmacion").val();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#tokenReset').val() },
        url: APP_URL + "/pedidos/" + id + "/delete",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#modalConfirmarAccion').modal("hide");
            pedidos_table.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('La Venta se Eliminó Correctamente!!');
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            if (errors.responseText != "") {
                var errors = JSON.parse(errors.responseText);
                if (errors.password_actual != null) {
                    $("input[name='password_actual'] ").after("<label class='error' id='ErrorPassword_actual'>" + errors.password_actual + "</label>");
                }
                else {
                    $("#ErrorPassword_actual").remove();
                }
            }

        }

    });
}
