<?php
if($objects){
    foreach($objects as $set_data){
	$incat = get_langer('pdcats',$_thisData['admin_lang'],$set_data->incat);
	$catmain = get_langer('pdcats',$_thisData['admin_lang'],$incat->parent_id);
	if ($set_data->view) {$sentclass='bg-success';} else {$sentclass='bg-danger animation-blink';}
	if ($set_data->view == 1) {$invoice = 'checked';} else {$invoice = ' ';}
	$client = $set_data->first_name.' '.$set_data->last_name;
	$status = select_status($set_data->id,$set_data->view);
	$company = $set_data->company;
	$zipcode = $set_data->zipcode;
	$email =  $set_data->email;
	$phone =  $set_data->phone;
	


	if ($set_data->view) {$sentclass='bg-success';} else {$sentclass='bg-danger animation-blink';}

	$receivedtime = branchtime($set_data->created,$branchs->diff,'M d,Y h:i');
?>
<tr>
    <td>
	    <span class="fs-6">
	    <span class="bullet bullet-dot <?=$sentclass?> h-10px w-10px  me-3"></span>
	    <?=$client?>
	    </span>
    </td>    
    <td>
	<span class="fs-6"><?=$zipcode?></span>
    </td>
    <td>
	<span class="fs-6 "><?=$email?></span>
    </td>
    <td>
	<span class="fs-6"><?=$phone?></span>
    </td>
    <td>
	<span class="fs-6"><?=$receivedtime?></span>
    </td>
    <td>
	<div class="d-flex justify-content-end flex-shrink-0">
	    <div class="form-switch switch-sm mt-3">
		    <input type="checkbox" class="form-check-input h-20px w-30px" onclick="do_viewed(<?=$set_data->id?>)"  <?=$invoice?>/>
	    </div>
	    <a href="<?=$_cancel.'/view/'.$set_data->id?>" class="btn btn-light-success rounded-0 btnsml"><i class="fa fa-eye"></i></a>
	    <a href="<?=$_cancel.'/delete/'.$set_data->id?>" class="btn btn-light-danger rounded-0 btnsml" onclick="return confirm_box();"><i class="fa fa-trash"></i></a>
	</div>
    </td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="7"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
