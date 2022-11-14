<!--begin:Form-->
<form id="changeorderlistformsave" class="form" action="#" name="changeorderlistformsave">
	<!--begin::Heading-->
	<div class="mb-13 text-center">
		<!--begin::Title-->
		<h1 class="mb-3">Change List Order</h1>
		<!--end::Title-->
	</div>
	<!--end::Heading-->
	<!--begin::Input group-->
	<div class="d-flex flex-column mb-8 fv-row">
		<label class="d-flex align-items-center fs-5 fw-bold mb-2">
			<span class="required">Choose Field to order</span>
			<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Choose Field to order"></i>
		</label>
		<select name="choose_field" data-allow-clear="true" data-control="select2" data-dropdown-parent="#changelistorderform" data-placeholder="Please select..." class="form-select form-select-solid" id="choose_field">
			<option value="">Please select...</option>
			<?php foreach($objects_1 as $values){ ?>
				<option value="<?=$values['id']?>"><?=$values['name']?></option>
			<?php } ?>
		</select>
	</div>
	<!--end::Input group-->

	<!--begin::Input group-->
	<div class="d-flex flex-column mb-8 fv-row">
		<label class="d-flex align-items-center fs-5 fw-bold mb-2">
			<span class="required"><?=$textchoose?></span>
			<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Select Position"></i>
		</label>
		<select name="select_position" <?php if($is_parent == 1) { ?> onchange="return is_parent_check(this);" <?php } ?>  data-allow-clear="true" data-control="select2" data-dropdown-parent="#changelistorderform" data-placeholder="Please select..." class="form-select form-select-solid">
			<option value="">Please select...</option>
			<?php foreach($objects_2 as $values){ ?>
				<option value="<?=$values['id']?>"><?=$values['name']?></option>
			<?php }  ?>
		</select>		
	</div>
	<!--end::Input group-->

	<?php if($is_parent == 1) { ?>
		
	<!--begin::Input group-->
	<div class="d-flex flex-column mb-8 fv-row" id="checkchilddiv">
		
				
	</div>
	<!--end::Input group-->

	
	<?php } ?>

	
	<div class="d-flex flex-column mb-8 fv-row">
		<div class="form-check form-check-sm form-check-custom form-check-solid">
			<span class="form-label fw-bold fs-6 d-block me-5">Before : 
				<input type="radio" class="form-check-input widget-9-check me-1" checked name="action_type" value="0"/>
			</span>
			<span class="form-label fw-bold fs-6 d-block">After : 
				<input type="radio" class="form-check-input widget-9-check me-1" name="action_type" value="1"/>
			</span>
		</div>
	</div>
			
	
				
	<!--begin::Actions-->
	<div class="text-center">
		<button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Cancel</button>
		<button type="button" id="changeordersave" class="btn btn-primary">
			<span class="indicator-label">Save</span>
			<span class="indicator-progress">Please wait...
			<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
		</button>
	</div>
	<!--end::Actions-->
	<input type="hidden" value="<?=$segment_order?>" name="segment_order"/>
</form>
<!--end:Form-->

<style>
#changelistorderform .select2-container--bootstrap5 .select2-dropdown .select2-results__options{max-height: 200px !important;}

</style>
