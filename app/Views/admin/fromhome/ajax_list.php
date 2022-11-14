<?php
if($objects){
    foreach($objects as $set_data){
	if ($set_data->view) {$sentclass='bg-success';} else {$sentclass='bg-danger';}
	if ($set_data->view == 1) {$invoice = 'checked';} else {$invoice = ' ';}
	$from = $set_data->from;
	$zipcode = $set_data->zipcode;
	$branch = select_branches($set_data->id,$set_data->branch);
	if ($set_data->view) {$sentclass='bg-success';} else {$sentclass='bg-danger';}					
	$email = $set_data->email;
	$receivedtime = branchtime($set_data->created,$branchs->diff,'M d,Y h:i');
?>
<tr>
	<td>
		<span class="fs-6">
		    <?=$from?>
		</span>
	</td>
	<td>
		<span class="fs-6 "><?=$zipcode?></span>
	</td>
	<td>
		<?=$branch?>
	</td>
	<td>
		<span class="fs-6"><?=$email?></span>
	</td>
	<td>
		<span class="fs-6"><?=$receivedtime?></span>
	</td>
    <td>
		<div class="d-flex justify-content-end flex-shrink-0">

			<a href="javascript:" data-href="<?=$_cancel.'/delete/'.$set_data->id?>" class="btn btn-light-danger rounded-0 btnsml" onclick="return confirm_box(this);"><i class="fa fa-trash"></i></a>
		</div>
    </td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="6"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
