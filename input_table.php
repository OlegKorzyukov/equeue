

<!DOCTYPE html>
<html>
<head>
   	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noindex,nofolow" />
	<title>Інформація про запис на прийом</title>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.5.1/css/colReorder.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="libs/css/style.css"/>

	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/colreorder/1.5.1/js/dataTables.colReorder.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/datetime-moment.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/date-de.js"></script>

</head>
<body>
	<div><h1 class="head-text-info">Інформація про запис на прийом</h1></div>
<div>
        <table id="table_id" class="display">
        <thead>
            <tr>
                <th>ПІБ</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Адреса</th>
                <th>Тип відвідування</th>
                <th>Робоче місце</th>
                <th>Час прийому</th>
                <th>Дата прийому</th>
                <th>Примітки</th>
                <th>Дата реєстрації</th>
            </tr>
        </thead>
    </table>
</div>


<script>
	$(document).ready(function() {
   var table = $('#table_id').DataTable( {
	   	language: {
					"decimal":        "",
				    "emptyTable":     "Немає даних у таблиці",
				    "info":           "Показано від _START_ до _END_ з _TOTAL_ записів",
				    "infoEmpty":      "Показати 0 до 0 з 0 записів",
				    "infoFiltered":   "(фільтрується з _MAX_ всіх записів)",
				    "infoPostFix":    "",
				    "thousands":      ",",
				    "lengthMenu":     "Показати _MENU_ записів",
				    "loadingRecords": "Завантаження...",
				    "processing":     "Обробка...",
				    "search":         "Знайти:",
				    "zeroRecords":    "Не знайдено відповідних записів",
				    "paginate": {
				        "first":      "Перша",
				        "last":       "Остання",
				        "next":       "",//"Наступна",
				        "previous":   ""//"Попередня"
				    },
				    "aria": {
				        "sortAscending":  ": активувати, щоб сортувати стовпець по висхідній",
				        "sortDescending": ": активувати, щоб сортувати стовпець у спаді"
				    }
    	},
    	colReorder: true,
    	//responsive: true,
    	fixedHeader: true,
        stateSave: true,
        "paging": true,
        "ordering": true,
        "order": [[ 7, 'desc' ]],
       "lengthMenu": [ [15, 25, 50, 100, -1], [15, 25, 50, 100, "Всі"] ],
        "search": {
            "regex": true
        },
        //"pageLength": 22,
    	 dom: 'B<"clear">lfrtip',
    	buttons: [
            {
            extend: 'print',
            text: 'Роздрукувати',
            autoPrint: true,
            exportOptions: {
                columns: ':visible',
            },
            customize: function (win) {
              
                $(win.document.body).find('table')
                    .addClass('display')
                    .css('font-size', '9px')
                    .css('text-align', 'center');

                $(win.document.body).find('thead')
                    .css('font-size', '16px');

                $(win.document.body).find('tbody')
                    .css('font-size', '14px');

                $(win.document.body).find('h1')
                .css('text-align','center');
            }
        	},
            {extend: 'pdfHtml5',text: 'PDF',className: 'pdf_queue',orientation: 'portrait',pageSize: 'A4',exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6],orthogonal: 'export'}, customize: function(doc){
                doc['styles'] = {
                    tableHeader: {
                        bold: !0,
                        fontSize: 10,
                        color: 'black',
                        fillColor: '#dee3e6',
                        alignment: 'center'
                    },
                    column: {
                        alignment: 'center',
                        border: 4
                        
                    },
                    title: {
                        fontSize: 18,
                        bold: true,
                        margin: [0,0,0,0],
                        alignment: 'center'
                    }
                }
                }
            },
            { extend: 'excelHtml5', text: 'EXCEL',autoFilter: true}

        ],
    	"autoWidth": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "input.php",
            "type": "POST",
        },
        "columns": [
            { "data": "h_fname" },
            { "data": "h_telephone" },
            { "data": "h_email" },
            { "data": "h_address"},
            { "data": "h_type" },
            { "data": "h_workplace" },
            { "data": "h_timequeue" },
            { "data": "h_dataqueue" },
            { "data": "h_prymitka"},
            { "data": "h_datetimereg"}
          ]
    });

    setInterval( function () {
    table.ajax.reload( null, false );
	}, 60000 );
		table.columns.adjust().draw();
    $('#table_id tbody')
        .on( 'mouseenter', 'td', function () {
            var colIdx = table.cell(this).index().column;
 
            $( table.cells().nodes() ).removeClass( 'highlight' );
            $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
        } );

});
</script>

</body>
</html>