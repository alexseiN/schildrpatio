<?php
if($objects){
    foreach($objects as $set_data){
        $productarrayexplode = explode(",",$set_data->products);
		$product_name_array = array();
		foreach($productarrayexplode as $products) {
		    $productexplode = explode("-",$products);
		    $product_id = $productexplode[0];
		    
		    $size_id = $productexplode[1];
		    $color_id = $productexplode[2];
			
		    $product_result = getDatam2('locproducts',array("id"=>$product_id),$_thisData['admin_lang'],false,'id',false);
		    $variation_result = getDatam2('locsize',array("id"=>$size_id),$_thisData['admin_lang'],false,'id',false);
		    $variation_result_2 = getDatam2('loccolor',array("id"=>$color_id),$_thisData['admin_lang'],false,'id',false);
		    
		    $product_name_array[] = $product_result[0]->title.' ( '.$variation_result[0]->title.' ) '.' ( '.$variation_result_2[0]->title.' ) ';
		}
		
		$thisemployee = get_by('employees', array('id'=>$set_data->ordered_user), FALSE, FALSE, true);
		$branchs = get_langer('branches',$_thisData['admin_lang'], $thisemployee->branch_id);
		$showproducts = implode("<br>",$product_name_array);
		$branch = $branchs->name;
		$phone = $set_data->phone;
		$receivedtime = branchtime($set_data->created,$branchs->diff,'M d,Y h:i');
		$status = '<select class="form-control col-search-input" data-id="'.$set_data->id.'" onchange="return change_status(this)" name="status" autocomplete="on"><option value="Waiting" '.($set_data->status == 'Waiting'?'selected':'').'>Waiting</option><option value="Preparing" '.($set_data->status == 'Preparing'?'selected':'').'>Preparing</option><option value="Delivered" '.($set_data->status == 'Delivered'?'selected':'').'>Delivered</option></select>';		

?>
<tr>    
    <td><span class="fs-6"><?=$set_data->id?></span></td>
    <td>
        <span class="fs-6"><?=$showproducts?></span>
    </td>  
    <td><span class="fs-6"><?=$thisemployee->first_name.' '.$thisemployee->last_name?></span></td>
    <td><span class="fs-6"><?=$branch?></span></td>
    <td><span class="fs-6"><?=front_format_currency_helper($set_data->total_amount)?></span></td>
    <td>
        <?=$status?>
    </td>
    <td><span class="fs-6"><?=$receivedtime?></span></td>   
    
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="7"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>        

