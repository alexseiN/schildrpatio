<?php
if($objects){
    foreach($objects as $set_data){
	if(!empty($set_data->image)){
	    $image = base_url('assets/uploads/employees/small').'/'.$set_data->image; 
	}
	else if(!empty($set_data->image_link)){
	    $image = $set_data->image_link;
	}
	else{
	    $image = base_url("assets/uploads/no-image.gif");
	}
	$branch = get_langer('branches',$_thisData['admin_lang'], $set_data->branch_id);
	$position = get_langer('positions',false, $set_data->position);
?>
<tr>
    <td>
	<div class="d-flex align-items-center">
	    <div class="me-5">
		<img style="height:38px" src="<?=$image?>" alt="">
	    </div>
	    <div class="d-flex justify-content-start flex-column">
		<span class="fs-6"><?=$set_data->first_name.' '.$set_data->last_name?></span>
	    </div>
	</div>
    </td>
    <td>
	<span class="fs-6"><?=$branch->name?></span>
    </td>
    <td>
	<span class="fs-6"><?=$position->title?></span>
    </td>
    <td>
	<span class="fs-6"><?=$set_data->mobile?></span>
    </td>
    <td class="text-end">
	<span class="fs-6"><?=$set_data->email?></span>
    </td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="5"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
