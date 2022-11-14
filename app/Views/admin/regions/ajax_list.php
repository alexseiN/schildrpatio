<?php
if($objects){
    foreach($objects as $set_data){
		if ($set_data->enabled == 1) {$enabled = 'checked';} else {$enabled = ' ';}
		$langs = explode(',',$set_data->selang);
		
		foreach($langs as $lang){$selang.= '<span class="badge-light-primary me-1 d-inline-block rounded-0 py-1 px-3" >'.langidtocode($lang).'</span>';}
		$language_data = get_admin_conn_lang($_lang_table_names,$set_data->id,$_thisData['admin_lang']);
        
        $selanguage = selected_items('language',false,$set_data->selang,'code');
        
    ?>
<tr>
	<td><span class="<?=(($set_data->parent_id != 0)?' ms-7 fw-bolder':'')?> fs-6"><?=$language_data->title?></span></td>
    <td><span class="fs-6"><?=$set_data->domains?></span></td>
    <td><span class="fs-6"><span class="rounded-0 d-inline-block"><?=$set_data->code?></span></span></td>
    <td><span class="fs-6"><?=$selanguage?></span></td>
    <td>
		<div class="d-flex justify-content-end flex-shrink-0 form">
		    
			
			<div class="form-switch switch-sm mt-3 ">
                    
					<input type="checkbox" class="form-check-input h-20px w-30px me-1"  name="sect[]" onclick="do_enable(<?=$set_data->id?>)" <?=$enabled?>/>
			       
			       
			</div>	
			
			
			
			
			
        
			<a href="<?=$_cancel.'/edit/'.$set_data->id?>" class="btn btn-light-primary rounded-0 btnsml"><i class="fa fa-edit"></i></a>
			<a href="javascript:" data-href="<?=$_cancel.'/delete/'.$set_data->id?>" class="btn btn-light-danger rounded-0 btnsml" onclick="return confirm_box(this);"><i class="fa fa-trash"></i></a>
		</div>
    </td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="4"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
