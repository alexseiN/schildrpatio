<?php
if($objects){
    foreach($objects as $set_data){
		if ($set_data->enabled == 1) {$enabled = 'checked';} else {$enabled = ' ';}
		if(!empty($set_data->image)){
			$image = base_url('assets/uploads/socials/small').'/'.$set_data->image;
		}
		else if(!empty($set_data->image_link)){
			$image = $set_data->image_link;
		}
		else{
			$image = base_url("assets/uploads/no-image.gif");
		}
?>
<tr>
	<td><span class="fs-6"><?=$set_data->name?></span></td>
    <td>
		<div class="">
			<div class="me-5">
				<img style="height:38px" src="<?=$image?>" alt="<?=$set_data->name?>">
			</div>
		</div>
	</td>
    <td><span class="fs-6"><?=$set_data->link?></span></td>
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
    <td colspan="4"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
