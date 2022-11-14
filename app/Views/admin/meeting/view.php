<?php 
    error_reporting(0);
    $product = get_langer('product',$admin_lang,$thisItems->{'pid'});
    $subcat = get_langer('pdcats',$admin_lang,$product->category);
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
                        <label class="col-lg-4 fw-bold text-muted">Date</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'date'}?></span>
                        </div>
                    </div>                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Time</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'time'}?></span>
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Message</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'message'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Time</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=branchtime($thisItems->{'created'},$thisbranch->diff,'M d,Y h:i')?></span>
                        </div>
                    </div>
                </div>
            </div>             
        </div>
    </div>
</div>

