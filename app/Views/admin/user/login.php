<!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Aside-->
        <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative" style="background-color: #0E1B43;" >
            <!--begin::Wrapper-->
            <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                <!--begin::Content-->
                <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
                    
                
                    
                    
                  
                    <div class="card-body d-flex ps-xl-15">
												<!--begin::Wrapper-->
												<div class="text-start m-0">
												    
												    
												    <!--begin::Logo-->
                                                        <a href="/<?=$admin_link?>" class="py-9 mb-5">
                                                            <img alt="Logo" src="/assets/uploads/sites/<?=$website_settings->logo?>" class="h-50px" style="filter:  brightness(100) invert(0);" alt="<?=$website_settings->author?>" />
                                                        </a>
                                                    <!--end::Logo--> 
                                                    <br>
												    
												    
												    
												    <div class="position-relative z-index-2 fs-1x text-white mb-10 mt-10">
												        
												       
												        
													<span>
													    This page is intended for Schildr partners and affiliates. 
													    If you do not have access to this page, please close the page. 
													    If you want to become a Schildr dealer, then visit the link below.
													</span>
													
													<div class="mb-6 mt-6">
														<a target="_blank" href="https://schildr.com/en/page/become-a-dealer" class="btn btn-color-white bg-body bg-opacity-15 bg-hover-opacity-25 fw-bold me-2"  >Become a Schildr Dealer</a>
														
														
													</div>
													
													</div>
												    
												    
												    
												    
												    
												    
													<!--begin::Title-->
													<div class="position-relative z-index-2 text-white mb-7">
													<span class="me-2">Technical Support by
													<span class="position-relative d-inline-block text-danger">
														<a target="_blank" href="https://oawo.com" class="text-white opacity-75-hover">oawo.com</a>
											
													</span></span>
													<br>Feel free to contact if you have any technical problem</div>
													<!--end::Title-->
													<!--begin::Action-->
													
													
													<div class="mb-3">
														<a target="_blank" href="https://wa.me/+994505008648" class="btn btn-color-white bg-body bg-opacity-15 bg-hover-opacity-25 fw-bold me-2" >Write to Whatsapp</a><br>
														<a target="_blank" href="skype:core.az?chat" class="mt-2 btn btn-color-white bg-body bg-opacity-15 bg-hover-opacity-25 fw-bold">Write to Skype</a><br>
														<a target="_blank" href="https://www.youtube.com/channel/UCJfRSkdyeJkqv_2EjK7s0jQ" class="mt-2 btn btn-danger bg-body bg-opacity-15 bg-hover-opacity-25 fw-bold">Explanation Videos</a><br>
														<a target="_blank" href="" class="mt-2 btn btn-danger bg-body bg-opacity-15 bg-hover-opacity-25 fw-bold">FAQ</a>
														
													</div>
													<!--begin::Action-->
													
													
													
												</div>
												<!--begin::Wrapper-->
												<!--begin::Illustration-->
												<img src="assets/media/illustrations/sigma-1/17-dark.png" class="position-absolute me-3 bottom-0 end-0 h-200px" alt="">
												<!--end::Illustration-->
											</div>
                    
                    
                    
                    
                    <!--end::Description-->
                </div>
                <!--end::Content-->
                <!--begin::Illustration-->
                <!--<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(<?=$admin_assets?>/media/illustrations/sketchy-1/13.png"></div>-->
                <!--end::Illustration-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid py-10">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid">
                <!--begin::Wrapper-->
                <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class="form w-100 login-form" novalidate="novalidate" method="post" action="">
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            
                            <!--begin::Logo-->
                            <a href="/<?=$admin_link?>" class="py-9 mb-5">
                                <img alt="Logo" src="/assets/uploads/sites/<?=$website_settings->logo?>" class="h-80px" style="" alt="<?=$website_settings->author?>" />
                            </a>
                            <!--end::Logo-->
                            
                            
                            
                        </div>
                        <!--begin::Heading-->
                        <?php if(!empty($validationerrors)) { ?>
                        <div class="fv-row mb-10">
							<div class="alert alert-danger"><?=$validationerrors?></div>
                        </div>
                        <?php } ?>                        
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="form-label fs-6 fw-bolder text-dark">Username</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="text" placeholder="Username" name="username" autocomplete="off" autofocus />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack mb-2">
                                <!--begin::Label-->
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" placeholder="Password"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <!--begin::Submit button-->
                            <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">Sign In</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Submit button-->
                            <!--begin::Separator-->
                            
                            <!--end::Separator-->
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            
            <!--end::Footer-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
