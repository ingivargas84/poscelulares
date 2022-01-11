var recargas_table = $('#recargas-table').DataTable({
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
    ],

    "buttons": [
    'pageLength',
    'excelHtml5',
    'csvHtml5'
    ],

    "paging": true,
    "language": {
        "sdecimal":        ".",
        "sthousands":      ",",
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],

    "columns": [ {
        "title": "#",
        "data": "id",
        "width" : "5%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    
    {
        "title": "Tienda",
        "data": "tienda",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Compañía",
        "data": "compania",
        "width" : "10%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Entrada",
        "data": "entrada",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Salida",
        "data": "salida",
        "width" : "10%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Saldo",
        "data": "saldo",
        "width" : "10%",
        "responsivePriority": 6,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Usuario",
        "data": "name",
        "width" : "10%",
        "responsivePriority": 7,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Fecha y Hora",
        "data": "created_at",
        "width" : "10%",
        "responsivePriority": 8,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
     
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "5%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();

            if (rol_user == 'Administrador' || rol_user == 'Super-Administrador') {
                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-left col-lg-4'>" +
                "<a href='recargas/edit/"+full.id+"' class='edit-recarga' >" + 
                "<i class='fa fa-btn fa-edit' title='Editar Saldo de Recarga'></i>" +
                "</a>" + "</div>";
            } else {
                return "<div id='" + full.id + "' class='text-center'>" + "</div>";
            }
            
        },
        "responsivePriority": 5
    }
]

});
