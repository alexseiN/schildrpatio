<?php
if($objects){
    foreach($objects as $set_data){	
	$sender = get_langer('employees',false, $set_data->sender);
	$from = get_langer('employees',false, $set_data->employee);
	$product = get_langer('pdcats',$_thisData['admin_lang'], $set_data->product_category);
	if ($set_data->sendtime) {$sentclass='sent';} else {$sentclass='';}
	if ($set_data->invoice == 1) {$invoice = 'checked';} else {$invoice = ' ';}
	$branch = get_langer('branches',$_thisData['admin_lang'], $from->branch_id);
	$receivedtime = branchtime($set_data->sendtime,$branchs->diff,'M d,Y h:i');
?>
<tr>
	<td>
		<span class="text-muted fw-bold text-muted d-block fs-7"><?=$set_data->buyer?></span>
	</td>
	<td>
		<span class="text-muted fw-bold text-muted d-block fs-7"><?=$set_data->phone?></span>
	</td>
	<td>
		<span class="text-muted fw-bold text-muted d-block fs-7"><?=$product->title?></span>
	</td>
	<td>
		<span class="text-muted fw-bold text-muted d-block fs-7"><?=$from->first_name.' '.$from->last_name?></span>
	</td>
	<td>
		<span class="text-muted fw-bold text-muted d-block fs-7"><?=$branch->name?></span>
	</td>
	<td>
		<span class="text-muted fw-bold text-muted d-block fs-7"><?=$receivedtime?></span>
	</td>
	<td>
		<span class="text-muted fw-bold text-muted d-block fs-7"><?=$sender->first_name.' '.$sender->last_name?></span>
	</td>
	<td>
	    <div class="d-flex justify-content-end flex-shrink-0">
		<?php if (!$set_data->sendtime) { ?>
		    <div class="form-check form-check-sm form-check-custom form-check-solid">
			<span class="text-muted fw-bold text-muted d-block fs-7" data-row-class="sent" data-id="<?=$set_data->id?>">
			    <input class="form-check-input widget-9-check me-1" style="transform:scale(0.8)" type="checkbox" onclick="do_invoice(<?=$set_data->id?>)" <?=$invoice?> />
			</span>
		    </div>
		    
		    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" href="<?=$_cancel.'/clone/'.$set_data->id?>" onclick="return confirm_box();" title="Clone Invoice"><i class="fa fa-clone"></i></a>
		    
		    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" target="_blank" href="/en/invoice/<?=$set_data->link?>" title="View Invoice"><i class="fa fa-eye"></i></a>
		    
		    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" href="<?=$_cancel.'/edit/'.$set_data->id?>" title="Change Assgned SR and Client Details"><i class="fa fa-user"></i></a>
		    
		    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" href="<?=$_thisData['admin_link'].'/invoice/index/'.$set_data->id?>"><i class="fa fa-edit" title="Edit Invoice"></i></a>

		    <a href="<?=$_cancel.'/delete/'.$set_data->id?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" onclick="return confirm_box();"><i class="fa fa-trash"></i></a>
		    
		    <?php } else { ?>


		    <div class="form-check form-check-sm form-check-custom form-check-solid">
			<span class="text-muted fw-bold text-muted d-block fs-7" data-row-class="sent" data-id="<?=$set_data->id?>">
			    <input disabled class="form-check-input widget-9-check me-1" style="transform:scale(0.8)" type="checkbox"  <?=$invoice?> />
			</span>
		    </div>
		    
		    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" href="<?=$_cancel.'/clone/'.$set_data->id?>"onclick="return confirm_box();" title="Clone Invoice"><i class="fa fa-clone"></i></a>
		    
		    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" target="_blank" href="/en/invoice/<?=$set_data->link?>" title="View Invoice"><i class="fa fa-eye"></i></a>
		    
		    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"  href="<?=$_cancel.'/extra/'.$set_data->id?>" title="View Database"><i class="fa fa-database"></i></a>

		    <?php }  ?>
	    </div>
	</td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="8"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>              
