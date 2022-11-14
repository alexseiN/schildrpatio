<?php
//error_reporting(0);
$loggedinuseremp = $adminDetails->employee_id;
$thisEmployee = get_langer('employees',false,$loggedinuseremp);
$thisbranch = get_langer('branches',$admin_lang,$thisEmployee->branch_id);          
//$where_1 = array('parent_id'=>0,'sendtime<>'=>0);
$where_1 = array('parent_id'=>0);
$where_2 = array();
$where_3 = array();
if ($adminDetails->role == 'Branch Admin') {
    $where_1['employee'] = $loggedinuseremp;
    $where_2['branch_id'] = $thisbranch->id;
}

$sentInvoices = print_count('setproject',$where_1);
$quotes = print_count('quotes',$where_2);
$employeescount = print_count('employees',$where_3);
$employees = get_table_where('employees',false);

if ($adminDetails->role == 'Branch Admin') {
    $activitydata['where'] = array("employee"=>$loggedinuseremp);
}
else {
    $activitydata['where'] = array();
}

$activitydata['order'] = 'created DESC';
$activitydata['is_count'] = false;
$activitydata['rowperpage'] = 6;
$activitydata['row'] = 0;
$activitylogs = activitylogs($activitydata,'fetch');
$statusdata = getarray('status');

?>
<style>
    .bg-discussion,.badge-light-discussion{background-color:#f7d6f6;color:#cf33ca}
    .bg-urgent, .badge-light-urgent {background-color: #bfbf1c;color: yellow;}
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
      <!--begin::Row-->
      <div class="row gy-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-xl-4">
          <!--begin::Mixed Widget 2-->
          <div class="card card-xl-stretch">
            <!--begin::Header-->
            <div class="card-header border-0 bg-danger py-5">
              <h3 class="card-title fw-bolder text-white">Analytics</h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body p-0">
              <!--begin::Chart-->
              <div class="mixed-widget-2-chart card-rounded-bottom bg-danger" data-kt-color="danger" style="height:50px"></div>
              <!--end::Chart-->
              <!--begin::Stats-->
              <div class="card-p mt-n20 position-relative" style="padding:3rem 1.25rem !important;">
                <!--begin::Row-->
                <div class="row g-0">
                  <!--begin::Col-->
                  <div class="col bg-light-warning px-6 py-8 rounded-2 me-7 mb-7">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                    <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                      <i class="fas fa-glasses p-3 fs-1 text-warning"></i>
                    </span>
                    <!--end::Svg Icon-->
                    <a href="javascript:" class="text-warning fw-bold fs-6">Website visit<br><span class="fw-bolder text-warning-500"><?=number_format(ipinfo())?></span></a>
                  </div>
                  <!--end::Col-->
                  <!--begin::Col-->
                  <div class="col bg-light-primary px-6 py-8 rounded-2 mb-7">
                    <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                    <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                      <i class="fas fa-file-invoice p-3 fs-1 text-primary"></i>
                    </span>
                    <!--end::Svg Icon-->
                    <a href="<?php echo $admin_link.'/invoice';?>" class="text-primary fw-bold fs-6">Invoice<br><span class="fw-bolder text-primary-500"><?=number_format($sentInvoices)?></span></a>
                  </div>
                  <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row g-0">
                  <!--begin::Col-->
                  <div class="col bg-light-danger px-6 py-8 rounded-2 me-7">
                    <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                    <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                      <i class="fas fa-quote-left p-3 fs-1 text-danger"></i>
                    </span>
                    <!--end::Svg Icon-->
                    <a href="<?php echo $admin_link.'/quotes';?>" class="text-danger fw-bold fs-6 mt-2">Quotes<br><span class="fw-bolder text-danger-500"><?=number_format($quotes)?></span></a>
                  </div>
                  <!--end::Col-->
                  <!--begin::Col-->
                  <div class="col bg-light-success px-6 py-8 rounded-2">
                    <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                    <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                      <i class="fas fa-users p-3 fs-1 text-success"></i>
                    </span>
                    <!--end::Svg Icon-->
                    <a href="<?php if ($adminDetails->role == 'Global Admin') { echo $admin_link.'/employees'; } else {echo 'manage/staf';} ?>" class="text-success fw-bold fs-6 mt-2">Employees<br><span class="fw-bolder text-success-500"><?=number_format($employeescount)?></span></a>
                  </div>
                  <!--end::Col-->
                </div>
                <!--end::Row-->
              </div>
              <!--end::Stats-->
            </div>
            <!--end::Body-->
          </div>
          <!--end::Mixed Widget 2-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xl-4">
          <!--begin::List Widget 5-->
          <div class="card card-xl-stretch">
            <!--begin::Header-->
            <div class="card-header align-items-center border-0 mt-0">
              <h3 class="card-title align-items-start flex-column">
                <span class="fw-bolder mb-2 text-dark">Activities</span>
              </h3>
              <div class="card-toolbar">
                <!--begin::Menu-->
                <a href="<?=$_activitieslink?>" class="btn btn-sm btn-icon btn-color-primary btn-light-primary">
                  <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                  <span class="svg-icon svg-icon-2">
                    <i class="fas fa-eye"></i>
                  </span>
                  <!--end::Svg Icon-->
                </a>
                <!--end::Menu-->
              </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5">
              <!--begin::Timeline-->
              <div class="timeline-label">
		<?php if(count($activitylogs)>0){
		    $counter = 1;
		    foreach($activitylogs as $log) {
			if($counter % 4 == 0){   
			    $textcolor = 'primary';
			}
			else if($counter % 3 == 0){   
			    $textcolor = 'danger';
			}
			else if($counter % 2 == 0){   
			    $textcolor = 'success';
			}
			else {
			    $textcolor = 'warning';
			}
			$empname = '';
			
			if ($adminDetails->role == 'Global Admin') {
			    if($loggedinuseremp == $log->employee){
				$empname = ' - by <b>you</b>.';
			    } else {
				$empdetails = get_langer('employees',false,$log->employee);
				$empname = ' - by <b>'.$empdetails->first_name.' '.$empdetails->last_name.'</b>.';
			    }
			}
		?>  
                <!--begin::Item-->
                <div class="timeline-item">
                  <!--begin::Label-->
                  <div class="timeline-label fw-bolder text-gray-800 fs-6"><?=date("H:i",strtotime($log->created))?></div>
                  <!--end::Label-->
                  <!--begin::Badge-->
                  <div class="timeline-badge">
                    <i class="fa fa-genderless text-<?=$textcolor?> fs-1"></i>
                  </div>
                  <!--end::Badge-->
                  <!--begin::Text-->
                  <div class="fw-mormal timeline-content text-muted ps-3"><?=$log->d_action.$empname?></div>
                  <!--end::Text-->
                </div>
                <!--end::Item-->
		<?php $counter++; } } ?>
              </div>
              <!--end::Timeline-->
            </div>
            <!--end: Card Body-->
          </div>
          <!--end: List Widget 5-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xl-4">
          <!--begin::List Widget 3-->
          <div class="card card-xl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0">
              <h3 class="card-title fw-bolder text-dark">Tasks</h3>
              <div class="card-toolbar">
                <!--begin::Menu-->
                <a href="<?=$admin_link.'/tasks'?>" class="btn btn-sm btn-icon btn-color-primary btn-light-primary">
                  <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                  <span class="svg-icon svg-icon-2">
                    <i class="fas fa-eye"></i>
                  </span>
                  <!--end::Svg Icon-->
                </a>
                <!--end::Menu-->
                <!--end::Menu-->
              </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-2">
		
	      <?php if(count($gettasks)>0){
		    $counter = 1;
		    foreach($gettasks as $tasks) {
			if($tasks->status == 'waiting'){   
			    $textcolor = 'danger';
			}
			else if($tasks->status == 'started'){   
			    $textcolor = 'warning';
			}
			else if($tasks->status == 'problem'){   
			    $textcolor = 'danger';
			}
			else if($tasks->status == 'discussion'){   
			    $textcolor = 'discussion'; //#f7d6f6
			}
			else if($tasks->status == 'urgent'){   
			    $textcolor = 'urgent'; //yellow
			}
			else if($tasks->status == 'completed'){   
			    $textcolor = 'success';
			}
		?>
              <!--begin::Item-->
              <div class="d-flex align-items-center mb-8">
                <!--begin::Bullet-->
                <span class="bullet bullet-vertical h-40px bg-<?=$textcolor?> me-5"></span>
                <!--end::Bullet-->
                <!--begin::Description-->
                <div class="flex-grow-1">
                  <a href="<?=$admin_link.'/tasks/edit/'.$tasks->id?>" class="text-gray-800 text-hover-primary fw-bolder fs-6"><?=readmorestring($tasks->title,'','35')?></a>
                </div>
                <!--end::Description-->
                <span class="badge badge-light-<?=$textcolor?> fs-8 fw-bolder"><?=$statusdata[$tasks->status]?></span>
              </div>
              <!--end:Item-->
	      <?php $counter++; } } ?>
            </div>
            <!--end::Body-->
          </div>
          <!--end:List Widget 3-->
        </div>
        <!--end::Col-->
      </div>
      <!--end::Row-->
      <!--end::Row-->
	<form method="POST" id="formfilter">
	    <div class="card">									
		<div class="card-header border-0">
		    <h2 class="card-title fw-bolder text-gray-900">CRM Report</h2>
		    <div class="card-toolbar">
			<button class="btn btn-sm btn-light btn-active-primary" id="showhidefilter">
			    <i class="fa fa-filter"></i> Filter
			</button>
		    </div>
		</div>             
		<div class="card-body">
		    <div id="dashCRMfilter" class="col-lg-12  mb-10" style="display:none;">
			<div class="row row-cols-lg-1 g-10 py-10 pt-2">
			    <h2 class="mt-2">Filters</h2>
			    <div class="col">
				<div class="fv-row">
				    <label for="datepicker_2" class="fs-6 fw-bold mb-2">Date</label>    
				    <input type="text" name="datepicker_2" class="form-control form-control-solid flatpickr-input" id="datepicker_2" placeholder="Date" >
				</div>
			    </div>
			</div>
			<input type="button" class="btn btn-sm btn-light btn-active-primary" value="Search" name="searchfilters" id="searchCRMfilters"/>
		    </div>
		    <div class="col-lg-12" id="CRM_chart"></div>
		</div>                
	    </div>
	    <div class="card my-10">									
		<div class="card-header border-0">
		    <h2 class="card-title fw-bolder text-gray-900">Invoice Report</h2>
		    <div class="card-toolbar">
			<button class="btn btn-sm btn-light btn-active-primary" id="showhidfilter">
			    <i class="fa fa-filter"></i> Filter
			</button>
		    </div>
		</div>             
		<div class="card-body">
		    <div id="dashinvoicefilter" class="mb-10" style="display:none;">
			<h2 class="mt-2">Filters</h2>
			<div class="row row-cols-lg-4 g-10 py-10 pt-2">
			    <div class="col">
				<div class="fv-row">
				    <label for="datepicker" class="fs-6 fw-bold mb-2">Date</label>    
				    <input type="text" name="created" class="form-control form-control-solid flatpickr-input" id="datepicker" placeholder="Date" >
				</div>
			    </div>
			    <div class="col">
				<div class="fv-row">
				    <label class="fs-6 fw-bold mb-2">Client</label>
				    <input class="form-control form-control-solid flatpickr-input" type="text" name="buyer" value="" placeholder="Search client" autocomplete="off" />
				</div>
			    </div>
			    <div class="col">
				<div class="fv-row">
				    <label class="fs-6 fw-bold mb-2">Phone</label>
				    <input class="form-control form-control-solid flatpickr-input" type="text" name="phone" value="" placeholder="Search phone" autocomplete="off" />
				</div>
			    </div>
			    <div class="col">
				<div class="fv-row">
				    <label class="fs-6 fw-bold mb-2">Products</label>
				    <select data-control="select2" data-placeholder="Please select" class="form-select form-select form-select-solid" name="product"  autocomplete="on">
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
			    <div class="col">
				<div class="fv-row">
				    <label class="fs-6 fw-bold mb-2">Employees</label>
				    <select data-control="select2" data-placeholder="Please select" class="form-select form-select form-select-solid" name="from"  autocomplete="on">
				    <option value=''>Select</option>					
					<?php foreach($employees as $employee) {?>            
					    <option value="<?=$employee->id?>"><?=$employee->first_name.' '.$employee->last_name?></option>
					<?php } ?>					
				    </select>
				</div>
			    </div>
			    <div class="col">
				<div class="fv-row">
				    <label class="fs-6 fw-bold mb-2">Branches</label>
				    <select data-control="select2" data-placeholder="Please select" class="form-select form-select form-select-solid" name="branch" autocomplete="on">
				    <option value=''>Select</option>					
				    <?php foreach($branches as $branch) {?>					
					<option value="<?=$branch->id?>"><?=$branch->name?></option>		
				    <?php } ?>					
				    </select>
				</div>
			    </div>
			    <div class="col">
				<div class="fv-row">
				    <label class="fs-6 fw-bold mb-2">Invoice Type</label>
				    <select data-control="select2" data-placeholder="Please select" class="form-select form-select form-select-solid" name="sent" autocomplete="on">
					<option value=''>All</option>
					<option value='s'>Sent</option>
					<option value='d'>Draft</option>				
				    </select>
				</div>
			    </div>
			    <div class="col">
				<div class="fv-row">
				    <label class="fs-6 fw-bold mb-2">Senders</label>
				    <select data-control="select2" data-placeholder="Please select" class="form-select form-select form-select-solid" name="sender"  autocomplete="on">
				    <option value=''>Select</option>					
					<?php foreach($employees as $employee) {?>            
					    <option value="<?=$employee->id?>"><?=$employee->first_name.' '.$employee->last_name?></option>
					<?php } ?>					
				    </select>
				</div>
			    </div>
			    <div class="col">
				<div class="fv-row">
				    <label class="fs-6 fw-bold mb-2">Project ID</label>
				    <input class="form-control form-control-solid flatpickr-input" type="text" name="id" placeholder="Project number" autocomplete="off" />
				</div>
			    </div>
			</div>
			<input type="button" class="btn btn-sm btn-light btn-active-primary" value="Search" name="searchfilters" id="searchinvfilters"/>
		    </div>
		    <div class="col-lg-12" id="Invoice_chart"></div>
		</div>                
	    </div>
	    <input type="hidden" id="datepicker1" name="date_1" value="<?=date("Y-m-d",$pastsevenday)?>" />
	    <input type="hidden" id="datepicker2" name="date_2" value="<?=date("Y-m-d",$currentdate)?>" />
	    <input type="hidden" id="date_CRM_1" name="date_CRM_1" value="<?=date("Y-m-d",$pastsevenday)?>" />
	    <input type="hidden" id="date_CRM_2" name="date_CRM_2" value="<?=date("Y-m-d",$currentdate)?>" />
	</form>
    </div>
    
    
    
    
  </div>
  
  
</div>


<!--end::Content-->
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

			
		callAJAXchart('no',false);
	});
	function callAJAXchart(is_invoice,is_global=true){
		
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
			global:is_global,
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

	    <?php if($adminDetails->theme_appearence == 1){ ?>

	
		Highcharts.chart(type+'_chart', {
		    chart: {
        backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
            stops: [
                [0, '#1e1e2d'],
                [1, '#1e1e2d']
            ]
        },
        style: {
            fontFamily: '\'Unica One\', sans-serif'
        },
        plotBorderColor: '#606063'
    },
			title: {
				text: "",
				style: {
        display: 'none'
    }
			},
			subtitle: {
				text: '',
				style: {
        display: 'none'
    }
			},
			yAxis: {
			    labels: {
            style: {
                color: '#ffffff'
            }
        },
				title: {
					text: 'Count'
				}
			},
			xAxis: {
			    labels: {
            style: {
                color: '#ffffff'
            }
        },
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
			},
			legend: {
        
        itemStyle: {
            color: '#E0E0E3'
        },
        itemHoverStyle: {
            color: '#FFF'
        },
        itemHiddenStyle: {
            color: '#606063'
        },
        title: {
            style: {
                color: '#C0C0C0'
            }
        }
    }
			
		});

		<?php }  else { ?>
		    Highcharts.chart(type+'_chart', {
			title: {
				text: "",
				style: {
        display: 'none'
    }
			},
			subtitle: {
				text: '',
				style: {
        display: 'none'
    }
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
		<?php } ?>
	}	
</script>