<?php
if($objects){
    foreach($objects as $set_data){
		if ($set_data->view) {$sentclass='bg-success';} else {$sentclass='bg-danger animation-blink';}
		if ($set_data->view == 1) {$invoice = 'checked';} else {$invoice = ' ';}
		$client = $set_data->first_name.' '.$set_data->last_name;
		$zipcode = $set_data->zipcode;
		$branch = select_branches($set_data->id,$set_data->branch_id);
		$status = select_status($set_data->id,$set_data->view);
		if ($set_data->view) {$sentclass='bg-success';} else {$sentclass='bg-danger animation-blink';}					
		$phone = $set_data->phone;
		$receivedtime = branchtime($set_data->created,$branchs->diff,'M d,Y h:i');
?>
<tr>
	<td>
		<span class="fs-6">
		    <span class="bullet bullet-dot <?=$sentclass?> h-10px w-10px me-3"></span>
		    <?=$client?>
		</span>
	</td>
	<td>
		<span class="fs-6"><?=$zipcode?></span>
	</td>
	<td>
		<?=$branch?>
	</td>
	<td>
		<span class="fs-6"><?=$phone?></span>
	</td>
	<td>
		<span class="fs-6"><?=$receivedtime?></span>
	</td>
    <td>
		<div class="d-flex justify-content-end flex-shrink-0">
			<?=$status?>
			<a href="<?=$_cancel.'/view/'.$set_data->id?>" class="btn btn-light-success rounded-0 btnsml"><i class="fa fa-eye"></i></a>
			<a href="<?=$_cancel.'/delete/'.$set_data->id?>" class="btn btn-light-danger rounded-0 btnsml" onclick="return confirm_box();"><i class="fa fa-trash"></i></a>
		</div>
    </td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="6"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
