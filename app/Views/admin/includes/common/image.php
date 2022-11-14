<div class="card card-flush py-4">
	<?php if($label != '') { ?>
	<!--begin::Card header-->
	<div class="card-header">
		<!--begin::Card title-->
		<div class="card-title">
			<h2><?=$label?></h2>
		</div>
		<!--end::Card title-->
	</div>
	<!--end::Card header-->
	<?php } ?>
	<!--begin::Card body-->
	<div class="card-body text-center pt-0">
		<div class="image-input image-input-outline mb-3 " data-kt-image-input="true" style="background-image: url('<?=$noimage?>');background-position: center;background-size: contain;">
			<div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?=$image?>);background-position: center;background-size: contain;"></div>
			<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change <?=$name?>">
				<i class="bi bi-pencil-fill fs-7"></i>
				<input type="file" name="<?=$name?>" accept=".png, .jpg, .jpeg" />
				<input type="hidden" name="<?=$name?>_remove" />
				<input type="hidden" name="previous_<?=$name?>" value="<?=$value?>"/>
			</label>
			<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel <?=$name?>">
				<i class="bi bi-x fs-2"></i>
			</span>	
			<?php if(!empty($value)){ ?>
				<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove <?=$name?>">
					<i class="bi bi-x fs-2"></i>
				</span>
			<?php } ?>
		</div>
		<div class="text-muted fs-7"><?=$description?></div>
	</div>
</div>
