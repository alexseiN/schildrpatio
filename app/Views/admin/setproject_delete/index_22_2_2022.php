<script type="text/javascript" src="assets/plugins/ajax-pagination/pagination.min.js"></script>
<style>
    .sent {
        background-color:#fff0f0!important;
    }
    .table .btn {
        margin:0px!important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div></div>
            <div class="portlet-body">
<div class="row">
	    <div class="col-md-12">
                <div class="btn-group">
                            <a href="/admin123/setproject/edit" class="btn btn-primary m-r-5 m-b-5">
                                Add New <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <hr>
	    </div>
	    </div>
			    <div class="table-responsive">

<table id="data-table" class="table table-striped table-bordered table-hover table-checkable dataTable no-footer">
    <thead>
    <tr>
        
        <th style="max-width:200px!important;width:200px!important;">Client Fullname</th>
        <th>Client Phone</th>
        <th>Product</th>
        <th>From</th>
        <th>Branch</th>
        <th style="width:178px;">Sent Time</th>
        <th>Sender</th>
        <th style="width:178px;">Actions</th>
        
        
    </tr>
<form method="get" id="search-form" class="form-inline" >
<tr role="row" class="filter">
    <td><input onkeyup="getData()" class="form-control" type="text" name="buyer" value="" placeholder="Search" autocomplete="off" /></td>
    <td><input onkeyup="getData()" class="form-control" type="text" name="phone" value="" placeholder="Search" autocomplete="off" /></td>
    <td >
        <select class="form-control" name="product" onchange="getData()" autocomplete="on">
            <option value=''>Select</option>
            
            <?php foreach($pdcats as $pdcat) {?>
            
                <?php if($pdcat->parent_id == 0) {?>
                <option style="font-weight:bold" value="<?=$pdcat->id?>" disabled="disabled"><?=$pdcat->title?></option>
                <?php } else { ?>
                <option value="<?=$pdcat->id?>" ><?=$pdcat->title?></option>
                <?php } ?>
            
            <?php } ?>
            
        </select>
    </td>
    <td >
        <select class="form-control" name="from" onchange="getData()" autocomplete="on">
            <option value=''>Select</option>
            
            <?php foreach($employees as $employee) {?>
            
                <option value="<?=$employee->id?>"><?=$employee->first_name.' '.$employee->last_name?></option>
            
            <?php } ?>
            
        </select>
    </td>
    <td >
        <select class="form-control" name="branch" onchange="getData()" autocomplete="on">
            <option value=''>Select</option>
            
            <?php foreach($branches as $branch) {?>
            
                <option value="<?=$branch->id?>"><?=$branch->name?></option>
            
            <?php } ?>
            
        </select>
    </td>

    <td>
        <select class="form-control" name="sent" onchange="getData()" autocomplete="on">
            <option value=''>All</option>
            <option value='s'>Sent</option>
            <option value='d'>Draft</option>
        </select>
    </td>
    <td>
        <select class="form-control" name="sender" onchange="getData()" autocomplete="on">
            <option value=''>Select</option>
            
            <?php foreach($employees as $employee) {?>
            
                <option value="<?=$employee->id?>"><?=$employee->first_name.' '.$employee->last_name?></option>
            
            <?php } ?>
            
        </select>
    </td>
    <td><input onkeyup="getData()" class="form-control" type="text" name="id" value="" placeholder="Project number" autocomplete="off" /></td>
     

</tr>
</form>    
    </thead>
    
<tbody id="result-data">
    
    
    
    <?php $this->data['objects'] = $thisItems;
    
    echo view('admin/setproject/ajax_list', $this->data);  ?>
    
    
    
    
</tbody>


</table> 


    </div>
            </div>
        </div>
    </div>
</div>
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



<link href="assets/plugins/edittable/css/custom.css" rel="stylesheet" type="text/css">
<script src="assets/plugins/edittable/js/bootstrap-editable.js" type="text/javascript"></script> 


