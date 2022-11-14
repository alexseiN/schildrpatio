<?php
    error_reporting(0);
    $pids = explode(',',$thisItems->pid);
    $incat = get_langer('pdcats',$admin_lang,$thisItems->incat);
    $catmain = get_langer('pdcats',$admin_lang,$incat->parent_id);
    $thisbranch = get_langer('branches',$admin_lang,$thisItems->branch_id);  
?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Products</h3>
                    </div>
                </div>
                <div class="card-body p-9">
                    <div class="row mb-7">
                        <?php if(!$thisItems->pid){ ?>
                            <div class="col-lg-12">
                                <span class="fw-bolder fs-6 text-gray-800">No data found.</span>
                            </div>
                        <?php } ?>
                        <?php if($thisItems->pid){ foreach ($pids as $pid) { $product = get_langer('product',$admin_lang,$pid); ?>
                        <!--begin::Col-->
                        <div class="col-xl-3">
                            <div class="pt-1">
                                <div class="mixed-widget-4-chart" data-kt-chart-color="success" style="">
                                    <img src="assets/uploads/products/full/<?=$product->image?>" style="width:100%;height:100%"> 
                                </div>
                            </div>
                            <div class="pt-5">
                                <span class="fw-normal fs-6 text-gray-800"><?=$product->title?></span>
                            </div>
                        </div>
                        <!--end::Col-->
                        <?php } } ?>
                    </div>
                </div>
            </div>
            
            <div class="card mb-5 mb-xl-10">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0"><?=$catmain->title.(($catmain->title != '')?' - ':'').$incat->title?></h3>
                    </div>
                </div>
                <div class="card-body p-9">
                    <div class="row mb-7">
                        <div class="col-lg-12">
                            <span class="fw-normal fs-6 text-gray-800">Width: <b><?=$thisItems->width?></b>, Depth: <b><?=$thisItems->depth?></b>  Height: <b><?=$thisItems->height?></b></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-5 mb-xl-10">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Contact</h3>
                    </div>
                    <a href="<?=$admin_link?>/invoice/createInvoice/<?=$thisItems->id; ?>" class="btn btn-primary align-self-center">Edit invoice</a>
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
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Address</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=$thisItems->{'address'}?></span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-bold text-muted">Message</label>
                        <div class="col-lg-8">
                            <span class="fw-bolder fs-6 text-gray-800"><?=makeUrltoLink($thisItems->{'message'})?></span>
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