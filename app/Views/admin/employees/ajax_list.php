<?php
if($objects){
	foreach($objects as $set_data){
		if ($set_data->enabled == 1) {$enabled = 'checked';} else {$enabled = ' ';}

		if(!empty($set_data->image)){
			$image = base_url('assets/uploads/employees/small').'/'.$set_data->image; 
		}
		else if(!empty($set_data->image_link)){
			$image = $set_data->image_link;
		}
		else{
			$image = base_url("assets/uploads/no-image.gif");
		}
		$positions = selected_items ('positions',false,$set_data->position);
		$branchname = get_langer('branches',$_thisData['admin_lang'],$set_data->branch_id)->name;
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
	<td><span class="fs-6 text-muted"><?=$branchname?></span></td>
	<!--<td><span class="text-muted fw-bold text-muted d-block fs-7"><?php //$set_data->email ?></span></td>-->
	<td>
		<span class="fs-6">
			<?=$positions?>
		</span>		
	</td>
    <td>
		<div class="d-flex justify-content-end flex-shrink-0">
			
			<div class="form-switch switch-sm mt-3 ">
	
				
					<input type="checkbox" class="form-check-input h-20px w-30px me-1" name="sect[]" onclick="do_enable(<?=$set_data->id?>)" <?=$enabled?>/>
			
				
			</div>
        
			<a href="<?=$_cancel.'/edit/'.$set_data->id?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="fa fa-edit"></i></a>
			<a href="javascript:" data-href="<?=$_cancel.'/delete/'.$set_data->id?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" onclick="return confirm_box(this);"><i class="fa fa-trash"></i></a>
			
		</div>
    </td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="4"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
