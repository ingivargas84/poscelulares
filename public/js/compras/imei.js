var imei_table = $('#imei-table').DataTable({
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
    ],

    "paging": true,
    "language": {
        "sdecimal": ".",
        "sthousands": ",",
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún detalle agregado a esta compra.",
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

    "columns": [{
        "title": "IMEI",
        "data": "imei",
        "width": "35%",
        "className": "text-left",
        "visible": true,
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Acciones",
        "orderable": false,
        "width": "35%",
        "className": "text-center",
        "render": function (data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();
            
            
            
            return "<div class='float-right col-lg-12'>" +
                "<a href='#' class='remove-detail' data-method='delete' data-id='" + full.id + "'>" +
                "<i class='fas fa-trash-alt' title='Eliminar IMEI'></i>" +
                "</a>" + "</div></div>";
        },
        "responsivePriority": 5
    }]

});



$(document).on('click', 'a.remove-detail', function (e) {
    e.preventDefault(); // does not go through with the link.
    var $this = $(this);
    alertify.confirm('Eliminar Imei', 'Esta seguro de eliminar el imei',
        function () {
            $('.loader').fadeIn();
            //removes the table row
            imei_table.row($this.parents('tr')).remove().draw(); 

            var conteo = parseFloat($('#count').val());
            conteo = conteo - 1;      
            $("input[name='count'] ").val(conteo);

        }, function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.warning('Cancelar')
        });
});

    