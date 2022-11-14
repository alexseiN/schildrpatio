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
	$adminDetails = $_thisData['adminDetails'];
?>
<tr>
	<td>
		<span class="fs-6"><?=$set_data->buyer?></span>
	</td>
	<td>
		<span class="fs-6"><?=$set_data->phone?></span>
	</td>
	<td>
		<span class="fs-6"><?=$product->title?> </span>
	</td>
	<?php if($adminDetails->role == 'Global Admin'){ ?>
	<td>
		<span class="fs-6"><?=$from->first_name.' '.$from->last_name?></span>
	</td>
	<td>
		<span class="fs-6"><?=$branch->name?></span>
	</td>
	<?php } ?>
	<td>
		<span class="fs-6"><?=$receivedtime?></span>
	</td>
	<td>
		<span class="fs-6"><?=$sender->first_name.' '.$sender->last_name?></span>
		
		
		
	</td>
	<td>
	    <div class="d-flex justify-content-end flex-shrink-0">
		<?php if (!$set_data->sendtime) { ?>
		    <div class="form-switch switch-sm mt-3">
			    <input class="form-check-input h-20px w-30px" style="transform:scale(0.8)" type="checkbox" onclick="do_invoice(<?=$set_data->id?>)" <?=$invoice?> />
		    </div>
		    
		    <a class="btn btn-light-warning rounded-0 btnsml" href="javascript:" data-href="<?=$_cancel.'/clone/'.$set_data->id?>" onclick="return cloneconfirm(this);" title="Clone Invoice"><i class="fa fa-clone"></i></a>
		    
		    <a class="btn btn-light-primary rounded-0 btnsml" target="_blank" href="/en/invoice/<?=$set_data->link?>" title="View Invoice"><i class="fa fa-eye"></i></a>
		    
		    <a class="btn btn-light-success rounded-0 btnsml" href="<?=$_cancel.'/projectedit/'.$set_data->id?>" title="Change Assgned SR and Client Details"><i class="fa fa-user"></i></a>
		    
		    <a class="btn btn-light-info rounded-0 btnsml" href="<?=$_edit.'/'.$set_data->id?>"><i class="fa fa-edit" title="Edit Invoice"></i></a>

		    <a href="javascript:" data-href="<?=$_cancel.'/deleteinvoice/'.$set_data->id?>" class="btn btn-light-danger rounded-0 btnsml" onclick="return confirm_box(this);"><i class="fa fa-trash"></i></a>
		    
		    <?php } else { ?>


		    <div class="form-switch switch-sm mt-3">
			    <input disabled class="form-check-input h-20px w-30px" style="transform:scale(0.8)" type="checkbox"  <?=$invoice?> />
		    </div>
		    
		    <a class="btn btn-light-warning rounded-0 btnsml" href="javascript:" data-href="<?=$_cancel.'/clone/'.$set_data->id?>" onclick="return cloneconfirm(this);" title="Clone Invoice"><i class="fa fa-clone"></i></a>
		    
		    <a class="btn btn-light-primary rounded-0 btnsml" target="_blank" href="/en/invoice/<?=$set_data->link?>" title="View Invoice"><i class="fa fa-eye"></i></a>
		    
		    <a class="btn btn-light-dark rounded-0 btnsml"  href="<?=$_cancel.'/extra/'.$set_data->id?>" title="View Database"><i class="fa fa-database"></i></a>
		   

		    <?php }  ?>
	    </div>
	</td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="8"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>              
