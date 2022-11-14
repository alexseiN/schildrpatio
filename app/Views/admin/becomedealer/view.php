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
                        <label class="col-lg-4 fw-bold text-muted">Company</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'company'}?></span>
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
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Area (in miles) you operate in or counties/states name</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'areamiles'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Company website</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'website'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Facebook</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'facebook'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Instagram</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'instagram'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Linkedin</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'linkedin'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Commercial projects quantity per year</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'comprq'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Residential projects quantity per year</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'resprq'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Numbers of Sales employees</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'salem'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Numbers of Installation employees</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'instem'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Which of our products you are interested in</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$string?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Which products you work with previously and brand names</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'prevbrand'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">What’s your monthly advertising budget</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'adbudget'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Your lead flow mainly comes from ?</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'comesfrom'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">How did you found us</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'howfindus'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Areas</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'areas'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Comments</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'comments'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Do you currently resell and/or install awning products ?</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'q1'}?></span>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Do you own and operate a shop or showroom ?</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'q2'}?></span>
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