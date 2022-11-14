<?php
if($objects){
    foreach($objects as $set_data){
	if ($set_data->status == 1) {$enabled = 'checked';} else {$enabled = ' ';}
	$i++;
?>
<tr>
    <td><span class="fs-6"><?=$set_data->ip?></span></td> 
    <td><span class="fs-6"><?=$set_data->latlong?></span></td>
    <td><span class="fs-6"><?=$set_data->branch?></span></td>
    <td><span class="fs-6"><?=$set_data->compound?></span></td>
    <td><span class="fs-6"><?=date ('F d , Y h:i',$set_data->time)?></span></td>
    <td>
        <div class="d-flex justify-content-end flex-shrink-0">
	    <div class="form-switch switch-sm mt-3">
		
		    <input type="checkbox" class="form-check-input h-20px w-30px me-1" name="sect[]" onclick="do_enable(<?=$set_data->id?>)" <?=$enabled?>/>
		    
	
	    </div>	    
	</div>
    </td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="6"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>                        

