<?php
if($objects){
    foreach($objects as $set_data){
		$language_data = get_admin_conn_lang($_lang_table_names,$set_data->id,$_thisData['admin_lang']);
		if(!empty($language_data)){
						
?>
<tr>
	<td>
		<div class="d-flex align-items-center">
			<div class="symbol symbol-45px me-5">
				<span class="text-muted fw-bold text-muted d-block fs-7"><span class="badge badge-info"><?=$set_data->template?></span></span>
			</div>
			<div class="d-flex justify-content-start flex-column">
				<a href="javascript:" class="text-dark fw-bolder text-hover-primary fs-6"><?=word_limiter($language_data->title,4)?></a>
			</div>
		</div>
	</td>
	<td>
	
	</td>
    <td>
		<div class="d-flex justify-content-end flex-shrink-0">
			<a href="<?=$_cancel.'/edit/'.$set_data->category_id.'/'.$set_data->id?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="fa fa-edit"></i></a>
			<a href="javascript:" data-href="<?=$_cancel.'/delete/'.$set_data->category_id.'/'.$set_data->id?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" onclick="return confirm_box(this);"><i class="fa fa-trash"></i></a>
		</div>
    </td>
</tr>
<?php } } } else{ ?>
<tr>
    <td colspan="2"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
