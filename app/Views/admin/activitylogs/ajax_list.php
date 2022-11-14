<?php
if($objects){
	$loggedinuseremp = $_thisData['adminDetails']->employee_id;
    foreach($objects as $set_data){

		if ($_thisData['adminDetails']->role == 'Global Admin') {
			if($loggedinuseremp == $set_data->employee){
				$empname = ' - by <b>you</b>.';
			}
			else {
				$empdetails = get_langer('employees',false,$set_data->employee);
				$empname = ' - by <b>'.$empdetails->first_name.' '.$empdetails->last_name.'</b>.';
			}
		}
		//$branch = get_langer('branches',$_thisData['admin_lang'], $from->branch_id);
		$receivedtime = branchtime(strtotime($set_data->created),$branchs->diff,'M d,Y h:i');
			
?>
<tr>
	<td>
		<span class="fs-6">
		    <?=$set_data->d_action.$empname?>
		</span>
	</td>
    <td class="text-end"><span class="fs-6">
		    <?=$receivedtime?>
		</span>
	
		<!--<div class="d-flex justify-content-end flex-shrink-0">
			<a href="javascript:" data-href="<?=$_cancel.'/delete/'.$set_data->id?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" onclick="return confirm_box(this);"><i class="fa fa-trash"></i></a>
		</div>-->
    </td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="2"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
