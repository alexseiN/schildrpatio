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
                                <h2><i class="fa fa-credit-card me-2"></i> Payment Method</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">                            
                            <p>Please select the preferred payment method to use on this order.</p>
                            <div class="form-check form-check-custom form-check-solid">
								<input class="form-check-input" type="radio" value="1" id="COD" checked="checked" />
								<label class="form-check-label" for="COD">
									Cash On Delivery
								</label>
							</div>   
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->
                    
                    
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2><i class="fa fa-shopping-cart me-2"></i>Shopping Cart</h2>
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
                    <?php if(count($cartitems)>0) { ?>
                    <div class="d-flex justify-content-end">
                        <a href="javascript:" id="confirm_order" class="btn btn-primary"><i class="fas fa-bags-shopping"></i>Place Order</a>
                    </div>
					<?php } ?>
                </div>
                <!--end::Main column-->
            <?=form_close()?>
            <!--end::Form-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>