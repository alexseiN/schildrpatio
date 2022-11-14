<?php
if($objects){
    foreach($objects as $set_data){
		if ($set_data->enabled == 1) {$enabled = 'checked';} else {$enabled = ' ';}
	
		$language_data = get_admin_conn_lang($_lang_table_names,$set_data->id,$_thisData['admin_lang']);
		if(!empty($language_data)){
			$image  = !empty($set_data->image)?'assets/uploads/colors/thumbnails/'.$set_data->image:'assets/uploads/no-image.gif';
			
?>
<tr>
	<td>
		<div class="d-flex align-items-center">
			<div class="me-5">
				<img style="height:38px" src="<?=$image?>" alt="">
			</div>
			<div class="d-flex justify-content-start flex-column">
				<a href="javascript:" class="<?=(($set_data->parent_id != 0)?'text-muted':'text-dark')?> fs-6"><?=$language_data->title?></a>
			</div>
		</div>
	</td>
    <td>
		<div class="d-flex justify-content-end flex-shrink-0">
			
			<div class="form-switch switch-sm mt-3">
					<input type="checkbox" class="form-check-input h-20px w-30px" name="sect[]" onclick="do_enable(<?=$set_data->id?>)" <?=$enabled?>/>
			</div>
			<a href="<?=$_cancel.'/edit/'.$set_data->id?>" class="btn btn-light-primary rounded-0 btnsml"><i class="fa fa-edit"></i></a>
			<a href="javascript:" data-href="<?=$_cancel.'/delete/'.$set_data->id?>" class="btn btn-light-danger rounded-0 btnsml" onclick="return confirm_box(this);"><i class="fa fa-trash"></i></a>
		</div>
    </td>
</tr>
<?php } } } else{ ?>
<tr>
    <td colspan="2"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
