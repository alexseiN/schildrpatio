<?php

error_reporting(0);
$thisemploee = get_langer('employees', false, $setproject->employee);
$thisbranch = get_langer('branches', 8, $thisemploee->branch_id);
$thisregion = get_langer('regions', 8, $thisbranch->region_id);
$branchtel = explode(',', $thisbranch->phones);
$currency = get_langer('currency', false, $thisbranch->currency);


$moreex = floatval($setproject->tax) +floatval($setproject->shipping) + floatval($setproject->transportation) + floatval($setproject->insurance) + floatval($setproject->extra) + floatval($setproject->install) ;

$expences = $moreex;

if(substr($setproject->incomen, -1) == '%') {
    
    

    $percent = floatval(substr($setproject->incomen, 0, -1));
    
   
    

} else {

    $incomen = floatval($setproject->incomen);
    
    $moreex= $moreex + $incomen;

}







$this_cat = get_langer('pdcats',8,$setproject->product_category);
$main_cat = get_langer('pdcats',8,$this_cat->parent_id);
$colcats = explode(',',$main_cat->secolorcats);
//pp($colcats,false);
$color_array = array();$color_2_array = array();
foreach ($coloritems as $color) {$color_array[$color->id]=$color->title;}
foreach ($coloritems2 as $color2) {$color_2_array[$color2->id]=$color2->title;}

$colorcode = options_for_fcolor($colcats,$coloritems);
$colorcode2 = create_select_options($color_2_array);

if ($adminDetails->role == 'Global Admin') {$backLink = $admin_link;}
if ($adminDetails->role == 'Branch Admin') {$backLink = $branch_link;}
?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Form-->
            <?=view('admin/includes/common/errors')?>
            <div class="card">
                <!-- begin::Body-->
                <div class="card-body py-10">
                    <!-- begin::Wrapper-->
                    <div class="mx-auto w-100">
                        <!-- begin::Header-->
                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-5">
                            <!--end::Logo-->
                            <div class="text-sm-start">
                                <!--begin::Logo-->
                                <a href="javascript:" class="d-block mw-250px">
                                    <img alt="Logo" src="assets/uploads/sites/<?= $main->logo ?>" class="w-100">
                                </a>
                                <!--end::Logo-->
                                <!--begin::Text-->
                                <div class="text-sm-start text-muted fs-7 mt-3">                                    
                                    <?php if($thisbranch->ortype != 'virtual') { ?>
                                        <div class="fw-boldest text-gray-800"><?=$thisbranch->name?></div>
                                        <div><?=$thisbranch->address?></div>
                                        <div><b class="fw-boldest text-gray-800">Branch contacts:</b> <?php $i = 0;foreach ($branchtel as $tel) { echo $tel; $i++;} ?></div>
                                    <?php } ?>
                                    <div><b class="fw-boldest text-gray-800">Created by:</b>&nbsp;&nbsp;<?= $thisemploee->first_name ?> <?= $thisemploee->last_name ?></div>
                                    <div><b class="fw-boldest text-gray-800">Phones:</b> &nbsp;&nbsp; <?= $thisemploee->mobile ?></b></div>
                                </div>
                                <!--end::Text-->
                            </div>
                            
                            <div class="text-sm-end">
                                <div class="text-sm-start text-muted fs-7 mt-3">
                                    <div class="fw-boldest text-gray-800">PROFORMA INVOICE</div>
                                    <div><b class="fw-boldest text-gray-800">Project Number:</b>&nbsp;&nbsp;<span class="text-sm-end"><?= $thisbranch->code.'/'. $setproject->id ?></span></div>
                                    <div><b class="fw-boldest text-gray-800">Date:</b>&nbsp;&nbsp;<span class="text-sm-end"><?= branchtime($setproject->created,$thisbranch->diff,'M d,Y h:i')  ?></span></div>
                                    <div><b class="fw-boldest text-gray-800">Buyer:</b>&nbsp;&nbsp;<span class="text-sm-end"><?= $setproject->buyer ?></span></div>
                                    <div><b class="fw-boldest text-gray-800">Address or ZIP:</b>&nbsp;&nbsp;<span class="text-sm-end"><?= $setproject->address ?></span></div>
                                    <div><b class="fw-boldest text-gray-800">Phone:</b>&nbsp;&nbsp;<span class="text-sm-end"><?= $setproject->phone ?></span></div>
                                </div>
                            </div>
                        </div>
                        <!--end::Header-->
                        <div class="d-flex flex-stack flex-wrap mt-lg-5 pt-5 mb-5">
                            <div class="my-1 me-5">
                                <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Click to add" class="btn btn-light-primary rounded-0 btn-sm my-1 me-3" onclick="addNewCategory()"><i class="fa fa-plus"></i>Add option</button>
                                <a target="_blank" href="/invoice/<?= $setproject->link ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="View Invoice" class="btn btn-light-info rounded-0 btn-sm my-1 me-3"><i class="fa fa-eye"></i>View Invoice</a>

                                <?php if ($thisregion->id == 14) { ?>
                                    <a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Price list" href="assets/uploads/pdf/TurkeyPriceList2022.pdf" class="btn btn-light-danger rounded-0 btn-sm my-1 me-3"><i class="fa fa-list"></i>Price list</a>
                                <?php } ?>
                                
                                <?php if ($thisbranch->ortype == 'manufacture') { ?>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="View invoice with prices" href="/invoice/wp/<?= $setproject->link ?>" target="_blank" class="btn btn-light-success rounded-0 btn-sm my-1 me-3" ><i class="fa fa-eye"></i>View invoice with prices</a> 
                                <?php } ?>
                                                            
                            </div>
                        </div>
                        <!--begin::Body-->
                        <div class="pb-6">
                            <div class="d-flex flex-column gap-7 gap-md-10">
                                <div class="d-flex justify-content-between flex-column">
                                    <div class="table-responsive border-bottom mb-3" id="id_products_div">
                                        <?= create_invoice_table($main_project_id,$admin_lang) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-5">
                            <!--end::Logo-->
                            <div class="text-sm-start">
                                <!--begin::Text-->
                                <div class="text-sm-start text-muted fs-7 mt-3 mb-3" id="id_invoice_notes">
                                    <?= $setproject->notes ?>                                  
                                </div>
                                <!--end::Text-->
                                <!--begin::Text-->
                                <div class="text-sm-start text-muted-600 fs-7 mt-3">
                                    <?= $thisbranch->about ?>                 
                                </div>
                                <!--end::Text-->                                
                            </div>
                        </div>    
                        <!-- begin::Footer-->
                        <div class="d-flex justify-content-end mb-5">
                            <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="More fields" onclick="return openfieldmodal()" class="btn btn-light-warning rounded-0 btn-sm my-1 me-3"><i class="fa fa-ellipsis-v"></i>More fields</button>

                            <button class="btn btn-light-success rounded-0 btn-sm my-1 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Send Email without Prices" onclick="sendInvoicePDF(0)"><i class="fa fa-envelope"></i>Send Email without Prices</button>
                               
                                
                            <?php if ($thisbranch->ortype == 'manufacture') { ?>
                                <button class="btn btn-light-danger rounded-0 btn-sm my-1 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Send Email with Prices" onclick="sendInvoicePDF(1)"><i class="fa fa-envelope"></i>Send Email with Prices</button> 
                            <?php } ?>
                                
                        </div>
                        <!-- end::Footer-->
                    </div>
                    <!-- end::Wrapper-->
                </div>
                <!-- end::Body-->
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<div class="modal fade" id="extramyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content rounded">
            <div class="modal-header">
                <h2>More Fields</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Input group-->
                <div class="mb-10 fv-row">
                    <?php                               
                        $data = [
                            "label"          => "Shipping ( From Turkey )",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'shipping',
                                'id'    => 'shipping',
                                'value' => $setproject->shipping,
                            ]
                        ];
                        echo html_form_tags($data);
                    ?>
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-10 fv-row">
                    <?php                               
                        $data = [
                            "label"          => "Insurance",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'insurance',
                                'id'    => 'insurance',
                                'value' => $setproject->insurance,
                            ]
                        ];
                        echo html_form_tags($data);
                    ?>
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-10 fv-row">
                    <?php                               
                        $data = [
                            "label"          => "Tax",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'tax',
                                'id'    => 'tax',
                                'value' => $setproject->tax,
                            ]
                        ];
                        echo html_form_tags($data);
                    ?>
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-10 fv-row">
                    <?php                               
                        $data = [
                            "label"          => "Transportation",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'transportation',
                                'id'    => 'transportation',
                                'value' => $setproject->transportation,
                            ]
                        ];
                        echo html_form_tags($data);
                    ?>
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-10 fv-row">
                    <?php                               
                        $data = [
                            "label"          => "Installation",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'installation',
                                'id'    => 'installation',
                                'value' => $setproject->install,
                            ]
                        ];
                        echo html_form_tags($data);
                    ?>
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-10 fv-row">
                    <?php                               
                        $data = [
                            "label"          => "Extra",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'extra',
                                'id'    => 'extra',
                                'value' => $setproject->extra,
                            ]
                        ];
                        echo html_form_tags($data);
                    ?>
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-10 fv-row">
                    <?php                               
                        $data = [
                            "label"          => "Income",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'incomen',
                                'id'    => 'incomen',
                                'value' => $setproject->incomen,
                            ]
                        ];
                        echo html_form_tags($data);
                    ?>
                </div>
                <!--end::Input group-->
                <?php $counter_1_check = 'notefor_client';?>
                <!--begin::Input group-->
                <div class="mb-10 fv-row" id="quillarea_<?=$counter_1_check?>">
                    <?php                                                                           
                        $data = [
                            "label"          => "Notes for client",
                            "label_required" => "",
                            "type"           => "textarea",
                            "type_data"      => [
                                'name'  => 'notes',
                                'id'    => 'form_editor_'.$counter_1_check,
                                'value' => $setproject->notes,
                                'class' => 'form-control form-control-solid form_editor form_editor_'.$counter_1_check,
                                'rows'  => '4',
                                'data-counter'  => $counter_1_check
                            ]
                        ];
                        echo html_form_tags($data);
                    ?>
                </div>
                <!--end::Input group-->

                <?php $counter_1_check = 'internal_notes';?>
                <!--begin::Input group-->
                <div class="mb-10 fv-row" id="quillarea_<?=$counter_1_check?>">
                    <?php                                                                           
                        $data = [
                            "label"          => "Internal notes",
                            "label_required" => "",
                            "type"           => "textarea",
                            "type_data"      => [
                                'name'  => 'internal',
                                'id'    => 'form_editor_'.$counter_1_check,
                                'value' => $setproject->internal,
                                'class' => 'form-control form-control-solid form_editor form_editor_'.$counter_1_check,
                                'rows'  => '4',
                                'data-counter'  => $counter_1_check
                            ]
                        ];
                        echo html_form_tags($data);
                    ?>
                </div>
                <!--end::Input group-->

                <div class="mb-10 fv-row text-center pt-15">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Discard</button>
                    <button type="button" id="submitfields" onclick="return updateInvoiceNotes()" class="btn btn-primary">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                
            </div>
        </div>
    </div>
</div>



<style>
    .des{max-width: 101px;}
    .ma{max-width: 105px;}
    .qt{max-width:45px;}
    .up,.tp{min-width:100px;}
    .nm{max-width:30px;}
    .dm{max-width:95px;}
    .editable-container.editable-inline{min-width:100px;}
</style>
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script type="text/javascript">

    quillfunction();
    function openfieldmodal(){
        $("#extramyModal").modal('show');
    }
    var products = [];
    var category = 0;
    var product_category = 0;
    var productOptions = "";
    function getLastNumber(url) {
        var matches = url.match(/\d+/g);
        return matches[matches.length - 1];
    }
    function selectRefresh() {
      //$('#id_products_div .colordropdown').select2();
      //$('#id_products_div select').select2('destroy');
      $('#id_products_div select').select2();
      //$("span.select2-container").addClass('select2-container--default');
    }
    // main function to call ajax and save data
    function callajax(targetname,targetvalue,project_id,row_id,invoiceid,target_tr_id){
        const updatearray = ['sproduct','dimensions','scolor','fcolor','motorauto','additional','qty','uprice'];

        var calltable = '#child_table_'+project_id;
        var calltr = $(calltable+' tr#'+target_tr_id);
        var checkproductvalue = $(calltable+' tr#'+target_tr_id+' #sproduct_'+row_id).val();
        var callitem = $(calltable+' tr#'+target_tr_id+' #'+targetname+'_'+row_id);
        
        if(checkproductvalue == ''){
            setTimeout(function() {   
                alertmodal('error',"Please select product first.");
            }, 200);
            if(targetname == 'uprice' || targetname == 'qty'){
                setTimeout(function() {
                    callitem.html(0);
                    $(calltable+' tr#'+target_tr_id+' #total_row_'+row_id).html(0);
                }, 500);
            }
            setTimeout(function() {
                $(calltable+' tr#'+target_tr_id+' .colordropdown').val('');
            }, 500);
            return false;
        }
        if(targetname == 'uprice' || targetname == 'qty' || targetname == 'motorauto' || targetname == 'dimensions' || targetname == 'additional'){
            callitem.html(targetvalue);
        }

        calculateTotalPrice(project_id);

        var totalprice = $('#id_order_total_'+project_id).text();
        var product_category = $('#product_category_'+project_id).val();

        var data = {
            targetname: targetname,
            row_id: row_id,
            invoiceid: invoiceid,
            totalprice:totalprice,
            product_category:product_category,
            targetvalue:targetvalue,
            optionid:project_id,
        };
        console.log(data);
        //return false;      
        $.ajax({
            url: "<?=$_cancel?>/invoiceajaxEdit",
            type: 'post',
            data: data,
            global:false,
            success: function(res) {
                var datareturn = JSON.parse(res);
                if(datareturn.status == 'success') {
                    var new_option = datareturn.new_option;
                    if(new_option == 'yes'){
                        var optionid = datareturn.optionid;
                        var maindiv = '#custom_box_'+project_id;
                        $(maindiv).attr('id','custom_box_'+optionid);
                        var new_maindiv = $('#custom_box_'+optionid);
                        new_maindiv.attr('did',optionid);
                        new_maindiv.find('.add_field_button2').attr('data-cat',optionid);
                        new_maindiv.find('.clone_row').attr('data-project-id',optionid);
                        new_maindiv.find('.delete_row').attr('data-project-id',optionid);
                        new_maindiv.find('select[name=product_category]').attr('id','product_category_'+optionid);
                        new_maindiv.find('table#child_table_'+project_id).attr('id','child_table_'+optionid);
                        new_maindiv.find('table#child_table_'+optionid).attr('data-did',optionid);
                        new_maindiv.find('#child_input_next_'+project_id).attr('id','child_input_next_'+optionid);
                        new_maindiv.find('table#child_table_'+optionid+' tr#'+target_tr_id).attr('data-project-id',optionid); 
                        new_maindiv.find('table#child_table_'+optionid+' tr#'+target_tr_id+' a.delete').attr('data-main-id',optionid);
                        new_maindiv.find('#id_order_total_'+project_id).attr('id','id_order_total_'+optionid);
                    }
                    if(row_id == 'create_new'){
                        var addedid = datareturn.added_row;
                        calltr.attr('data-product-id',addedid);
                        $.each(updatearray, function(index, value) {
                            calltr.find('#'+value+'_create_new').attr('id',value+'_'+addedid);
                            calltr.find('#'+value+'_'+addedid).attr('data-id',addedid);
                        });
                        calltr.find('#total_row_create_new').attr('id','total_row_'+addedid);                        
                        calltr.find('a.delete').attr('data-product-id',addedid);
                        calltr.find('a.delete').attr('onclick',"return confirm_box_row(this,'created')");
                    }
                }
                else {
                    alertmodal('error',"Error Processing your Request!!");
                    location.reload();
                }
            },
            error: function(e) {
                alertmodal('error',"Error Processing your Request!!");
                location.reload();
            }
        });
    }
    // to delete table row 
    function confirm_box_row(selfvar,type) {
        var datacounter = $(selfvar).attr('data-counter');
        var mainid = $(selfvar).attr('data-main-id');
        var product_id = $(selfvar).attr('data-product-id');
        
        Swal.fire({
          title: 'Are you want to delete?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
                               
                if(type == 'placed') {                
                    var data = {
                        type:type,
                        mainidoption: mainid,
                        product_id: product_id,
                        invoiceid: '<?=$main_project_id?>',
                    }
                    $.ajax({
                        url: "<?=$_cancel?>/deleterowdata",
                        type: 'post',
                        data: data,
                        success: function(res) {
                            location.reload();
                        },
                        error: function(e) {
                            alertmodal('error',"Error Processing your Request!!");
                            location.reload();
                        }
                    });
                }
                else {
                    location.reload();
                }
          }
        });          
    }    
    // to delete option 
    function confirm_box(selfvar) {
        var mainid = $(selfvar).attr('data-project-id');       
        Swal.fire({
          title: 'Are you want to delete?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var data = {
                    mainidoption: mainid,
                    maincat:'<?=$setproject->id?>',
                }
                $.ajax({
                    url: "<?=$_cancel?>/deleteoptiondata",
                    type: 'post',
                    data: data,
                    success: function(res) {
                        location.reload();
                    },
                    error: function(e) {
                        alertmodal('error',"Error Processing your Request!!");
                        location.reload();
                    }
                });
            }
        }); 
    }
    // to calculate option price
    function calculateTotalPrice(productid) {
        var tablemain = $('#child_table_'+productid);
        var totalPrice = 0;
        var moreex = <?=$moreex?>;
        var expences = <?=$expences?>;
        var percent = <?php if($percent) {echo $percent;} else {echo 0;} ?>;
        var income = <?=floatval($setproject->incomen)?>; 
        
        var spans =  tablemain.find("[data-name='tot']");
        for (var j = 0; j < spans.length; j++) {
            if (parseFloat(spans[j].innerHTML) > 0) {
                totalPrice += parseFloat(spans[j].innerHTML);
            }
            
        }
        
        var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
        });
        
        if(percent > 1) {newTotal = totalPrice+moreex+(totalPrice+moreex)*percent/100; income = (totalPrice+moreex)*percent/100;} else { newTotal = totalPrice+moreex; }
        
        
        $('#id_order_total_'+productid).html(formatter.format(totalPrice));
        $('#id_order_mtotal_'+productid).html(formatter.format(newTotal));
        $('#id_order_exp_'+productid).html(formatter.format(expences));
        $('#id_order_income_'+productid).html(formatter.format(income));
        
        return totalPrice;
    }    
    // to editable option inputs
    function initalizeeditable(){
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editable.defaults.showbuttons = false;
        $.fn.editable.defaults.onblur = 'submit';
        
        $('.edittext').editable();
        $('.xedit').editable();
        //selectRefresh();
    }
    // to addnew option
    function addNewCategory() {
        var createdid = parseInt($("#customcreated").val());
        var created_div = 'custom_box_created_'+createdid;
        
        var newCategory = '<div class="separator"></div><div id="custom_box_created_'+createdid+'" class="cst_box my-5" style="width: 100%;overflow-x: scroll;" data-child-ids="" did="created_'+createdid+'">';
        newCategory += '    <button data-cat="created_'+createdid+'" class="add_field_button2 btn btn-light-primary rounded-0 btn-sm my-1 me-3"><i class="fa fa-plus"></i>Add row</button>';        
        newCategory += '    <a class="clone_row btn btn-light-warning rounded-0 btn-sm my-1 me-3" href="javascript:" data-project-id="created_'+createdid+'"><i class="fa fa-clone"></i>Clone option</a>';
        newCategory += '    <a class="delete_row btn btn-light-danger rounded-0 btn-sm my-1 me-3" data-project-id="created_'+createdid+'" href="javascript:" onclick="return confirm_box(this);"><i class="fa fa-trash"></i>Delete</a>';
        newCategory += '    <?= select_for_invoice($main_categories, $all_categories, '', '', "product_category","") ?>';
        newCategory += '    <table id="child_table_created_'+createdid+'" class="table align-middle table-row-dashed fs-6 gy-5 mb-0 thirdtable" data-did="created_'+createdid+'">';
        newCategory += '        <thead>';         
        newCategory += '            <?= create_invoice_tr("s-item border-bottom fs-6 fw-bolder text-muted",$thisbranch->metric) ?>';       
        newCategory += '        </thead>';
        newCategory += '        <tbody class="fw-bold text-gray-600 input_fields_wrap">';
        newCategory += '        </tbody>';
        newCategory += '   </table><input type="hidden" id="child_input_next_created_'+createdid+'" value="1">';
        newCategory += '   <div class="fs-3 text-muted fw-bolder text-end pt-4">Sub Total : <span class="text-muted" id="id_order_total_created_'+createdid+'">0.00</span></div><div class="fs-3 pt-4 text-dark fw-bolder text-end">Total : <span class="text-dark fs-3 fw-boldest text-end" id="id_order_mtotal_'+createdid+'">0.00</span></div>';
        newCategory += '<div>';
        $("#id_products_div").append(newCategory);

        $('#'+created_div).find('select[name=product_category]').attr('id','product_category_created_'+createdid);
        var createdincrement = createdid+parseInt(1);
        $("#customcreated").val(createdincrement);

        selectRefresh();
        
    }
    $(document).ready(function() {
        var max_fields = 31; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button2"); //Add button ID
        var x = 1;
        var kpd = 1;
        initalizeeditable();
        category = '<?=$category_id?>';
        product_category = $("#id_product_category").val();
        $('div#id_products_div').find("div:nth-child(1) select[name='product_category']").val(product_category);
        productOptions = "<?=str_replace('"','',$productOptions)?>";
        // clone row
        $(document).on('click', '.clone_row', function() {
            var cat_id = $(this).data('project-id');            
            var callingid = '#custom_box_'+cat_id;
            var childids = $(callingid).data('child-ids');
            var data = {
                cat_id: cat_id,
                maincat:'<?=$setproject->id?>',
            };
            $.ajax({
                url: "<?=$_cancel ?>/cloneoption",
                type: 'post',
                data: data,
                success: function(res) {
                    var datareturn = JSON.parse(res);
                    if(datareturn.status == 'success'){
                        $('#id_products_div').html(datareturn.data);
                        initalizeeditable();
                        selectRefresh();
                    }
                    else {
                        alertmodal('error',datareturn.message);
                        location.reload();
                    }
                },
                error: function(e) {
                    alertmodal('error','Error Processing your Request!!');
                    location.reload();
                }
            });
         });                 
        // submit after changing product row
        $(document).on('change', 'select[name="sproduct"]', function() {
            var targettr = $(this).parents('tr');
            var target_tr_id = targettr.attr('id');
            var targetname = $(this).attr('name');
            var valuesubmitted = $(this).val();
            var invoiceid = '<?php echo $main_project_id;?>';
            var row_id = targettr.attr('data-product-id');
            var project_id = targettr.attr('data-project-id');
            callajax(targetname,valuesubmitted,project_id,row_id,invoiceid,target_tr_id);
            return false;            
        });
        // submit on changing colors in row
        $(document).on('change', '.colordropdown', function() {
            var targettr = $(this).parents('tr');
            var target_tr_id = targettr.attr('id');            
            var targetname = $(this).attr('name');
            var valuesubmitted = $(this).val();
            var invoiceid = '<?php echo $main_project_id;?>';
            var row_id = targettr.attr('data-product-id');
            var project_id = targettr.attr('data-project-id');
                       
            callajax(targetname,valuesubmitted,project_id,row_id,invoiceid,target_tr_id);
            return false;
        });
        // submit on adding value in editbale input in row
        $(document).on('change', '.editable-input input.input-sm', function(e) {
            var targettr = $(this).parents('tr');
            //var editform = $(this).parents('form.editableform').find('.input-sm');
            var editable_open = targettr.find('td.editable-open').attr('data-name');
            //var targettr = $(e.target).parent('tr');
            var target_tr_id = targettr.attr('id');
            var valuesubmitted = $(this).val();
            var targetname = editable_open;
            var invoiceid = '<?php echo $main_project_id;?>';
            var row_id = targettr.attr('data-product-id');
            var project_id = targettr.attr('data-project-id');
            var calltable = '#child_table_'+project_id;
            if(targetname == 'qty'){
                var check_qty = valuesubmitted;
                var check_uprice = $(calltable+' tr#'+target_tr_id+' #uprice_'+row_id).text();
                var productTotalPrice = '0.00';
                if (parseFloat(check_uprice) > 0 && parseFloat(check_qty) > 0) {
                    productTotalPrice = parseFloat(check_uprice) * parseFloat(check_qty);
                    $(calltable+' tr#'+target_tr_id+' #total_row_'+row_id).html(productTotalPrice);
                }
            }
            else if(targetname == 'uprice'){
                var check_qty = $(calltable+' tr#'+target_tr_id+' #qty_'+row_id).text();
                var check_uprice = valuesubmitted;
                var productTotalPrice = '0.00';
                if (parseFloat(check_uprice) > 0 && parseFloat(check_qty) > 0) {
                    productTotalPrice = parseFloat(check_uprice) * parseFloat(check_qty);
                    $(calltable+' tr#'+target_tr_id+' #total_row_'+row_id).html(productTotalPrice);
                }                
            }            
            callajax(targetname,valuesubmitted,project_id,row_id,invoiceid,target_tr_id);
            return false;
        });
        // change products data according to category select
        $(document).on("change", "select[name='product_category']", function() {
            var tk = $(this);
            var product_category = $(this).val();
            var data = {
                category: product_category,
                orderNum: category
            }
            var url = "<?=$_cancel?>/getAjaxProducts";
            $.ajax({
                type: 'GET',
                url: url,
                data: data,
                success: function(response) {
                    res = JSON.parse(response);
                    products = res.categorieslist;
                    colorcode = res.colorcode;
                    
                    productOptions = "<option value=''>SELECT</option>";
                    for (var i = 0; i < products.length; i++) {
                        productOptions += "<option value='" + products[i].id + "'>" + products[i].title + "</option>";
                    }
                    if ($(tk).parent().parent().hasClass('custom_box')) {
                        var selects = $(tk).parent().parent().find("select[name='sproduct']");
                        var fselects = $(tk).parent().parent().find("select[name='fcolor']");
                    } else {
                        var selects = $(tk).parent().find("select[name='sproduct']");
                        var fselects = $(tk).parent().find("select[name='fcolor']");
                    }
                    for (var i = 0; i < selects.length; i++) {
                        selects[i].innerHTML = productOptions;
                        fselects[i].innerHTML = colorcode;
                    }

                    
                }
            });
        });
        
        
        
    
        
        
        $(".colordropdown").on("select2:open", function (e) {
            //$("span.select2-container--open").addClass('select2-container--default')
        });
        
        
        
        
        // add new row
        $(document).on("click", ".add_field_button2", function() {
            //$(".colordropdown").select2("destroy");
            var mainoptionid = $(this).attr('data-cat');
            if($("#product_category_"+mainoptionid).val() == ''){
                alertmodal('error',"Please select product category first.");
                return false;
            }
            
            var optiontable = $('#child_table_'+mainoptionid);
            var ts = $(this).parent();
            var wrap = optiontable.find('.input_fields_wrap');
            var colorOptions = '<?=$colorcode?>';
            var colorOptions2 = '<?=$colorcode2?>';		
            var productOptions = optiontable.find('select[name="sproduct"]').html();
            var tl = $('#child_input_next_'+mainoptionid).val();        
            j = parseInt(tl);
            if (j < max_fields) { 
                $html = '<tr id="child_tr_' + j + '" data-product-id="create_new" data-project-id="'+mainoptionid+'" data-counter="' + j + '" ><td class="nm" style="max-width: 30px;">' + j + '</td>\
                                <td align="center">\
                                    <select data-row-id="' + j + '" data-id="create_new" name="sproduct" id="sproduct_create_new" aria-label="Please select" data-allow-clear="true" data-control="select2" data-placeholder="Please select" class="form-select form-select-solid form-select-lg fw-bold" >' + productOptions + '\
                                    </select>\
                                </td>\
                                <td class="xedit" id="dimensions_create_new" data-id="create_new" data-row-id="' + j + '" data-name="dimensions">\
                                  Empty\
                                </td>\
                                <td align="center">\
                                        <select name="scolor" data-id="create_new" data-row-id="' + j + '" aria-label="Please select" data-allow-clear="true" data-control="select2" data-placeholder="Please select" class="form-select form-select-solid form-select-lg fw-bold colordropdown" id="scolor_create_new" >' + colorOptions2 + '\
                                        </select>\
                                 </td>\
                                <td class="cvc" align="center" id="" data-name="fcolor">\
                                    <select aria-label="Please select" data-allow-clear="true" data-control="select2" data-placeholder="Please select" class="form-select form-select-solid form-select-lg fw-bold colordropdown" id="fcolor_create_new" name="fcolor" data-row-id="' + j + '" data-id="create_new"  >' + colorOptions + '\
                                    </select>\
                                </td>\
                                <td class="xedit" style="max-width: 105px;" id="motorauto_create_new" data-id="create_new" data-row-id="' + j + '" data-name="motorauto">\
                                        \
                                </td>\
                                <td class="xedit" style="max-width: 101px;" id="additional_create_new" data-id="create_new" data-row-id="' + j + '" data-name="additional">\
                                       \
                                </td>\
                                <td class="xedit" style="max-width:45px;" id="qty_create_new" data-id="create_new" data-row-id="' + j + '" data-name="qty">\
                                        1\
                                </td>\
                                <td class="xedit" style="max-width:60px;" id="uprice_create_new" data-id="create_new" data-row-id="' + j + '"  data-name="uprice">\
                                        \
                                </td>\
                                <td id="total_row_create_new" data-name="tot" style="max-width:60px;">\
                                        0\
                                </td>\
                                <td><a href="javascript:" data-product-id="create_new" data-counter="' + j + '" data-main-id="'+mainoptionid+'" onclick="return confirm_box_row(this,\'created\');" id="custom_delete_row_' + j + '"  class="btn btn-light-danger rounded-0 btnsml delete"><i class="fa fa-trash"></i></a></td>\
                            </tr>';

                wrap.append($html);
                var entryinput = parseInt(tl)+1;
                $('#child_input_next_'+mainoptionid).val(entryinput)
          
                $('#child_table_'+mainoptionid+' #child_tr_' + j).find('select[name="sproduct"]').val('');
                
                //var tkk = wrap.find('tr').length;            
                if (parseInt(tl) <= 1) {
                    setTimeout(function() {
                        ts.find('[name="product_category"]').change();
                    }, 500);
                }            
                initalizeeditable();
                selectRefresh();
                        
                j++;      
            }
            kpd++;
        });     
        $('.custom_box').each(function() {
            var ct = $(this).attr('cat');
            $(this).find('[name="product_category"]').val(ct).change();
        });
       // $('.cleditor2').summernote({
       //     height: 100
       // });
    });
    // to save invoice notes
    function updateInvoiceNotes() {
        $("span.indicator-label").hide();
        $("span.indicator-progress").show();
        
        var data = {
            category_id: category,
            notes: $('#form_editor_notefor_client').val(),
            tax: $('#tax').val(),
            shipping: $('#shipping').val(),
            transportation: $('#transportation').val(),
            insurance: $('#insurance').val(),
            incomen: $('#incomen').val(),
            install: $('#installation').val(),
            internal: $('#form_editor_internal_notes').val(),
            extra: $('#extra').val()

        }

        $.ajax({
            url: "<?=$_cancel?>/updateInvoiceNotes",
            type: 'post',
            data: data,
            success: function(s) {
                location.reload();
            },
            error: function(e) {
                alertmodal('error',"Error Processing your Request!!");
                $("span.indicator-label").show();
                $("span.indicator-progress").hide();
            }
        });
    }
    // to sendinvoice 
    function sendInvoice(w) {
        
        if (w > 0) {
            var wp = 1;
            var answer = confirm("Invoice will be send to client with Detailed Prices");	    
	        if (!answer)
                return false;
        } else {
        
            var wp = 0;
	        var answer = confirm("Do you think invoice is ready to send it to client?");	    
	    if (!answer)
            return false;
            
        }
	    
	    var email = '<?=$setproject->email?>';
	    var invoice_id = '<?=$setproject->id?>';
	    var buyer = '<?=$setproject->buyer ?>';
	    var link = '<?=$setproject->link ?>';
	    var sender = '<?=$adminDetails->employee_id?>';
	    var emp_email = '<?=$thisemploee->email?>';
	    
	    
	    
	    var data = {
                email: email,
                invoice_id: invoice_id,
                buyer:buyer,
                link:link,
                sender:sender,
                wp:wp,
                emp_email:emp_email
                
            };
        $.ajax({
            url: "<?=$_cancel?>/send_invoice_mail",
            type: 'get',
            data: data,
            success: function(res) {
                alertmodal('error',"This Email already Sent to client !");
                window.location.href = '<?=$admin_link?>/invoice';
            },
            error: function(e) {
                alertmodal('error',"Error Processing your Request!!");
            }
        });
	}



    function sendInvoicePDF(w) {
        var invoicelink = '<?=$setproject->link?>';

        if (w > 0) {
            var wp = 1;
            var answer = confirm("Invoice will be send to client with Detailed Prices");	    
	        if (!answer)
                return false;
        } else {
        
            var wp = 0;
	        var answer = confirm("Do you think invoice is ready to send it to client?");	    
	    if (!answer)
            return false;            
        }

        //$("#sendInvoicePDF").text("Processing...");
	    var email = '<?=$setproject->email?>';
	    var invoice_id = '<?=$setproject->id?>';
	    var buyer = '<?=$setproject->buyer ?>';
	    var sender = '<?=$adminDetails->employee_id?>';
	    var emp_email = '<?=$thisemploee->email?>';    
	    
	    var data = {
                email: email,
                invoice_id: invoice_id,
                buyer:buyer,
                sender:sender,
                wp:wp,
                emp_email:emp_email,
                invoicelink: invoicelink,                
            };
        $.ajax({
            url: "<?=$_cancel?>/send_invoice_with_pdf",
            type: 'post',
            data: data,
            success: function(res) {
                $("#sendInvoicePDF").text("Send Email with PDF");
                if(res == '1'){
                    alertmodal('error',"This Email Sent to client !");
                    window.location.href = '<?=$admin_link?>/invoice';
                }
                else {
                    alertmodal('error',"Something not right.");
                }
            },
            error: function(e) {
                $("#sendInvoicePDF").text("Send Email with PDF");
                alertmodal('error',"Error Processing your Request!!");
            }
        });
	}


    
</script>
