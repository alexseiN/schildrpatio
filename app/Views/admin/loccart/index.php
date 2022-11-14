<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <?=view('admin/includes/cartmenu')?>
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Form-->
            <?=view('admin/includes/common/errors')?>
            <?=form_open_multipart('', 'class="form d-flex flex-column flex-lg-row editform" id="editform" name="editform"')?>
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2><i class="fa fa-shopping-cart me-2"></i> <?=$name?></h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">                            
                            <?=view('admin/loccart/listcart')?>
                               
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->
                    <div class="d-flex justify-content-end">
                        <a href="<?=$_storelink?>" target="_BLANK" class="btn btn-light me-5">Continue Shopping</a>
                        <?php if(count($cartitems)>0) { ?>
                            <a href="<?=$_checkoutlink?>" class="btn btn-primary"><i class="fas fa-bags-shopping"></i>Checkout</a>
                        <?php } ?>
                    </div>

                </div>
                <!--end::Main column-->
            <?=form_close()?>
            <!--end::Form-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>