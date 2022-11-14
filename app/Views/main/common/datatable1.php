<link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="https://cdn.datatables.net/scroller/2.0.5/css/scroller.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.datatables.net/scroller/2.0.5/js/dataTables.scroller.min.js" type="text/javascript"></script>
<link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>


<style>
table#datatable{    width:100% !important;}#datatable_filter{display:none !important;}.filterblur{filter: blur(4px);}.sent {        background-color:#fff0f0!important;    }    .table .btn {        margin:0px!important;    }
</style>

<script>
	    
$(document).ready(function(){
    var getajaxdatatableURL = $("#ajaxdatatableURL").val();   
    var table = $('#datatable').DataTable({
		    "scrollX": true,
		    "scrollY": 575,
		    "pagingType": "numbers",
		    "ordering": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": getajaxdatatableURL,
		    "scroller": {
				"loadingIndicator": true,
		    },		    
		    "bScrollInfinite": true,
		    "scrollCollapse": true,
			"drawCallback": function( settings){
				$("#datatable tbody").removeClass('filterblur');
			},
			"createdRow": function( row, data, dataIndex ) {
				$( row ).addClass($( row ).find('td a.checkclass').attr('data-row-class'));				
				$(row).attr("id","changer-"+$( row ).find('td a.checkclass').attr('data-id'));				
			}
		});
    table.columns().every(function () {
		var table = this;   
		$('input,select', this.header()).on('keyup change', function () {
			$("#datatable tbody").addClass('filterblur');
			if (table.search() !== this.value) {
			   table.search(this.value).draw();
			}
		});
    });
	var buttons = new $.fn.dataTable.Buttons(table, {
		buttons: [
			{
				"extend": 'print',
				"text": 'Print',
				"titleAttr": 'Print',
				"action": newexportaction,
				"exportOptions": {
					columns: [0,1,2,3,4],
                    modifier: {
						page: 'visible'
                    },
					format: {
						header: function ( data, columnIdx ) {
							if(columnIdx==0){
								return 'Client';
							}
							else if(columnIdx==1){
								return 'Zip Code';
							}
							else if(columnIdx==2){
								return 'Branch';
							}
							else if(columnIdx==3){
								return 'Product';
							}
							else if(columnIdx==4){
								return 'Received Time';
							}
							else if(columnIdx==5){
								return 'Actions';
							}
							else{
								return data;
							}
						}
					}
                }
			},
			{
				"extend": 'copyHtml5',
				"text": 'Copy',
				"titleAttr": 'Copy',
				"action": newexportaction,
				"exportOptions": {
					columns: [0,1,2,3,4],
                    modifier: {
						page: 'visible'
                    },
					format: {
						header: function ( data, columnIdx ) {
							if(columnIdx==0){
								return 'Client';
							}
							else if(columnIdx==1){
								return 'Zip Code';
							}
							else if(columnIdx==2){
								return 'Branch';
							}
							else if(columnIdx==3){
								return 'Product';
							}
							else if(columnIdx==4){
								return 'Received Time';
							}
							else if(columnIdx==5){
								return 'Actions';
							}
							else{
								return data;
							}
						}
					}
                }
			},
			{
				"extend": 'pdfHtml5',
				"text": 'PDF',
				"titleAttr": 'PDF',
				"action": newexportaction,
				"customize": function (doc) {
					doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
				},
				"exportOptions": {
					columns: [0,1,2,3,4],
                    modifier: {
						page: 'visible'
                    },
					format: {
						header: function ( data, columnIdx ) {
							if(columnIdx==0){
								return 'Client';
							}
							else if(columnIdx==1){
								return 'Zip Code';
							}
							else if(columnIdx==2){
								return 'Branch';
							}
							else if(columnIdx==3){
								return 'Product';
							}
							else if(columnIdx==4){
								return 'Received Time';
							}
							else if(columnIdx==5){
								return 'Actions';
							}
							else{
								return data;
							}
						}
					}
                }
			},
			{
				"extend": 'excelHtml5',
				"text": 'Excel',
				"titleAttr": 'Excel',
				"action": newexportaction,
				"exportOptions": {
					columns: [0,1,2,3,4],
                    modifier: {
						page: 'visible'
                    },
					format: {
						header: function ( data, columnIdx ) {
							if(columnIdx==0){
								return 'Client';
							}
							else if(columnIdx==1){
								return 'Zip Code';
							}
							else if(columnIdx==2){
								return 'Branch';
							}
							else if(columnIdx==3){
								return 'Product';
							}
							else if(columnIdx==4){
								return 'Received Time';
							}
							else if(columnIdx==5){
								return 'Actions';
							}
							else{
								return data;
							}
						}
					}
                }
			},
			{
				"extend": 'csvHtml5',
				"text": 'CSV',
				"titleAttr": 'CSV',
				"action": newexportaction,
				"exportOptions": {
					columns: [0,1,2,3,4],
                    modifier: {
						page: 'visible'
                    },
					format: {
						header: function ( data, columnIdx ) {
							if(columnIdx==0){
								return 'Client';
							}
							else if(columnIdx==1){
								return 'Zip Code';
							}
							else if(columnIdx==2){
								return 'Branch';
							}
							else if(columnIdx==3){
								return 'Product';
							}
							else if(columnIdx==4){
								return 'Received Time';
							}
							else if(columnIdx==5){
								return 'Actions';
							}
							else{
								return data;
							}
						}
					}
                }
			},			
		]
	}).container().appendTo($('.portlet div.tools'));

	$('.portlet div.tools div.dt-buttons button').addClass('btn default');

});

function newexportaction(e, dt, button, config) {
	 var self = this;
	 var oldStart = dt.settings()[0]._iDisplayStart;
	 dt.one('preXhr', function (e, s, data) {
		 // Just this once, load all data from the server...
		 data.start = 0;
		 data.length = '-1';
		 dt.one('preDraw', function (e, settings) {
			 // Call the original action function
			 if (button[0].className.indexOf('buttons-copy') >= 0) {
				 $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
			 } else if (button[0].className.indexOf('buttons-excel') >= 0) {
				 $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
					 $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
					 $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
			 } else if (button[0].className.indexOf('buttons-csv') >= 0) {
				 $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
					 $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
					 $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
			 } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
				 $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
					 $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
					 $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
			 } else if (button[0].className.indexOf('buttons-print') >= 0) {
				 $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
			 }
			 dt.one('preXhr', function (e, s, data) {
				 // DataTables thinks the first item displayed is index 0, but we're not drawing that.
				 // Set the property to what it was before exporting.
				 settings._iDisplayStart = oldStart;
				 data.start = oldStart;
			 });
			 // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
			 setTimeout(dt.ajax.reload, 0);
			 // Prevent rendering of the full data to the DOM
			 return false;
		 });
	 });
	 // Requery the server with the new one-time export settings
	 dt.ajax.reload();
 }
</script>
