<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div><div class="tools"> </div></div>
            <div class="portlet-body">
		<div class="table-responsive">
		    <table id="datatable" class="table table-striped table-bordered table-hover table-checkable no-footer">
			<thead>
			    <tr>
				<th>Id</th>
				<th>Products</th>
				<th>Employee</th>
				<th>Branch</th>
				<th>Amount</th>
				<th>Status</th>
				<th>Time</th>
			    </tr>
			    <tr>
				<td style="border-bottom: none !important;">
				    <input class="form-control col-search-input" type="text" name="ID" value="" placeholder="Search ID" autocomplete="off" />
				</td>
				<td style="border-bottom: none !important;">
				    &nbsp;
				</td>				
				<td style="border-bottom: none !important;">
				    <?php if($adminDetails->role == 'Global Admin'){ ?>
				    <select class="form-control col-search-input" name="employee" autocomplete="on">
					<option value=''>Select</option>					
					<?php foreach($allemployees as $employee) {?>					
					    <option value="<?=$employee->id?>"><?=$employee->first_name.' '.$employee->last_name?></option>		
					<?php } ?>					
				    </select>
				    <?php } else { echo '&nbsp;';  } ?>
				</td>
				<td style="border-bottom: none !important;">
				   &nbsp;
				</td>
				<td style="border-bottom: none !important;">
				   &nbsp;
				</td>
				<td style="border-bottom: none !important;">
				    <select class="form-control col-search-input" name="status" autocomplete="on">
					<option value=''>Select</option>	
					<option value="Waiting">Waiting</option>
					<option value="Preparing">Preparing</option>
					<option value="Delivered">Delivered</option>
				    </select>
				</td>
				<td style="border-bottom: none !important;">
				    &nbsp;
				</td>
			    </tr>
			</thead>
		    </table> 
		</div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="ajaxdatatableURL" value="<?php echo $_cancel.'/orderslist'?>"/>
<?= view('main/common/datatable');?>

<script>
function change_branch(id){
    var branch_id = $('#input_branch'+id).val();
    $.ajax({
	    type: "GET",
	    url: "<?=$_cancel?>/change_branch", /* The country id will be sent to this file */
	    data: {branch_id:branch_id,id:id},
	    dataType:'json',
	    success: function(response){
		location.reload();
		    if(response.status=='error'){
			    alert(response.message);
		    }
	    }
    });
}

function change_status(selfvar){
    var order_id = $(selfvar).attr('data-id');
    var status = $(selfvar).val(); 
    $.ajax({
	type: "POST",
	url: "<?=$_cancel?>/change_status", /* The country id will be sent to this file */
	data: {status:status,id:order_id},
	dataType:'json',
	success: function(response){
	    if(response.status=='success'){
		alert(response.message);
	    }
	}
    });
}
</script>
