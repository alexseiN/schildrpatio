<form method="post" id="global-list-form" class="form-inline" >	
	<input type="hidden" id="listurl" value="<?=$_cancel.$global_ajax_list_url?>"/>
	<input type="hidden" name="rowperpage" id="rowperpage" value="<?=$list_rows?>"/>
	<input type="hidden" id="row" name="row" value="0"/>
    <input type="hidden" id="all"  name="all" value="<?=$view_data['total_count']?>"/>
    <input type="hidden" id="c_id"  name="c_id" value="<?=(isset($c_id))?$c_id:''?>"/>
    
    <div class="card mb-5 mb-xl-8">
		<div class="card-header text-muted border-1 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bolder fs-3 mb-1"><?=$title?></span>
				<span class="text-muted mt-1 fw-bold fs-7 totalcountspan">Total <?=$view_data['total_count']?> rows</span>
			</h3>
			<div class="card-toolbar" >
			<?php if(isset($view_data['order_link'])) { $addlinkordersegment = ''; if(isset($view_data['segment_add_order'])){ $addlinkordersegment = $view_data['segment_add_order'];}?>
				<a href="javascript:" id="change_order_list" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="" data-segment-order="<?=$addlinkordersegment?>" data-bs-original-title="Change List Order" class="me-3 btn btn-light-primary rounded-0 btn-sm"><i class="fa fa-edit"></i> Change List Order</a>
			<?php } ?>

					
			<?php if($view_data['add_link']['status'] == 'yes') { ?>
				
					<a href="<?=$view_data['add_link']['link']?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-original-title="Click to add" id="<?=(isset($view_data['add_link']['id']))?$view_data['add_link']['id']:''?>" class="btn btn-light-primary rounded-0 btn-sm"><i class="fa fa-plus"></i> Add new</a>
				
			<?php } ?>

			</div>
		</div>
		<div class="card-header border-1 mb-5" id="slidetoggle" style="display:none;">
			<h3 class="flex-column">
				&nbsp;
			</h3>
			<div class="card-toolbar">
				<a href="javascript:" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-original-title="Slide left to scroll table" id="slideleft" class="mx-2 btn btn-sm btn-light btn-active-primary"><i class="fas fa-less-than"></i></a>
				<a href="javascript:" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-original-title="Slide right to scroll table" id="slideright" class="btn btn-sm btn-light btn-active-primary"><i class="fas fa-greater-than"></i></a>
			</div>
		</div>
		<div class="card-body py-3">
			<div class="table-responsive">
				<?php
					if(isset($view_data['is_main_filter'])){
						if(count($view_data['is_main_filter'])>0){
							echo '<div class="my-3"><h3>Filter</h3>'.common_html_tags("category",$view_data['is_main_filter']).'</div>';
						}
					}
				?>
				<table id="globaltable" class="table table-row-dashed align-middle gs-0 gy-1">
					<thead>
						<tr class="fw-bolder">
							<?php $counter = 1;
								foreach($view_data['columns_with_filteroptions'] as $key=>$column) {
									$classtocolumn = 'min-w-100px';
									if($counter == count($view_data['columns_with_filteroptions']) && ($key == 'Action' || $key == 'Status' || $key == 'Date & Time' || $key == 'Email')){
										$classtocolumn = 'min-w-100px text-end';
									}
									if($counter == 1 && ($key == 'ID')){
										$classtocolumn = 'max-w-30px';
									}
							?>
								<th class="<?=$classtocolumn?> pb-5"><h4><?=$key?></h4></th>
							<?php $counter++; } ?>
						</tr>
						<?php
							if($view_data['is_filter'] == 'yes'){
								
								echo '<tr class="filter filterclone" data-id="0" id="selectrowwithform">';
								foreach($view_data['columns_with_filteroptions'] as $key=>$filter_option) {
									$addstyle = '';
									if($filter_option['type'] == 'datetimerange') { 
										$addstyle = 'style="position:relative;"';
									} 
						?>
							<td <?=$addstyle?>>
								<?php
									if(count($filter_option)>0){
										echo common_html_tags($key,$filter_option);
									}
								?>
							</td>
						<?php  } echo '</tr>';  } ?>
					</thead>
					<tbody id="result-data"></tbody>
					<tfoot id="loading">
						<tr>
							<td colspan="<?=count($view_data['columns_with_filteroptions'])?>">
								<a href="javascript:" class="text-dark text-center fw-bolder text-hover-primary d-block fs-6"><img style="width:60px;" src="<?=$admin_assets?>/preload.gif"/></a>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</form>
<style>
.sent {
    background-color: #fff0f0!important;
}

.btnsml {
    width: 38px!important;
    height: 38px!important;
    padding: 8px 12px!important;
}

</style>


<!--begin::Modal - New Target-->
<div class="modal fade" id="changelistorderform" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<!--begin::Modal content-->
		<div class="modal-content rounded">
			<!--begin::Modal header-->
			<div class="modal-header pb-0 border-0 justify-content-end">
				<!--begin::Close-->
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
					<span class="svg-icon svg-icon-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
							<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
						</svg>
					</span>
					<!--end::Svg Icon-->
				</div>
				<!--end::Close-->
			</div>
			<!--begin::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15" id="changelistorderbody">				
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>
<!--end::Modal - New Target-->

<script src="<?=$admin_assets?>/js/custom/globalist.js?<?=time()?>"></script>
<script>


$(document).ready(function(){
	$("#change_order_list").click(function(){
		var tablename = '<?=$_table_names?>';
		var segment_order = $(this).attr('data-segment-order');
		$.ajax({
			type: "POST",
			url: "<?=$_cancel?>/changelistorder", /* The country id will be sent to this file */
			data:{'checktable':tablename,'segment_order':segment_order},
			cache:false,
			success: function(res){
				const datares = JSON.parse(res);
				if(datares['status'] == 'success'){
					$("#changelistorderbody").html(datares['html']);
					$("#changelistorderform").modal('show');
					$('#changelistorderbody select').select2();
				}
				else {
					alertmodal('error',data['html']);
				}
			}
		});
	});
	$(document).on('click','#changeordersave',function(){
		var data = $('#changeorderlistformsave').serializeArray();    
		$.ajax({
			type: "POST",
			url: "<?=$_cancel?>/changeordersave", /* The country id will be sent to this file */
			data: data,
			cache:false,
			success: function(response){
				const resset = JSON.parse(response);
				if(resset['status'] == 'success'){
					$("#changelistorderform").modal('hide');
					location.reload();			
				}
				else {
					alertmodal('error',data['html']);
				}
			}
		});
	});
	
});
function is_parent_check(selvar){
	var value = $(selvar).val();
	var chosenfield = $("#choose_field").val();
	
	$.ajax({
			type: "POST",
			url: "<?=$_cancel?>/checkchildlist", /* The country id will be sent to this file */
			data: {'parent_id':value,'chosenfield':chosenfield},
			cache:false,
			success: function(response){
				const responsedata = JSON.parse(response);
				if(responsedata['status'] == 'success'){
					$("#checkchilddiv").html(responsedata['html']);	
					$('#changelistorderbody select#select_position_child').select2();	
				}
				else {
					alertmodal('error',responsedata['html']);
				}
			}
		});
	
}


function change_branch(id){
        
    var branch_id = $('#input_branch'+id).val();
    


	$.ajax({
		type: "GET",
		url: "<?=$_cancel?>/change_branch", /* The country id will be sent to this file */
		data: {branch_id:branch_id,id:id},
		dataType:'json',
		success: function(response){
		    location.reload();
			if(response.status=='error'){
				alert(response.message);
			}
		}
	});
}


function change_crm_status(id){ 
        
    var status = $('#input_status'+id).val();
    
  //  alert('Status Chnaged'); 

	$.ajax({
		type: "GET",
		url: "<?=$_cancel?>/change_crm_status", /* The country id will be sent to this file */
		data: {status:status,id:id},
		dataType:'json',
		success: function(response){
		    location.reload();
			if(response.status=='error'){
				alert(response.message);
			}
		}
	});
}


function do_enable(id){
	var column = 'enabled';
	$.ajax({
		type: "GET",
		url: "<?=$_cancel?>/do_toggle", /* The country id will be sent to this file */
		data: {id:id,column:column},
		dataType:'json',
		success: function(response){
			if(response.status=='error'){
				alertmodal('error',response.message);
			}
		}
	});
}
function do_default(id){
	$.ajax({
		type: "GET",
		url: "<?=$_cancel?>/do_default", /* The country id will be sent to this file */
		data: {id:id},
		dataType:'json',
		success: function(response){
            window.location.reload();
			if(response.status=='error'){
				alertmodal('error',response.message);
			}
		}
	});
}
function do_m(id){
	$.ajax({
		type: "GET",
		url: "<?=$_cancel?>/do_m",
		data: {id:id},
		dataType:'json',
		success: function(response){   
			window.location.reload();
			if(response.status=='error'){
				alertmodal('error',response.message);
			}
		}
	});
}
function do_rm(id){
	var column = 'rm';
	$.ajax({
		type: "GET",
		url: "<?=$_cancel?>/do_toggle",
		data: {id:id,column:column},
		dataType:'json',
		success: function(response){
			window.location.reload();
			if(response.status=='error'){
				alertmodal('error',response.message);
			}
		}
	});
}
function do_quote(id){
    var column = 'quote';
	$.ajax({
		type: "GET",
		url: "<?=$_cancel?>/do_toggle",
		data: {id:id,column:column},
		dataType:'json',
		success: function(response){
			if(response.status=='error'){
				alertmodal('error',response.message);
			}
		}
	});
}

function do_viewed(id){
    var column = 'view';
	$.ajax({
		type: "GET",
		url: "<?=$_cancel?>/do_toggle",
		data: {id:id,column:column},
		dataType:'json',
		success: function(response){
			if(response.status=='error'){
				alertmodal('error',response.message);
			}
		}
	});
}

function do_invoice(id){
	var column = 'invoice';
	var curtot = parseInt($(".totik").html());
	var quotem = parseInt($(".quotik").html());
	if ($("#changer-"+id).hasClass("sent")) {    
		$(".totik").html(curtot-1);
		$(".quotik").html(quotem-1);
	} else {
		$(".totik").html(curtot+1);
		$(".quotik").html(quotem+1);
	}
    $("#changer-"+id).toggleClass("sent"); 
	$.ajax({
		type: "GET",
		url: "<?=$_cancel?>/do_toggle", /* The country id will be sent to this file */
		data: {id:id,column:column},
		dataType:'json',
		success: function(response){
			if(response.status=='error'){
				alertmodal('error',response.message);
			}
		}
	});
}
function change_status(selfvar){
    var order_id = $(selfvar).attr('data-id');
    var status = $(selfvar).val(); 
    $.ajax({
	type: "POST",
	url: "<?=$_cancel?>/change_status", /* The country id will be sent to this file */
	data: {status:status,id:order_id},
	dataType:'json',
	success: function(response){
	    if(response.status=='success'){
			alertmodal('success',response.message);
	    }
	}
    });
}
$(document).ready(function(){
	$("#addtablerow").on("click", function(){

		var dataid = $('.filterclone').last().attr('data-id');
		var index = Number(dataid) + 1;

		$( ".filterclone" ).last().find('select').select2("destroy");
		//$("#added_row"+index+" #form_input_assigned_TYPEwhere").select2("destroy");
		//$("#added_row"+index+" #form_input_type_TYPEwhere").select2("destroy");
		//$("#added_row"+index+" #form_input_status_TYPEwhere").select2("destroy");

		
		$clone = $( ".filterclone" ).last().clone( true );
		$clone.appendTo( "#globaltable thead" );
		$clone.attr('id',"added_row"+index);
		$clone.attr('data-id',index);
		$clone.children().find('input').val('');
		$clone.children().find('input').removeAttr('onkeyup');
		$clone.children().find('select').val('');
		$clone.children().find('select').removeAttr('onchange');
		$clone.children('td').first().html('');
		$clone.children('td:nth-last-child(7)').find('input').attr('placeholder','Task Title');	
		$clone.children('td:nth-last-child(2)').html('<input type="text" name="deadline" value="" class="form-control " id="" placeholder="Deadline">');
		$clone.children('td').last().html('<div class="d-flex justify-content-end flex-shrink-0"><a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 addrowtext" data-id="'+index+'" href="javascript:" title="Add Task"><i class="fa fa-plus"></i></a><a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 removerow" data-id="'+index+'" href="javascript:" title="Remove row"><i class="fa fa-trash"></i></a></div>');

		$("#added_row"+index+" select[name='by_TYPEwhere']").find('option').remove().end().append('<option value="'+loggedinuser+'">'+loggedinusername+'</option>').val(loggedinuser);

		$("#added_row"+index+" select[name='assigned_TYPEwhere']").find('option').remove().end().append(optiondata).val('');

		$clone.children('td:nth-last-child(7)').find('input').attr('name','title');
		$clone.children('td:nth-last-child(6)').find('select').attr('name','by');
		$clone.children('td:nth-last-child(5)').find('select').attr('name','assigned');
		$clone.children('td:nth-last-child(4)').find('select').attr('name','type');
		$clone.children('td:nth-last-child(3)').find('select').attr('name','status');

		
		
		

		
		$clone.children('td:nth-last-child(7)').find('input').attr('id','form_input_added_row'+index+'_title_TYPElike');
		$clone.children('td:nth-last-child(6)').find('select').attr('id','form_select_added_row'+index+'_by_TYPEwhere');
		$clone.children('td:nth-last-child(5)').find('select').attr('id','form_select_added_row'+index+'_assigned_TYPEwhere');
		$clone.children('td:nth-last-child(4)').find('select').attr('id','form_select_added_row'+index+'_type_TYPEwhere');
		$clone.children('td:nth-last-child(3)').find('select').attr('id','form_select_added_row'+index+'_status_TYPEwhere');

		$clone.children('td:nth-last-child(6)').find('select').val('');
		
		$( ".filterclone" ).find('select').select2();

		//$('#state').trigger('change.select2');
		
    });

    $(document).on("click",".removerow", function(){
		var dataid = $(this).attr('data-id');	
		var formtoget = $("#added_row"+dataid).remove();    
    });

    $(document).on("click",".addrowtext", function(){
		var dataid = $(this).attr('data-id');	
		var formtoget = $("#added_row"+dataid);
		var title = formtoget.children().find('input[name=title]').val();
		var by = formtoget.children().find('select[name=by]').val();
		var assigned = formtoget.children().find('select[name=assigned]').val();
		var type = formtoget.children().find('select[name=type]').val();
		var status = formtoget.children().find('select[name=status]').val();
		var deadline = formtoget.children().find('input[name=deadline]').val();
		$.ajax({
			type: 'POST',
			url : "<?=$_cancel.'/save_ajax'?>",
			data:{'by':by,'title':title,'assigned':assigned,'type':type,'deadline':deadline,'status':status,'explanation':''},
			cache:false,
			success: function(res){		
				getData();formtoget.remove();
			}
		});
    });
});
</script>
