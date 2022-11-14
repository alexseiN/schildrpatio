<?php
if($objects){
    foreach($objects as $set_data){	
	
	$branch = get_langer('branches',$_thisData['admin_lang'], $set_data->branch_id);
	$status = select_status($set_data->id,$set_data->view);
	$receivedtime = branchtime($set_data->created_at,$branchs->diff,'M d,Y h:i');
	
?>
<tr>
	<td>
		<span class="fs-6"><?=$set_data->ipaddress?></span>
	</td>
	<td>
		<span class="fs-6"><?=$set_data->c_name?></span>
	</td>
	<td>
		<span class="fs-6"><?=$branch->name?></span>
	</td>
	<td>
		<span class="fs-6"><?=$set_data->c_email?></span>
	</td>
	<td>
		<span class="fs-6"><?=$set_data->c_phone?></span>
	</td>
	<td>
		<span class="fs-6"><?=$set_data->created_at?></span>
	</td>
    <td>
		<div class="d-flex justify-content-end flex-shrink-0">
            <?=$status?>
			<a href="<?=$_cancel.'/messages/'.$set_data->id?>" class="btn btn-light-success rounded-0 btnsml"><i class="fa fa-eye"></i></a>
		</div>
    </td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="7"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
