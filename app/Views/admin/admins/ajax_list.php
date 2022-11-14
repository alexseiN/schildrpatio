<?php
if($objects){
    foreach($objects as $set_data){	
?>
<tr>
	<td>
		<span class="fs-6"><?=$set_data->username?></span>
	</td>
	<td>
	    <div class="d-flex justify-content-end flex-shrink-0">
		    <a class="btn btn-light-primary rounded-0 btnsml" href="<?=$_cancel.'/edit/'.$set_data->id?>"><i class="fa fa-edit"></i></a>
		    <a href="javascript:" data-href="<?=$_cancel.'/delete/'.$set_data->id?>" class="btn btn-light-danger rounded-0 btnsml" onclick="return confirm_box(this);"><i class="fa fa-trash"></i></a>
	    </div>
	</td>
</tr>
<?php } } else{ ?>
<tr>
    <td colspan="2"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>              
