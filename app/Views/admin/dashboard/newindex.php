<?php
	$thisEmployee = get_langer('employees',false,$adminDetails->employee_id);
	$thisbranch = get_langer('branches',$admin_lang,$thisEmployee->branch_id);
	$sentInvoices = print_count('setproject',array('parent_id'=>0,'sendtime<>'=>0));
	$quotes = print_count('quotes',array());
	//pp($quotes);
	$employeescount = print_count('employees',array());
	$employees = get_table_where('employees',false);


?>
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php print_r(ipinfo()); ?>"><?php print_r(ipinfo()); ?></span>
                </div>
                <div class="desc"> Total Website visit </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 red" href="<?php if ($adminDetails->role == 'Global Admin') { echo $admin_link.'/setproject'; } else {echo 'branch/setproject';} ?>">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?=$sentInvoices?>"><?=$sentInvoices?></span>
                </div>
                <div class="desc"> Invoice Sent </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 green" href="<?php if ($adminDetails->role == 'Global Admin') { echo $admin_link.'/quotes'; } else {echo 'branch/quotes';} ?>">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?=$quotes?>"><?=$quotes?></span>
                </div>
                <div class="desc"> Quotes Received </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 purple" href="<?=$admin_link?>/employees">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number"> 
                    <span data-counter="counterup" ><?=$employeescount?></span>
                </div>
                <div class="desc"> Employees </div>
            </div>
        </a>
    </div>

    <form method="POST" id="formfilter">


	<div  id="CRM_filters" style="margin:5px 0;">
		<div class="col-lg-12 text-right" style="margin:15px 0;">
			<a href="javascript:" id="showhidefilter" class="btn btn-sm btn-light btn-active-primary">Show / Hide CRM Filter</a>
		</div>
		
		<div id="dashCRMfilter" class="col-lg-12" style="display:none;margin:5px 0;">
		    <div class="col-lg-12 bg-white" style="padding-top: 10px;">
		    <h2>Filters</h2>
		    <div class="col-lg-3" style="padding-top: 10px;">
			    <div class="form-group">
				    <label for="datepicker_2" class="mb-2 mr-sm-2">Date</label>    
				    <input type="text" name="datepicker_2" class="form-control mb-2 mr-sm-2" id="datepicker_2" placeholder="Date" >
			    </div>
		    </div>
		    <div class="col-lg-12" style="padding-top: 10px;padding-bottom: 10px;">
			    <input type="button" class="btn btn-sm btn-light btn-active-primary" value="Search" name="searchfilters" id="searchCRMfilters"/>
		    </div>
		</div>
	    </div>
</div>
		
    <div class="col-lg-12" id="CRM_chart"></div>
	
    <div class="col-lg-12" id="INV_filters" style="margin:5px 0;">
		<div class="col-lg-12 text-right" style="margin:15px 0;">
			<a href="javascript:" id="showhidfilter" class="btn btn-sm btn-light btn-active-primary">Show / Hide Invoice Filter</a>
		</div>
		
		<div id="dashinvoicefilter" style="display:none;">
		<div class="col-lg-12 bg-white" style="padding-top: 10px;">
		<h2>Filters</h2>
		<div class="col-lg-3" style="padding-top: 10px;">
			<div class="form-group">
				<label for="datepicker" class="mb-2 mr-sm-2">Date</label>    
				<input type="text" name="created" class="form-control mb-2 mr-sm-2" id="datepicker" placeholder="Date" >
			</div>
		</div>
		<div class="col-lg-3" style="padding-top: 10px;">
			<div class="form-group">
				<label>Client</label>
				<input class="form-control col-search-input" type="text" name="buyer" value="" placeholder="Search client" autocomplete="off" />
			</div>
		</div>
		<div class="col-lg-3" style="padding-top: 10px;">
			<div class="form-group">
				<label>Phone</label>
				<input class="form-control col-search-input" type="text" name="phone" value="" placeholder="Search phone" autocomplete="off" />
			</div>
		</div>
		<div class="col-lg-3" style="padding-top: 10px;">
			<div class="form-group">
				<label>Products</label>
				<select class="form-control col-search-input" name="product"  autocomplete="on">
				<option value=''>Select</option>					
				<?php foreach($pdcats as $pdcat) {?>					
					<?php if($pdcat->parent_id == 0) {?>					    <option style="font-weight:bold" value="<?=$pdcat->id?>" disabled="disabled"><?=$pdcat->title?></option>
					<?php } else { ?>
					<option value="<?=$pdcat->id?>" ><?=$pdcat->title?></option>
					<?php } ?>					
				<?php } ?>					
				</select>
			</div>
		</div>
		<div class="col-lg-3" style="padding-top: 10px;">
			<div class="form-group">
				<label>Employees</label>
				<select class="form-control col-search-input" name="from"  autocomplete="on">
				<option value=''>Select</option>					
					<?php foreach($employees as $employee) {?>            
						<option value="<?=$employee->id?>"><?=$employee->first_name.' '.$employee->last_name?></option>
					<?php } ?>					
				</select>
			</div>
		</div>
		<div class="col-lg-3" style="padding-top: 10px;">
			<div class="form-group">
				<label>Branches</label>
				<select class="form-control col-search-input" name="branch" autocomplete="on">
				<option value=''>Select</option>					
				<?php foreach($branches as $branch) {?>					
					<option value="<?=$branch->id?>"><?=$branch->name?></option>		
				<?php } ?>					
				</select>
			</div>
		</div>
		<div class="col-lg-3" style="padding-top: 10px;">
			<div class="form-group">
				<label>Invoice Type</label>
				<select class="form-control col-search-input" name="sent" autocomplete="on">
					<option value=''>All</option>
					<option value='s'>Sent</option>
					<option value='d'>Draft</option>				
				</select>
			</div>
		</div>
		<div class="col-lg-3" style="padding-top: 10px;">
			<div class="form-group">
				<label>Senders</label>
				<select class="form-control col-search-input" name="sender"  autocomplete="on">
				<option value=''>Select</option>					
					<?php foreach($employees as $employee) {?>            
						<option value="<?=$employee->id?>"><?=$employee->first_name.' '.$employee->last_name?></option>
					<?php } ?>					
				</select>
			</div>
		</div>
		<div class="col-lg-3" style="padding-top: 10px;">
			<div class="form-group">
				<label>Project ID</label>
				<input class="form-control col-search-input" type="text" name="id" placeholder="Project number" autocomplete="off" />
			</div>
		</div>

		<div class="col-lg-12" style="padding-top: 10px;padding-bottom: 10px;">
			<input type="button" class="btn btn-sm btn-light btn-active-primary" value="Search" name="searchfilters" id="searchinvfilters"/>
		</div>
		<input type="hidden" id="datepicker1" name="date_1" value="<?=date("Y-m-d",$pastsevenday)?>" />
		<input type="hidden" id="datepicker2" name="date_2" value="<?=date("Y-m-d",$currentdate)?>" />

		<input type="hidden" id="date_CRM_1" name="date_CRM_1" value="<?=date("Y-m-d",$pastsevenday)?>" />
		<input type="hidden" id="date_CRM_2" name="date_CRM_2" value="<?=date("Y-m-d",$currentdate)?>" />

		
		</div>
		
		</div>	
	</div>
		
    <div class="col-lg-12" id="Invoice_chart"></div>
   </form> 
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



<script type="text/javascript" class="code">
    $(document).ready(function(){
		
    });
	$(window).load(function(){
		$('#datepicker').on('apply.daterangepicker', function(ev, picker) {
			$("#datepicker1").val(picker.startDate.format('YYYY-MM-DD'));
			$("#datepicker2").val(picker.endDate.format('YYYY-MM-DD'));
		});

		$('#datepicker_2').on('apply.daterangepicker', function(ev, picker) {
			$("#date_CRM_1").val(picker.startDate.format('YYYY-MM-DD'));
			$("#date_CRM_2").val(picker.endDate.format('YYYY-MM-DD'));
		});
		
		$("#showhidfilter").click(function(event){
			event.preventDefault();
			$('#dashinvoicefilter').toggle();
		});
		$("#showhidefilter").click(function(event){
			event.preventDefault();
			$('#dashCRMfilter').toggle();
		});
		
		var start = '<?=date("d/m/Y",$pastsevenday)?>';
		var end = '<?=date("d/m/Y",$currentdate)?>';		
		$('#datepicker').daterangepicker({
			startDate: start,
			endDate: end,
			autoApply: true,
			ranges: {
			   'Today': [moment(), moment()],
			   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			   'This Month': [moment().startOf('month'), moment().endOf('month')],
			   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			locale: {
				"format": "DD/MM/YYYY"
			},
			"alwaysShowCalendars": true,
		});

		var start = '<?=date("d/m/Y",$pastsevenday)?>';
		var end = '<?=date("d/m/Y",$currentdate)?>';		
		$('#datepicker_2').daterangepicker({
			startDate: start,
			endDate: end,
			autoApply: true,
			ranges: {
			   'Today': [moment(), moment()],
			   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			   'This Month': [moment().startOf('month'), moment().endOf('month')],
			   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			locale: {
				"format": "DD/MM/YYYY"
			},
			"alwaysShowCalendars": true,
		});
		
		$("#searchinvfilters").click(function(event){
			event.preventDefault();
			callAJAXchart('yes');
		});

		$("#searchCRMfilters").click(function(event){
			event.preventDefault();
			callAJAXchart('no');
		});

			
		callAJAXchart('no');
	});
	function callAJAXchart(is_invoice){
		
		var form = $('#formfilter')[0];
		var data = new FormData(form);
		//console.log(data);return false;
		$.ajax({
			url: "<?=$_cancel.'/ajaxchart'?>",
			type:'POST',
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 800000,
			success: function (response) {
				const res = JSON.parse(response);
				if(is_invoice == 'no'){
					createchart('CRM',res.CRM,res.implodedates);
				}
				createchart('Invoice',res.INVOICE,res.implodedates_inv);
			},
			error: function (e) {
				console.log("ERROR : ", e);				
			}
		});
	}
	function createchart(type,seriesdata,dates){
		Highcharts.chart(type+'_chart', {
			title: {
				text: type+" report"
			},
			subtitle: {
				text: 'Source: schildr.com'
			},
			yAxis: {
				title: {
					text: 'Count'
				}
			},
			xAxis: {
				categories: dates
			},
			tooltip: {
				formatter: function () {
					return this.points.reduce(function (s, point) {
						return s + '<br/>' + point.series.name + ': ' +
							point.y + '';
					}, '<b>' + this.x + '</b>');
				},
				shared: true
			},
			series: seriesdata,
			responsive: {
				rules: [{
					condition: {
						maxWidth: 500
					},
					chartOptions: {
						legend: {
							layout: 'horizontal',
							align: 'center',
							verticalAlign: 'bottom'
						}
					}
				}]
			},
			credits: {
				enabled: false,
			}
			
		});
	}	
</script>
<style>
    .admin-dashboard a:hover{
        text-decoration:none;
    }
</style>
