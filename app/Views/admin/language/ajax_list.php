<?php
if($objects){
    foreach($objects as $set_data){
		if ($set_data->enabled == 1) {$enabled = 'checked';} else {$enabled = ' ';}
        if ($set_data->default == 1) {$default = 'checked';} else {$default = ' ';}
?>
<tr>
    <td>
		<div class="d-flex align-items-center">
			<div class="me-5">
				<img style="width:30px" src="assets/uploads/language/full/<?=$set_data->image?>" alt="">
			</div>
		</div>
    </td> 
    <td><span class="fs-6 "><?=$set_data->language?></span></td>
    <td><span class="fs-6 "><?=$set_data->code?></span></td>
    <td>
		<div class="d-flex justify-content-end flex-shrink-0">
			
			<div class="form-switch switch-sm mt-3">
			
					<input type="checkbox" class="form-check-input h-20px w-30px me-1" name="sect[]" onclick="do_default(<?=$set_data->id?>)" <?=$default?>>
			
			</div>
			
			<div class="form-switch switch-sm mt-3">
				 
					<input type="checkbox" class="form-check-input h-20px w-30px me-1" name="sect[]" onclick="do_enable(<?=$set_data->id?>)" <?=$enabled?>/>
			
			</div>	
        
			<a href="<?=$_cancel.'/edit/'.$set_data->id?>" class="btn btn-light-primary rounded-0 btnsml"><i class="fa fa-edit"></i></a>
			<a href="javascript:" data-href="<?=$_cancel.'/delete/'.$set_data->id?>" class="btn btn-light-danger rounded-0 btnsml" onclick="return confirm_box(this);"><i class="fa fa-trash"></i></a>
		</div>
    </td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="4"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
