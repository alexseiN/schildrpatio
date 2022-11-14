<script type="text/javascript" src="assets/plugins/ajax-pagination/pagination.min.js"></script>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div></div>
            <div class="portlet-body">
<div class="row">
	    <div class="col-md-12">

	    </div>
	    </div>
			    <div class="table-responsive">

<table id="data-table" class="table table-striped table-bordered table-hover table-checkable dataTable no-footer">
    <thead>
    <tr>
        <th width="30px">Image</th>
        <th width="250px">Fullname</th>
        <th width="250px">Company</th>
        <th width="200px">Position</th>
        <th width="300px">Phones</th>
         <th width="300px">Email</th>
        
    </tr>
<form method="get" id="search-form" class="form-inline" >
<tr role="row" class="filter">
    <td></td>
<td>
    <input onkeyup="getData()" class="form-control" type="text" name="fullname" value="" placeholder="Search" autocomplete="off" />
</td>
<td >
    <select class="form-control" name="company" onchange="getData()" autocomplete="on">
        <option value="">Select</option>
        
        <?php foreach($branches as $branch) {?>
        
            <option value="<?=$branch->id?>"><?=$branch->name?></option>
        
        <?php } ?>
        
    </select>
    

</td>
<td>
    <!--select class="form-control" name="position" onchange="getData()" autocomplete="on">
        <option value="">Select</option>
        
        <?php foreach($positions as $position) {?>
        
            <option value="<?=$position->id?>"><?=$position->title?></option>
        
        <?php } ?>
        
    </select-->
</td>
<td>

</td>

<td >

 </td>
</tr>
</form>    
    </thead>
    
<tbody id="result-data">
    
    
    
    <?php $this->data['objects'] = $thisItems;
    
    echo view('admin/staf/ajax_list', $this->data);  ?>
    
    
    
    
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
    
    
    //alert(data);
    
	$.ajax({
		type: 'POST',
		url : "<?php echo $_cancel.'/ajax_list'?>",
		data:data,
		success: function(data){
		    
		    
			$('#result-data').html(data);
			
			
			
		}
	});
}

</script>



<link href="assets/plugins/edittable/css/custom.css" rel="stylesheet" type="text/css">
<script src="assets/plugins/edittable/js/bootstrap-editable.js" type="text/javascript"></script> 


