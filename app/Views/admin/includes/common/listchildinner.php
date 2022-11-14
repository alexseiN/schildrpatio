<label class="d-flex align-items-center fs-5 fw-bold mb-2">
			<span class="required">Choose Before/After Field</span>
			<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Select Position"></i>
		</label>
<select name="select_position_child"  data-allow-clear="true" data-control="select2" data-dropdown-parent="#changelistorderform" data-placeholder="Please select..." class="form-select form-select-solid" id="select_position_child">
		<option value="">Please select...</option>
		<?php foreach($objects_1 as $values){ ?>
			<option value="<?=$values['id']?>"><?=$values['name']?></option>
		<?php } ?>	
</select>