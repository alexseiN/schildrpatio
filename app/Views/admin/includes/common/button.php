<div class="d-flex justify-content-end">
	<?php if($_table_names == 'bsections' || $_table_names == 'features' || $_table_names == 'sections') { $R_url = $_return_url; } else {$R_url = $_cancel;} ?>
	<?=anchor($R_url, 'Cancel', ['id' => 'kt_modal_new_target_cancel', 'name' => '', 'rel' => '', 'class' => 'btn btn-light me-5']);?>
	
	<?php
		$data = [
			"label"          => "",
			"label_required" => "",
			"type"           => "button",
			"type_data"      => [
				'id'      => 'kt_submit',
				'type'    => 'submit',
				'content' => 'Save Changes',
				'class'   => 'btn btn-primary'
			]
		];
		echo html_form_tags($data);
	?>
</div>