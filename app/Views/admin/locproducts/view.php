<?php
    $sizeavail = explode(",",$thisItems->size);
    $colorsavail = explode(",",$thisItems->colors);
    $total_variant = 0;
    if($sizeavail[0] != ''){
        $total_variant++;
    }
    if($colorsavail[0] != ''){
        $total_variant++;
    }
?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <?=view('admin/includes/cartmenu')?>
                        
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Form-->
            <?=view('admin/includes/common/errors')?>
            <?=form_open_multipart('', 'class="form d-flex flex-column flex-lg-row editform" id="editform" name="editform"')?>
                <!--begin::Aside column-->
                
                <div class="d-flex flex-column gap-7 gap-lg-10 min-w-300px w-300px w-lg-300px mb-7 me-lg-10">
                    <?php if(count($moreFiles)>0) {?>
                        <div class="card card-flush p-0">
                            <div class="card-body text-center p-0">
                                <div class="carousel slide" data-bs-ride="carousel" id="carousel-<?=$thisItems->id?>">
                                    <div class="carousel-inner">
                                        <?php  $counter = 1; foreach($moreFiles as $file) { ?>
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-250px carousel-item <?=($counter == 1)?"active":""?>" style="background-image:url('assets/uploads/locproducts/<?=$file->filename?>')"></div>
                                        <?php $counter++;} ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!--end::Aside column-->
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2><?=$thisItems->title?></h2>
                            </div>
                            <?php if($thisItems->nprice > 0) { ?>
                            <div class="card-toolbar">
                                <a data-loading-text="Loading..." data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-original-title="Add to cart" onclick="cart.add(this);" class="btn btn-sm btn-primary" data-original-title="Add to Cart" value="Add to Cart" data-product-id="<?=$thisItems->id?>" data-product-price="<?=$thisItems->nprice?>" data-total-varient="<?=$total_variant?>">
                                    <i class="fa fa-shopping-cart"></i> Add to Cart
                                </a>                        
                            </div>
                            <?php } ?>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            
                            <!--begin::Input group-->            
                            <div class="mb-10 fv-row">                                            
                                <div class="fs-6 fw-bolder mt-3 d-flex flex-stack">
                                    <span class="badge fs-2 fw-bolder text-dark p-0">
                                    <span class="fs-6 fw-bold text-gray-400">$</span><?=($thisItems->nprice>0)?$thisItems->nprice:0?></span>
                                </div>
                            </div>
                            <div class="mb-10 fv-row">
                                <?=readmorestring($thisItems->body,'javascript:',200)?>
                            </div>
                            <div class="mb-10 fv-row" id="variants">

                                
                                                
                                <div class="row border p-1 py-3 mb-10">
                                    
                                    <div class="col-lg-4">
                                        <label class="d-block mb-3 fw-bolder">
                                            Quantity
                                        </label>
                                        <div class="input-group input-group-solid mb-5">
                                            <span class="cursor-pointer input-group-text value-button decrease_"><i class="fas fa-minus"></i></span>
                                            <input type="number" class="text-center form-control quantity" name="quantity" id="quantity_<?=$thisItems->id?>" value="1">
                                            <span class="cursor-pointer input-group-text value-button increase_"><i class="fas fa-plus"></i></span>
                                        </div>
                                    </div>
                                </div>
                                    
                                <?php if($sizeavail[0] != ''){ ?>
                                    <div class="row border p-1 py-3  mb-10">
                                        <label class="d-block mb-3 fw-bolder">
                                            Size
                                        </label>
                                    <?php foreach($all_sizes as $key=>$value) { if(in_array($value->id,$sizeavail)) { ?>
                                        <div class="col-lg-3">
                                            <!--begin::Option-->
                                            <input type="radio" class="btn-check choose_option" data-product="<?=$thisItems->id?>" class="choose_option" name="option_size" data-avail-quntity="<?=$thisItems->count?>" data-option-name="size" data-amount="<?=$thisItems->nprice?>" value="<?=$value->id?>" id="label_variant_size_<?=$value->id?>">
                                            <label class="btn btn-outline btn-outline-dashed btn-outline-default p-3  mb-3" for="label_variant_size_<?=$value->id?>">
                                                <span class="d-block fw-bold text-center">
                                                    <span class="text-dark fw-bolder d-block fs-8"><?=$value->title?></span>
                                                </span>
                                            </label>
                                        </div>
                                    <?php } } ?>
                                    </div>
                                <?php } ?>
                           
                                <?php if($colorsavail[0] != ''){ ?>
                                    <div class="row border p-1 py-3 mb-10">
                                        <label class="d-block mb-3 fw-bolder">
                                            Color
                                        </label>
                                    <?php foreach($all_colors as $key=>$value) { if(in_array($value->id,$colorsavail)) { ?>
                                        <div class="col-lg-2">
                                            <!--begin::Option-->
                                            <input type="radio" class="btn-check choose_option" data-product="<?=$thisItems->id?>" class="choose_option" name="option_color" data-avail-quntity="<?=$thisItems->count?>" data-option-name="color" data-amount="<?=$thisItems->nprice?>" value="<?=$value->id?>" id="label_variant_color_<?=$value->id?>">
                                            <label class="btn btn-outline btn-outline-dashed btn-outline-default p-1 d-block mb-3" for="label_variant_color_<?=$value->id?>">
                                                <span class="d-block fw-bold text-center">
                                                    <span class="text-dark fw-bolder d-block fs-8"><?=$value->title?></span>
                                                </span>
                                            </label>
                                        </div>
                                    <?php } } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->
                </div>
                <!--end::Main column-->
            <?=form_close()?>
            <!--end::Form-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<input type="hidden" name="size_product_id" id="size_product_id" value="0">
<input type="hidden" name="color_product_id" id="color_product_id" value="0">
<input type="hidden" name="varient_avail_quntity" id="varient_avail_quntity" value="<?=$thisItems->count?>">
<input type="hidden" name="total_varient" id="total_varient" value="<?=$total_variant?>">
<input type="hidden" name="main_product_id" id="main_product_id" value="<?=$thisItems->id?>">
<?=view('main/common/addtocart')?>