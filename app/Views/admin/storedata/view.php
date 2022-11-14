<?php
    error_reporting(0);
    $product = get_langer('product',$admin_lang,$thisItems->{'pid'});
    $subcat = get_langer('pdcats',$admin_lang,$product->category);
    
    $products = explode(',',$thisItems->product);
    $string = '';
    foreach ($products as $pd) {
        
        $mycat = get_langer('pdcats',$admin_lang,$pd);
        
        if ($string == '') {$string = $mycat->title;} else {$string = $string.' , '.$mycat->title;}
        
        
        
    }
    
    
    
    $cat = get_langer('pdcats',$admin_lang,$subcat->parent_id);
    $thisbranch = get_langer('branches',$admin_lang,$thisItems->branch_id);
?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">            
            <div class="card mb-5 mb-xl-10">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Details</h3>
                        
                        
                    </div>
                    <a target="_blank" href="https://schildrpatio.com/en/invoice/auto/<?=$thisItems->link?>" class="btn btn-primary align-self-center">View invoice</a>
                    <a target="_blank" href="https://schildrpatio.com/en/invoice/details/<?=$thisItems->link?>" class="btn btn-danger align-self-center">View Details</a>
                </div>
                <div class="card-body p-9">
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Name</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'first_name'}?> <?=$thisItems->{'last_name'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Phone</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'phone'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Email</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'email'}?></span>
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Zipcode</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'zipcode'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">City</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'city'}?></span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Width</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"> <?= usw($thisItems->width,$thisItems->unit) ?> <?=$thisItems->{'unit'}?></span>
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Depth</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"> <?= usw($thisItems->depth,$thisItems->unit) ?> <?=$thisItems->{'unit'}?></span>
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Front Height</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?= usw($thisItems->height1,$thisItems->unit) ?> <?=$thisItems->{'unit'}?></span>
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Back Height</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?= usw($thisItems->height2,$thisItems->unit) ?> <?=$thisItems->{'unit'}?></span>
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Light</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'light'}?Yes:No?> </span>
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Cover Color</label>
                        <div class="col-lg-8">
                            <div style="background-color:<?=$thisItems->{'cover_color'}?>;width:120px;height:20px;"> <span class="fw-bolder fs-6 px-3 py-2 text-white"> <?=$thisItems->{'cover_color'}?> </span> </div>
                            
                            
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Glass texture</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'glass_texture'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Number of Columns</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'number_of_columns'}?></span>
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Message</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'message'}?></span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Discounted</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'discount'}?>%</span>
                        </div>
                    </div>
                    
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Time</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=branchtime($thisItems->{'created'},$thisbranch->diff,'M d,Y h:i')?></span>
                        </div>
                    </div>
                    
                    <button class="btn btn-light-success rounded-0 btn-sm my-1 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Send Email" onclick="sendEmail()">
                        <i class="fa fa-envelope"></i>Send Email
                    </button>
                    
                </div>
                
                
                
                
                
            </div>    
            
            
        </div>
    </div>
</div>

<script>
    
    function sendEmail() {
        var invoicelink = '<?=$thisItems->link?>';
        var email = '<?=$thisItems->email?>';
        var first_name = '<?=$thisItems->first_name?>';
        var last_name = '<?=$thisItems->last_name?>';

        //alert(email);
	    
	    var data = {
                invoicelink: invoicelink,
                email: email, 
                first_name:first_name,
                last_name:first_name,
            };
        $.ajax({
            url: "<?=$_cancel?>/sendAutostore",
            type: 'post',
            data: data,
            success: function(res) {
                
                if(res == '1'){
                    alertmodal('error',"This Invoice Sent to client !");
                    
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