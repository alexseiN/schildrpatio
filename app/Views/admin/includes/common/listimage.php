<?php
	foreach($files as $file) {
	$i_name = $uploadFolder.'/'.$file->filename;
?>
<div class="cursor-pointer image-input image-input-outline mb-3 mt-10 mx-3 moredivimages" id="more_image_<?=$file->id?>" data-id="<?=$file->id?>">
	<div class="image-input-wrapper w-125px h-125px" style="background-image: url('<?=$i_name?>');background-position: center;background-size: contain;"></div>
	<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow editmediaform" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-original-title="Edit" data-id="<?=$file->id?>">
		<i class="bi bi-pencil-fill fs-7"></i>
	</label>				
	<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow deletemediaform" data-bs-toggle="tooltip" title="" data-bs-original-title="Remove image" style="cursor: pointer;position: absolute;transform: translate(-50%,-50%);left: 100%;top: 100%;" data-id="<?=$file->id?>">
		<i class="bi bi-x fs-2"></i>
	</span>
</div>
<?php } ?>
