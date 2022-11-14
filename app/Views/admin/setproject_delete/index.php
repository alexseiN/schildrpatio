<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div><div class="tools"> </div></div>
            <div class="portlet-body">
		<div class="btn-group">
		    <a href="<?=$_cancel?>/edit" class="btn btn-primary m-r-5 m-b-5">
			Add New <i class="fa fa-plus"></i>
		    </a>
		</div>
		<hr>
	
		<div class="table-responsive">
		    <table id="datatable" class="table table-striped table-bordered table-hover table-checkable no-footer">
			<thead>
			    <tr>
					<th style="width:190px;">Client Fullname</th>
					<th style="width:190px;">Client Phone</th>
					<th style="width:190px;">Product</th>
					<th style="width:190px;">From</th>
					<th style="width:190px;">Branch</th>
					<th style="width:190px;">Sent Time</th>
					<th style="width:190px;">Sender</th>
					<th style="width:190px;">Actions</th>
			    </tr>
			    <tr>
				<td style="border-bottom: none !important;">
				    <input class="form-control col-search-input" type="text" name="buyer" value="" placeholder="Search client" autocomplete="off" />
				</td>
				<td style="border-bottom: none !important;">
				    <input class="form-control col-search-input" type="text" name="phone" value="" placeholder="Search phone" autocomplete="off" />
				</td>				
				<td style="border-bottom: none !important;">
				    <select class="form-control col-search-input" name="product"  autocomplete="on">
					<option value=''>Select</option>					
					<?php foreach($pdcats as $pdcat) {?>					
					    <?php if($pdcat->parent_id == 0) {?>					    <option style="font-weight:bold" value="<?=$pdcat->id?>" disabled="disabled"><?=$pdcat->title?></option>
					    <?php } else { ?>
					    <option value="<?=$pdcat->id?>" ><?=$pdcat->title?></option>
					    <?php } ?>					
					<?php } ?>					
				    </select>
				</td>
				<td style="border-bottom: none !important;">
				    <select class="form-control col-search-input" name="from"  autocomplete="on">
					<option value=''>Select</option>					
						<?php foreach($employees as $employee) {?>            
							<option value="<?=$employee->id?>"><?=$employee->first_name.' '.$employee->last_name?></option>
						<?php } ?>					
				    </select>
				</td>
				<td style="border-bottom: none !important;">
				    <select class="form-control col-search-input" name="branch" autocomplete="on">
					<option value=''>Select</option>					
					<?php foreach($branches as $branch) {?>					
					    <option value="<?=$branch->id?>"><?=$branch->name?></option>		
					<?php } ?>					
				    </select>
				</td>
				<td style="border-bottom: none !important;">
				    <select class="form-control col-search-input" name="sent" autocomplete="on">
						<option value=''>All</option>
						<option value='s'>Sent</option>
						<option value='d'>Draft</option>				
				    </select>
				</td>
				<td style="border-bottom: none !important;">
				    <select class="form-control col-search-input" name="sender"  autocomplete="on">
					<option value=''>Select</option>					
						<?php foreach($employees as $employee) {?>            
							<option value="<?=$employee->id?>"><?=$employee->first_name.' '.$employee->last_name?></option>
						<?php } ?>					
				    </select>
				</td>
				<td style="border-bottom: none !important;">
				    <input class="form-control col-search-input" type="text" name="buyer" value="" placeholder="Project number" autocomplete="off" />
				</td>

			    </tr>
			</thead>
		    </table> 
		</div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="ajaxdatatableURL" value="<?php echo $_cancel.'/projectlist'?>"/>
<?= view('main/common/datatable');?>
<style>
.table-checkable tr>td{min-width:100px !important;}
.table-checkable tr>td:first-child, .table-checkable tr>th:first-child{max-width:190px !important;}
</style> 
<script>
function confirm_box(){
    var answer = confirm ("Are you sure?");
    if (!answer)
     return false;
}

function getData(){
    var data = $('#search-form').serialize();
    
    
    console.log(data);
    
	$.ajax({
		type: 'POST',
		url : "<?php echo $_cancel.'/ajax_list'?>",
		data:data,
		success: function(data){
		    
		    
			$('#result-data').html(data); 
			
			
			
		}
	});
}

function do_invoice(id){
        var column = 'invoice';
	$.ajax({
		type: "GET",
		url: "<?=$_cancel?>/do_toggle", /* The country id will be sent to this file */
		data: {id:id,column:column},
		dataType:'json',
		success: function(response){
			if(response.status=='error'){
				alert(response.message);
			}
		}
	});
}

</script>
