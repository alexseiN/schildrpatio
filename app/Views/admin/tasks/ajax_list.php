<?php

$updatetaskrow = $_cancel.'/updatetaskrow';
$loggedinuser = $_thisData['loggedinuser'];
$optiondata = $_thisData['optiondata'];
$loggedinusername = $_thisData['loggedinusername'];

$typedata = $_thisData['typedata'];
$statusdata = $_thisData['statusdata'];
$adminDetails = $_thisData['adminDetails'];


if($objects){
    
    foreach($typedata as $key=>$value){
	$typeoptions[] = "{value: '".$key."', text: '".$value."'}";
    }
    $typearray = implode(",",$typeoptions);
    $typesource = "[".$typearray."]";


    foreach($statusdata as $key=>$value){
	$statusoptions[] = "{value: '".$key."', text: '".$value."'}";
    }
    $statusarray = implode(",",$statusoptions);
    $statussource = "[".$statusarray."]";


    foreach($_thisData['optiondata'] as $key=>$value){
	$assignedoptions[] = "{value: '".$key."', text: '".$value."'}";
    }
    $assignedarray = implode(",",$assignedoptions);
    $assignedsource = "[".$assignedarray."]";
    
    
    $bysource = "[{value: '".$loggedinuser."', text: '".$loggedinusername."'}]";
    
    foreach($objects as $set_data){
	$product = get_langer('pdcats',$_thisData['admin_lang'], $set_data->product);
	$by = get_langer('employees',false, $set_data->by);
	$assigned = get_langer('employees',false, $set_data->assigned);
	if ($set_data->enabled == 1) {$invoice = 'checked';} else {$invoice = ' ';}
	if($set_data->deadline) {
	    $deadline = $set_data->created + intval($set_data->deadline)*24*3600;
	} else {$deadline='';}
	$branch = get_langer('branches',$_thisData['admin_lang'], $from->branch_id);
	$class="xedits";
	if($_thisData['loggedinuser'] != $set_data->by) {$class = '';}
?>
<tr class="" id="changer-<?=$set_data->id?>">
    <td class=" fs-6"><?=$set_data->id?></td>
    <td style="    min-width: 350px;" class="xedit  fs-5" data-type="text" data-pk="<?=$set_data->id?>" data-name="title" data-value="<?=$set_data->title?>" data-id="<?=$set_data->id?>"> <?=$set_data->title?></td>
    
    <td class="<?=$class?>  fs-6" data-source="<?= $bysource?>" data-type="select" data-pk="<?=$set_data->id?>" data-value="<?=$set_data->by?>" data-title="Select status" data-name="by" > <?=$by->first_name.' '.$by->last_name?></td>

   <td class="<?=$class?>  fw-bold fs-6" data-source="<?= $assignedsource?>" data-type="select" data-pk="<?=$set_data->id?>" data-value="<?=$set_data->assigned?>" data-title="Select status" data-name="assigned" data-id="<?=$set_data->id?>"> <?=$assigned->first_name.' '.$assigned->last_name?></td>
    
    <td class="xedits  fs-6" data-source="<?= $typesource?>" data-type="select" data-pk="<?=$set_data->id?>" data-value="<?=$set_data->type?>" data-title="Select status" data-name="type" data-id="<?=$set_data->id?>"><?=$typedata[$set_data->type]?></td>
    
    <td class="xedits  fs-6" data-source="<?= $statussource?>" data-type="select" data-pk="<?=$set_data->id?>" data-value="<?=$set_data->status?>" data-title="Select status" data-name="status" data-id="<?=$set_data->id?>"><span class="stnew <?=$set_data->status?>"><?=$statusdata[$set_data->status]?></span></td>
    
    <td class="xeditd  fs-6" id="deadline_<?=$set_data->id?>" data-onChange="alert('I am Fired')" data-type="text" data-pk="<?=$set_data->id?>" data-value="<?=$set_data->deadline?>" data-name="deadline" data-id="<?=$set_data->id?>"><?=branchtime($deadline,$branch->diff,'M d,Y')?></td>
    
    <td class="" id="action_row_<?=$set_data->id?>">
       <div class="d-flex justify-content-end flex-shrink-0">
	<?php if($loggedinuser == $set_data->by) { ?>
	    <a class="btn btn-light-primary rounded-0 btnsml" href="<?= $_cancel?>/edit/<?=$set_data->id?>" title="Edit Task"><i class="fa fa-edit"></i></a>
	<?php } else {  ?>
	    <a class="btn btn-light-success rounded-0 btnsml" href="<?= $_cancel?>/edit/<?=$set_data->id?>" title="View Task"><i class="fa fa-eye"></i></a>
	<?php } ?>
	</div>
    </td>
</tr>
<?php } } else { ?>
<tr>
    <td colspan="8"><span class="text-muted fw-bold text-muted d-block fs-7 text-center">No data found.</span></td>
</tr>
<?php } ?>
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script>
var loggedinuser = '<?=$adminDetails->employee_id?>';
var loggedinusername = '<?=$optiondata[$adminDetails->employee_id]?>';
var optiondata = '<?=create_select_options($optiondata)?>';

var updateURL = '<?= $updatetaskrow ?>';
$(document).ready(function(){ 
    setTimeout(initalizeeditable, 200);
});
function initalizeeditable(){
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.showbuttons = false;
    $.fn.editable.defaults.onblur = 'submit';
    $('.xedit').editable({
	url:updateURL,  
    });
    $('.xedits').editable({
	url:updateURL,
	ajaxOptions: {
	   dataType: 'json' //assuming json response
	},                
	success: function(data, config) {
	   if(data.status == 'success'){
		$( ".filterclone" ).find('select').select2('destroy');
		$( ".filterclone" ).find('select').select2();
		if(data.name == 'by' || data.name == 'assigned'){
		    var optiondata = data.optionset;	    
		    $("#selectrowwithform select[name='assigned_TYPEwhere']").find('option').remove().end().append(optiondata).val('');
		}
		getData();		
	   }
	   else {
		alertmodal('error',"something not right.");
	   }
	},
	error: function(errors) {
	   alertmodal('error',"something not right.");
	   location.reload();
	}  
    });
    $('.xeditd').editable({
	url:updateURL,
	ajaxOptions: {
           dataType: 'json' //assuming json response
       },           
       success: function(data, config) {
	   getData();
       },
       error: function(errors) {
           alertmodal('error',"something not right.");
	   location.reload();
       }               
    });


}
function updatedealine(pk,html){
    $("#deadline_"+pk).html(html)
}
</script>
<style>
.editableform .control-group, .form-inline input, .editable-input, .editable-input select, .editable-input .combodate select{width:100% !important;}


    .completed { background-color:#effbec!important;}
    .started { background-color:#fffbdb!important;}
    .waiting { background-color:#f9e7e77a!important;}
    .problem { background-color:#f9cccc!important;}
    .discussion { background-color:#f3c4f2b0!important;}
    .urgent { background-color:yellow!important;}

    .stnew {
        padding:4px 14px;
        border:1 px dolid red;
        border-radius: 10px;
    }
    
    
</style>              
