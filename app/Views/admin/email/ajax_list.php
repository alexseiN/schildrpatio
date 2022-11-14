<?php
if($objects){
    foreach($objects as $set_data){
		if ($set_data->enabled == 1) {$enabled = 'checked';} else {$enabled = ' ';}
?>
<tr>
	<td><span class="fs-6"><?=$set_data->name?></span></td>
    <td><span class="fs-6"><?=$set_data->receive?></span></td>
    <td>
		<div class="d-flex justify-content-end flex-shrink-0">
			
			<div class="form-switch switch-sm mt-3">
			
					<input type="checkbox" class="form-check-input h-20px w-30px me-1" name="sect[]" onclick="do_enable(<?=$set_data->id?>)" <?=$enabled?>/>
				
			</div>	
        
			<a href="<?=$_cancel.'/edit/'.$set_data->id?>" class="btn btn-light-primary rounded-0 btnsml"><i class="fa fa-edit"></i></a>
			<a href="<?=$_cancel.'/delete/'.$set_data->id?>" class="btn btn-light-danger rounded-0 btnsml" onclick="return confirm_box();"><i class="fa fa-trash"></i></a>
		</div>
    </td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="3"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
