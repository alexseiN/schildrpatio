<?php
    $updatetaskrow = site_url() . $_cancel."/updatetaskrow";
?>
<script type="text/javascript" src="assets/plugins/ajax-pagination/pagination.min.js"></script>
<style>
    .completed { background-color:#effbec!important;}
    .started { background-color:#fffbdb!important;}
    .waiting { background-color:#f9e7e77a!important;}
    .problem { background-color:#f9cccc!important;}
    .discussion { background-color:#f3c4f2b0!important;}
    .urgent { background-color:yellow!important;}
    
    .table .btn {
        margin:0px!important;
    }
    
    .stnew {
        padding:4px 14px;
        border:1 px dolid red;
        border-radius: 10px;
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
                            <!--a href="/admin123/tasks/edit" class="btn btn-primary m-r-5 m-b-5">
                                Add New <i class="fa fa-plus"></i>
                            </a-->

			    <a href="javascript:" id="addtablerow" class="btn btn-primary m-r-5 m-b-5">
                                Add New <i class="fa fa-plus"></i>
                            </a>
			    
                        </div>
                        <hr>
	    </div>
	    </div>
			    <div class="table-responsive">
<div class="pull-left">Total: <span class="search-total"><?=count($get_emp_tasks)?></span></div>
<table id="data-table" class="table table-striped table-bordered table-hover table-checkable dataTable no-footer">
    <thead>
    <tr>
        
        <th width="60px">No</th>
        <th>What to Do ?</th>
        <th>Task By</th>
        <th>Assigned to</th>
        <th>Type</th>
        <th width="120px">Status</th>
        <th width="120px">Deadline</th> 
        <th width="40px">Act</th>
        
        
    </tr>
<form method="get" id="search-form" class="form-inline" >
    <input type="hidden" name="rowperpage" id="rowperpage" value="20"/>
    <input type="hidden" id="row" name="row" value="0"/>
    <input type="hidden" id="all"  name="all" value="<?php echo count($get_emp_tasks); ?>"/>
    <input type="hidden" id="updatetaskrow" value="<?= $updatetaskrow?>" />

<?php
    foreach($employees as $employee) { $optiondata[$employee->id] = $employee->first_name.' '.$employee->last_name; }
    $typedata = getarray('type');
    $statusdata = getarray('status');
?>
<tr role="row" class="filter filterclone" data-id="0" id="selectrowwithform">
    <td><input onkeyup="getData('no')" class="form-control" type="text" name="id" value="" placeholder="Search" autocomplete="off" /></td>
    <td><input onkeyup="getData('no')" class="form-control" type="text" name="title" value="" placeholder="Search" autocomplete="off" /></td>
    <td ><?= create_select('by',"getData(this,'no')",$optiondata,$n_by_array)?></td>
    <td ><?= create_select('assigned',"getData(this,'no')",$optiondata,$n_assigned_array)?></td>
    <td ><?= create_select('type',"getData(this,'no')",$typedata,array())?></td>
    <td ><?= create_select('status',"getData(this,'no')",$statusdata,array())?></td>   
    <td></td>
    <td></td>
</tr>
</form>    
    </thead>
    
<tbody id="result-data">
    
</tbody>
<tfoot id="loading">
    <tr>
      <td colspan="8">Loading, Please wait...</td>
    </tr>
  </tfoot>
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
var loggedinuser = '<?=$adminDetails->employee_id?>';
var loggedinusername = '<?=$optiondata[$adminDetails->employee_id]?>';
var optiondata = '<?=create_select_options($optiondata)?>';
 function getData(selfvar,checkvalue = 'no'){
    var checkbyid = $('tr#selectrowwithform select[name="by"]').val();    
    if(selfvar != 'initial'){
	var checknameself = $(selfvar).attr('name');
	if(checknameself == 'by'){
	    $('tr#selectrowwithform select[name="assigned"]').val('');
	}
	var checkassignedid = $('tr#selectrowwithform select[name="assigned"]').val();   
	if(checkbyid != loggedinuser && checkbyid != ''){
	    $('tr#selectrowwithform select[name="assigned"]').val(loggedinuser);
	}
	else if(checkassignedid != '' && checkbyid == '' && checkassignedid != loggedinuser){
	    $('tr#selectrowwithform select[name="by"]').val(loggedinuser);
	}
    }
    
    var data = $('#search-form').serializeArray();
    var row = Number($('#row').val());
    var allcount = Number($('#all').val());


    if(isNaN(row) || checkvalue == 'no'){
	row = 0;
	$('#row').val(row)
    }
    if(isNaN(allcount) || checkvalue == 'no'){
	allcount = '<?=count($get_emp_tasks)?>';
	$('#all').val(allcount)
    }


    
    data.push({name: 'checkvalueaction', value: checkvalue});
    data.push({name: 'row', value: row});
    data.push({name: 'all', value: allcount});    
    $.ajax({
	type: 'POST',
	url : "<?php echo $_cancel.'/ajax_list'?>",
	data:data,
	cache:false,
	success: function(res){
	    $("#loading").hide();

	    const data = JSON.parse(res);

	    $('#all').val(data['totalcount']);
	    $('.search-total').html(data['totalcount']);
	    
	    if(checkvalue == 'yes') {
		$("#result-data").append(data['html']);
	    }
	    else {
		$('#result-data').html(data['html']);
	    }
	}
    });
}

function do_invoice(id){
    var column = 'enabled';
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

$(document).ready(function(){  

    $("#addtablerow").on("click", function(){
	var dataid = $('.filterclone').last().attr('data-id');
	var index = Number(dataid) + 1;
	$clone = $( ".filterclone" ).last().clone( true );
	$clone.appendTo( "#data-table thead" );
	$clone.attr('id',"added_row"+index);
	$clone.attr('data-id',index);
	$clone.children().find('input').val('');
	$clone.children().find('input').removeAttr('onkeyup');
	$clone.children().find('select').val('');
	$clone.children().find('select').removeAttr('onchange');
	$clone.children('td').first().html('');
	$clone.children('td:nth-last-child(7)').find('input').attr('placeholder','Task Title');	
	$clone.children('td:nth-last-child(2)').html('<input type="text" name="deadline" value="" class="form-control " id="" placeholder="Deadline">');
	$clone.children('td').last().html('<a class="btn btn-xs btn-info addrowtext" data-id="'+index+'" href="javascript:" title="Add Task"><i class="fa fa-plus"></i></a>&nbsp;<a class="btn btn-xs btn-danger removerow" data-id="'+index+'" href="javascript:" title="Remove row"><i class="fa fa-trash"></i></a>');

	$("#added_row"+index+" select[name='by']").find('option').remove().end().append('<option value="'+loggedinuser+'">'+loggedinusername+'</option>').val(loggedinuser);

	$("#added_row"+index+" select[name='assigned']").find('option').remove().end().append(optiondata).val('');


    });

    $(document).on("click",".removerow", function(){
	var dataid = $(this).attr('data-id');	
	var formtoget = $("#added_row"+dataid).remove();    
    });

    $(document).on("click",".addrowtext", function(){
	var dataid = $(this).attr('data-id');	
	var formtoget = $("#added_row"+dataid);
	var title = formtoget.children().find('input[name=title]').val();
	var by = formtoget.children().find('select[name=by]').val();
	var assigned = formtoget.children().find('select[name=assigned]').val();
	var type = formtoget.children().find('select[name=type]').val();
	var status = formtoget.children().find('select[name=status]').val();
	var deadline = formtoget.children().find('input[name=deadline]').val();
	$.ajax({
	    type: 'POST',
	    url : "<?php echo $_cancel.'/save_ajax'?>",
	    data:{'by':by,'title':title,'assigned':assigned,'type':type,'deadline':deadline,'status':status,'explanation':''},
	    cache:false,
	    success: function(res){
		
		getData('initial');formtoget.remove();
	    }
	});
    });
          
    $(window).scroll(function(){	
	var position = $(window).scrollTop();
	var bottom = $(document).height() - $(window).height();
	if( position == bottom ){
	    $("#loading").show();
	    var row = Number($('#row').val());
	    var allcount = Number($('#all').val());
	    var rowperpage = Number($('#rowperpage').val());
	    row = row + rowperpage;
	    if(row <= allcount){
		$('#row').val(row);
		setTimeout(getData('initial',"yes"), 10000);		
	    }
	    else {
		 $("#loading").hide();
	    }
	}
    });
});

getData('initial');
</script>


