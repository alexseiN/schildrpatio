<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
			<?=form_open_multipart('', 'class="form d-flex flex-column flex-lg-row filter_form" id="filter_form" name="filter_form"')?>
			<!--begin::Aside column-->
			<div class="d-flex flex-column gap-7 gap-lg-10 w-300px w-lg-300px mb-7 me-lg-10" style="min-width: 20%;">
				<div class="card card-flush py-4">
					<div class="card-header">
						<div class="card-title">
							<h2>Filters</h2>
						</div>
					</div>
					<div class="card-body pt-0">
						<div class="mb-10 fv-row">             
							<?php
								$coptions[''] = 'Please Select';
								foreach($all_categories as $all_category){
									$coptions[$all_category->id] = $all_category->title;
								}                                 
								$data = [
									"label"          => "Category",
									"label_required" => "",
									"type"           => "select",
									"type_data"      => [
										'name'  => 'filter_category',
										'options'  => $coptions,
										'value' => '',
									]
								];
								echo '<label class="form-label fw-bold fs-6" style=""><span class="">Category</span></label>';
								echo form_dropdown($data['type_data']['name'], $data['type_data']['options'], $data['type_data']['value'] ,' id="filter_category" aria-label="Please select" data-allow-clear="true" data-control="select2" data-placeholder="Please select..." onchange="return getData()" class="form-select form-select-solid form-select-lg fw-bold" ');
							?>
						</div>
						<div class="mb-10 fv-row">             
							<?php
								$soptions[''] = 'Please Select';
								foreach($all_sizes as $sizes){
									$soptions[$sizes->id] = $sizes->title;
								}                                 
								$data = [
									"label"          => "Size",
									"label_required" => "",
									"type"           => "select",
									"type_data"      => [
										'name'  => 'filter_size',
										'options'  => $soptions,
										'value' => '',
									]
								];
								echo '<label class="form-label fw-bold fs-6" style=""><span class="">Size</span></label>';
								echo form_dropdown($data['type_data']['name'], $data['type_data']['options'], $data['type_data']['value'] ,' id="filter_size" aria-label="Please select" data-allow-clear="true" data-control="select2" data-placeholder="Please select..." onchange="return getData()" class="form-select form-select-solid form-select-lg fw-bold" ');
							?>
						</div>
						<div class="mb-10 fv-row">             
							<?php
								$ccoptions[''] = 'Please Select';
								foreach($all_colors as $colors){
									$ccoptions[$colors->id] = $colors->title;
								}                                 
								$data = [
									"label"          => "Color",
									"label_required" => "",
									"type"           => "select",
									"type_data"      => [
										'name'  => 'filter_color',
										'options'  => $ccoptions,
										'value' => '',
									]
								];
								echo '<label class="form-label fw-bold fs-6" style=""><span class="">Color</span></label>';
								echo form_dropdown($data['type_data']['name'], $data['type_data']['options'], $data['type_data']['value'] ,' id="filter_color" aria-label="Please select" data-allow-clear="true" data-control="select2" data-placeholder="Please select..." onchange="return getData()" class="form-select form-select-solid form-select-lg fw-bold" ');
							?>
						</div>
					</div>
				</div>
			</div>
			<!--end::Aside column-->
			
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">    
				<div class="card">
					<!--begin::Body-->
					<div class="card-body p-lg-10">

						<div class="mb-3">
							<div class="d-flex flex-stack mb-5">
								<h2>Store</h2>
								<a href="javascript:" class="fs-6 fw-bold btn btn-sm btn-light-primary cartitems"></a>
							</div>
							<div class="separator separator-dashed mb-9"></div>
						</div>
						<div class="mb-17">

							
							<div class="row g-10" id="result-data">
							</div>
						</div>
					</div>
				</div>
			</div>
		<?=form_close()?>
        </div>
    </div>
</div>
<input type="hidden" name="size_product_id" id="size_product_id" value="0">
<input type="hidden" name="color_product_id" id="color_product_id" value="0">
<input type="hidden" name="varient_avail_quntity" id="varient_avail_quntity" value="0">
<input type="hidden" name="total_varient" id="total_varient" value="2">
<input type="hidden" name="main_product_id" id="main_product_id" value="0">
<?=view('main/common/addtocart')?>

<script type="text/javascript">
	
$(document).ready(function() {
	getData();
});
function getData(){
    var data = $('#filter_form').serialize(); 
    $.ajax({
		type: 'POST',
		url : "<?=$_cancel.'/ajax_list'?>",
		data:data,
		success: function(data){
			$('#result-data').html(data);
			setTimeout(function(){ // just being safe
                   $('.carousel').carousel();
               },20);		
		}
	});
}

</script>