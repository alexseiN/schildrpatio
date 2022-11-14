<?php
$thisEmployee = get_langer('employees',false,$adminDetails->employee_id);
$thisbranch = get_langer('branches',$admin_lang,$thisEmployee->branch_id);

$status = select_status2($setproject->id,$setproject->view);

$extratotal = floatval($setproject->tax) + 
              floatval($setproject->shipping) + 
              floatval($setproject->transportation) + 
              floatval($setproject->insurance) + 
              floatval($setproject->extra) + 
              floatval($setproject->install) ;
              
              
              if(substr($setproject->incomen, -1) == '%') {
    
    

    $percent = floatval(substr($setproject->incomen, 0, -1));
    
   
    

} else {

    $incomen = floatval($setproject->incomen);
    
    $extratotal= $extratotal + $incomen;

}
              
              

$included = array();
if (floatval($setproject->tax)) { array_push($included,'Tax');}
if (floatval($setproject->shipping)) { array_push($included,'Shipping');}
if (floatval($setproject->install)) { array_push($included,'Installation');}
if (floatval($setproject->insurance)) { array_push($included,'Insurance');}
$thisemploee = get_langer('employees',false,$setproject->employee);
$thisbranch = get_langer('branches',8,$thisemploee->branch_id);  
$thisregion = get_langer('regions',8,$thisbranch->region_id);
$thiscurrency = get_langer('currency',false,$thisbranch->currency);
$branchtel = explode(',',$thisbranch->phones);
$subcatm = get_langer('pdcats',8,$setproject->product_category);
$maincatm = get_langer('pdcats',8,$subcatm->parent_id);

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
                <div class="card-body py-10 sentconfirm">
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
                        <!--begin::Body-->
                        <div class="pb-6">
                            <div class="d-flex flex-column gap-7 gap-md-10">
                                <div class="d-flex justify-content-between flex-column">
                                    <div class="table-responsive border-bottom mb-3">
                                        <div class="separator"></div>
                                        <div class="cst_box my-5" style="width: 100%;overflow-x: scroll;">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                <thead>
                                                    <tr class="s-item headmy border-bottom fs-6 fw-bolder text-muted">
                                                        <th scope="col" class="nm">No</th>
                                                        <th scope="col" class="pn">Product Name</th>
                                                        <th scope="col" class="dm">Dimension (<?=$thisbranch->metric?>)</th>
                                                        <th scope="col" class="stc">Structure Color</th>
                                                        <th scope="col" class="cvc">
                                                            <?php if($maincatm->secolorcats) {echo 'Glass Type';} else { echo 'Cover Color';}?>
                                                        </th>
                                                        <th scope="col" class="ma">Motor Automation</th>
                                                        <th scope="col" class="des">Description</th>
                                                        <th scope="col" class="qt">Qty</th>
                                                        <th scope="col" class="qt">Unit Price</th>
                                                        <th scope="col" class="qt">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody-list">
                                                    <?php
                                                        $i=1; $total = 0; $selprods = orinpro($selprods);
                                                        foreach($selprods as $selprod) {
                                                            $thisproduct = get_langer('product',8,$selprod->sproduct);
                                                            $total = $total + $selprod->uprice*$selprod->qty;
                                                            $scolor = get_langer('colors',8,$selprod->scolor);
                                                            $fcolor = get_langer('colors',8,$selprod->fcolor);
                                                    ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td><b><?=$thisproduct->title?></b></td>
                                                        <td><?=$selprod->dimensions?></td>
                                                        <td>
                                                            <?php if($scolor->image) { ?>
                                                            <img width="20px" height="20px" src="assets/uploads/colors/small/<?=$scolor->image?>"/>
                                                            <?php } ?>
                                                            <?=$scolor->title?></td>
                                                        <td>
                                                            <?php if($fcolor->image) { ?>
                                                            <img width="20px" height="20px" src="assets/uploads/colors/small/<?=$fcolor->image?>"/>  
                                                            <?php } ?>
                                                            <?=$fcolor->title?></td>
                                                        <td><?=$selprod->motorauto?></td>
                                                        <td><?=$selprod->additional?></td>
                                                        <td><?=$selprod->qty?></td>
                                                        <td><?=$selprod->uprice?></td>
                                                        <td><?=$selprod->qty*$selprod->uprice?></td>
                                                    </tr>
                                                    <?php $i++; } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php
                                            $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
                                            $subtotal = $fmt->formatCurrency($total, "USD");
                                            
                                            if ($percent) { $newTotal = $total + $extratotal + ($total + $extratotal)*$percent/100; } else { $newTotal = $total + $extratotal; } 
                                            
                                            $totalmoney = $fmt->formatCurrency(($newTotal), "USD");
                                        ?>
                                        <div class="fs-3 text-muted fw-bolder text-end pt-4">Sub Total : <span class="text-muted" ><?=$subtotal?></span></div>
                                        <div class="fs-3 text-muted fw-bolder text-end pt-4">Expences : <span class="text-muted" ><?=$extratotal?></span></div>
                                        <div class="fs-3 text-muted fw-bolder text-end pt-4">Markup : <span class="text-muted" ><?=($total + $extratotal)*$percent/100?></span></div>
                                        <div class="fs-3 pt-4 text-dark fw-bolder text-end">Total : <span class="text-dark fs-3 fw-boldest text-end" ><?=$totalmoney?></span></div>

                                        <?php
                                        foreach($subprojects as $subproje) {
                                            $subproducts = orinpro(get_table_where('selproducts',array('category_id'=>$subproje->id)));  
                                            $subcat = get_langer('pdcats',8,$subproje->product_category);
                                            $maincat = get_langer('pdcats',8,$subcat->parent_id);
                                        ?>
                                        <div class="separator"></div>
                                        <div class="cst_box my-5" style="width: 100%;overflow-x: scroll;">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                <thead>
                                                    <tr class="s-item headmy border-bottom fs-6 fw-bolder text-muted">
                                                        <th scope="col" class="nm">No</th>
                                                        <th scope="col" class="pn">Product Name</th>
                                                        <th scope="col" class="dm">Dimension (<?=$thisbranch->metric?>)</th>
                                                        <th scope="col" class="stc">Structure Color</th>
                                                        <th scope="col" class="cvc">
                                                            <?php if($maincatm->secolorcats) {echo 'Glass Type';} else { echo 'Cover Color';}?>
                                                        </th>
                                                        <th scope="col" class="ma">Motor Automation</th>
                                                        <th scope="col" class="des">Description</th>
                                                        <th scope="col" class="qt">Qty</th>
                                                        <th scope="col" class="qt">Unit Price</th>
                                                        <th scope="col" class="qt">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $i=1; $total = 0;
                                                        foreach($subproducts as $selprod) {
                                                            $thisproduct = get_langer('product',8,$selprod->sproduct);
                                                            $total = $total + $selprod->uprice*$selprod->qty;
                                                            $scolor = get_langer('colors',8,$selprod->scolor);
                                                            $fcolor = get_langer('colors',8,$selprod->fcolor);
                                                    ?>    
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td><b><?=$thisproduct->title?></b> </td>
                                                        <td><?=$selprod->dimensions?></td>
                                                        <td>
                                                            <?php if($scolor->image) { ?>
                                                            <img width="20px" height="20px" src="assets/uploads/colors/small/<?=$scolor->image?>"/>
                                                            <?php } ?>
                                                            <?=$scolor->title?></td>
                                                        <td>
                                                            <?php if($fcolor->image) { ?>
                                                            <img width="20px" height="20px" src="assets/uploads/colors/small/<?=$fcolor->image?>"/>
                                                            <?php } ?>
                                                            <?=$fcolor->title?></td>
                                                        <td><?=$selprod->motorauto?></td>
                                                        <td><?=$selprod->additional?></td>
                                                        <td><?=$selprod->qty?></td>
                                                        <td><?=$selprod->uprice?></td>
                                                        <td><?=$selprod->qty*$selprod->uprice?></td>
                                                    </tr>
                                                    <?php $i++; } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php
                                            $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
                                            $subtotal = $fmt->formatCurrency($total, "USD");
                                            if ($percent) { $newTotal = $total + $extratotal + ($total + $extratotal)*$percent/100; } else { $newTotal = $total + $extratotal; }
                                            $totalmoney = $fmt->formatCurrency(($newTotal), "USD");
                                        ?>
                                        <div class="fs-3 text-muted fw-bolder text-end pt-4">Sub Total : <span class="text-muted" ><?=$subtotal?></span></div>
                                        <div class="fs-3 text-muted fw-bolder text-end pt-4">Expences : <span class="text-muted" ><?=$extratotal?></span></div>
                                        <div class="fs-3 text-muted fw-bolder text-end pt-4">Markup : <span class="text-muted" ><?=($total + $extratotal)*$percent/100?></span></div>
                                        <div class="fs-3 pt-4 text-dark fw-bolder text-end">Total : <span class="text-dark fs-3 fw-boldest text-end" ><?=$totalmoney?></span></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-5">
                            <!--end::Logo-->
                            <div class="text-sm-start">
                                <div class="text-sm-start text-muted-600 fs-7 my-3">
                                    <h6>IMPORTANT NOTES</h6>
                                    <?php if($total) { ?>
                                    <ul>
                                        <li>
                                            <?php if($extratotal) { ?><b>Option included:</b> <?=implode(', ',$included)?><?php } ?>                                            
                                        </li>
                                    </ul>
                                    <? } ?>
                                </div>
                                <!--begin::Text-->
                                <div class="text-sm-start text-muted fs-7 my-3" id="id_invoice_notes">
                                    <?=html_entity_decode($setproject->notes)?>                                  
                                </div>
                                <!--end::Text-->
                                <!--begin::Text-->
                                <div class="text-sm-start text-muted-600 fs-7 my-3">
                                    <?=html_entity_decode($thisbranch->about)?>                 
                                </div>
                                <!--end::Text-->
                                <?php if($setproject->invoice == 1){ ?>
                                    <div class="text-sm-start text-muted-600 fs-7 my-3">
                                        <h6>OUR REQUISITES</h6>
                                        <?=html_entity_decode($thisbranch->requisite)?>
                                    </div>
                                <?php } ?>
                                <!--begin::Text-->
                                <div class="text-sm-start text-muted-600 fs-7 my-3">
                                    <h6>EXTRA INFORMATION</h6>
                                    <ul>
                                        <li><b>Tax:</b><?=floatval($setproject->tax)?></li>
                                        <li><b>Shipping:</b><?=floatval($setproject->shipping)?></li>
                                        <li><b>Transportation:</b><?=floatval($setproject->transportation)?></li>
                                        <li><b>Insurance:</b><?=floatval($setproject->insurance)?></li>
                                        <li><b>Extra:</b><?=floatval($setproject->extra)?></li>
                                        <li><b>Install:</b><?=floatval($setproject->install)?></li>
                                        <li><b>Income:</b><?=floatval($setproject->incomen)?></li>
                                    </ul>               
                                </div>
                                <!--end::Text-->

                                                               
                            </div>
                        </div>    
                        <!-- begin::Footer-->
                        <!--begin::Input group-->
                        <div class="mb-2 mt-20 row d-flex justify-content-start">
                            <div class="col-lg-10">
                            <?php                               
                                $data = [
                                    "label"          => "",
                                    "label_required" => "",
                                    "type"           => "input",
                                    "type_data"      => [
                                        'type'  => 'email',
                                        'name'  => 'extraemails',
                                        'id'    => 'extraemails',
                                        'placeholder'=>'Enter more emails by comma',
                                        'value' => '',
                                    ]
                                ];
                                echo html_form_tags($data);
                            ?>
                            </div>
                            <div class="col-lg-2">
                            <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Resend Email"  onclick="return sendInvoice()" class="btn btn-light-primary rounded-0 "><i class="fa fa-envelope"></i>Resend Email</button>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <div class="d-flex justify-content-start mb-5">
                            
                            
                            
                            
                        
                            <div class="col-lg-2"><?=$status?></div>
                            <div class="col-lg-2">
                                <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Follow Up"  onclick="return followUp()" class="btn btn-light-success rounded-0"><i class="fa fa-envelope"></i>Follow Up</button>
                            </div>
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

<style>
    .nm {width:2%!important}
    .pn {width:15%!important}
    .dm {width:15%!important}
    .qt {width:3%!important}
    .stc {width:20%!important}
    .cvc {width:20%!important}
    .ma {width:10%!important}
    .des {width:15%!important}
    .sentconfirm {
        background-image: url('assets/uploads/sites/schildr.document.sent.png');
        background-size: 45% auto;
        background-repeat: no-repeat;
        background-attachment: absolute;
        background-position: right bottom;
    }
</style>
<script>
    function sendInvoice() {
	    var answer = confirm("Do you think invoice is ready to send it to client?");	    
	    if (!answer)
            return false;

	    var mainemail = '<?=$setproject->email?>';
	    var extraemail = $('#extraemails').val();
        if(extraemail.trim() == ''){
            alertmodal('error',"Please enter email first.");
            return false;
        }
	    var email = mainemail+','+extraemail;
	    var count = '<?=$setproject->count?>';
	    var invoice_id = '<?=$setproject->id?>';
	    var buyer = '<?=$setproject->buyer ?>';
	    var link = '<?=$setproject->link ?>';
	    var emp_email = '<?=$thisemploee->email?>';
	    var data = {
                email: email,
                invoice_id: invoice_id,
                buyer:buyer,
                link:link,
                count:count,
                emp_email:emp_email
            };
        $.ajax({
            url: "<?=$_cancel?>/send_invoice_mail",
            type: 'get',
            data: data,
            success: function(res) {
                alertmodal('error','This Email already Sent: ' + email);
            },
            error: function(e) {
                alertmodal('error',"Error Processing your Request!!");
            }
        });
	}
	
	function followUp() {
	    var answer = confirm("Do you think this Client didn't contacted any way with Schildr ?");	    
	    if (!answer)
            return false;

	    var email = '<?=$setproject->email?>';
	    var count = '<?=$setproject->count?>';
	    var invoice_id = '<?=$setproject->id?>';
	    var buyer = '<?=$setproject->buyer ?>';
	    var link = '<?=$setproject->link ?>';
	    var emp_email = '<?=$thisemploee->email?>';
	    var data = {
                email: email,
                invoice_id: invoice_id,
                buyer:buyer,
                link:link,
                count:count,
                emp_email:emp_email
            };
        $.ajax({
            url: "<?=$_cancel?>/followUp_mail",
            type: 'get',
            data: data,
            success: function(res) {
                alertmodal('error','This Email already Sent: ' + email);
            },
            error: function(e) {
                alertmodal('error',"Error Processing your Request!!");
            }
        });
	}
	
	function change_crm_status(id){ 
        
    var status = $('#input_status'+id).val();
    
  //  alert('Status Chnaged'); 

	$.ajax({
		type: "GET",
		url: "<?=$_cancel?>/change_crm_status", /* The country id will be sent to this file */
		data: {status:status,id:id},
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