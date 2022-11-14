<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div><div class="tools"> </div></div>
            <div class="portlet-body">
		<div class="table-responsive">
		    <table id="datatable" class="table table-striped table-bordered table-hover table-checkable no-footer">
			<thead>
			    <tr>
				<th style="min-width:200px!important;">Client</th>
				<th>Zip Code</th>
				<th>Branch</th>
				<th>Product</th>
				<th>Received Time</th>
				<th style="width:50px;">Actions</th>
			    </tr>
			    <tr>
				<td style="border-bottom: none !important;">
				    <input class="form-control col-search-input" type="text" name="client" value="" placeholder="Search client" autocomplete="off" />
				</td>
				<td style="border-bottom: none !important;">
				    <input class="form-control col-search-input" type="text" name="zipcode" value="" placeholder="Search zipcode" autocomplete="off" />
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
				    &nbsp;
				</td>
				<td style="border-bottom: none !important;">
				    <select class="form-control col-search-input" name="view" autocomplete="on">
					<option value=''>All</option>
					<option value='1'>Viewed</option>  
					<option value='0'>Waiting</option>
				    </select>
				</td>
			    </tr>
			</thead>
		    </table> 
		</div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="ajaxdatatableURL" value="<?php echo $_cancel.'/quotelist'?>"/>
<?= view('main/common/datatable');?>

<script>

function confirm_box(){
    var answer = confirm ("Are you sure?");
    if (!answer)
     return false;
}


function do_invoice(id){
        var column = 'view';
        
        var curtot = parseInt($(".totik").html());
        var quotem = parseInt($(".quotik").html());
        
        
    
        if ($("#changer-"+id).hasClass("sent")) {    
          
          $(".totik").html(curtot-1);
          $(".quotik").html(quotem-1);
          
        } else {
            $(".totik").html(curtot+1);
            $(".quotik").html(quotem+1);
        }
     
        $("#changer-"+id).toggleClass("sent"); 
         
        
        
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
</script>
