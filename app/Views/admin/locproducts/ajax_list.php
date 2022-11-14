<?php
if($objects){
    foreach($objects as $set_data){
	if ($set_data->enabled == 1) {$enabled = 'checked';} else {$enabled = ' ';}
	$language_data = get_admin_conn_lang($_lang_table_names,$set_data->id,$_thisData['admin_lang']);
	if(!empty($language_data)){
	    $secats = selected_items ('loccats',$_thisData['admin_lang'],$set_data->category);
	    $genders = selected_items ('loccolor',$_thisData['admin_lang'],$set_data->colors);
	    $morefiles = morefiles('locproducts',$set_data->id);
	    if ($set_data->enabled == 1) {$enabled = 'checked';} else {$enabled = ' ';}
?>
<tr>    
    
    <td>
        <div class="me-5">
			<?=$set_data->code?>
		</div>
    </td>
    <td>
        <div class="me-5">
			<img style="height:38px" src="assets/uploads/locproducts/<?=$morefiles[0]->filename?>" alt="">
		</div>
    </td>
    <td>
	<div class="d-flex align-items-center">
		
		<div class="d-flex justify-content-start flex-column">
			<span class="fs-6"><?=$language_data->title?></span>
		</div>
	</div>
    </td>  
    <td><span class="fs-6"><?=$secats?></span></td>
    <td><span class="fs-6"><?=$genders?></span></td>
    <td><span class="fs-6"><?=front_format_currency_helper($set_data->nprice)?></span></td>   
    <td>
	<div class="d-flex justify-content-end flex-shrink-0">
	    <div class="form-switch switch-sm mt-3">
		    <input type="checkbox" class="form-check-input h-20px w-30px" name="sect[]" onclick="do_enable(<?=$set_data->id?>)" <?=$enabled?>/>
	    </div>
	    
	    <a class="btn btn-light-success rounded-0 btnsml" href="<?=$_cancel.'/productview/'.$set_data->id?>" title="View Product"><i class="fa fa-eye"></i></a>
	    <a class="btn btn-light-primary rounded-0 btnsml" href="<?=$_cancel.'/edit/'.$set_data->id?>" title="View Invoice"><i class="fa fa-edit"></i></a>
	    <a class="btn btn-light-danger rounded-0 btnsml"  href="<?=$_cancel.'/delete/'.$set_data->id?>"  onclick="return confirm_box();" title="Delete"><i class="fa fa-trash"></i></a>
       </div>
    </td>    
</tr>
<?php } } } else{ ?>
<tr>
    <td colspan="6"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
