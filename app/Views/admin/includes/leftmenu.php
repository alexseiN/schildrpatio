<?php
error_reporting(0);

$currenturlstring = uri_string();
$hidelefttop = '';
$hidelefttop_1 = '';
if(strpos($currenturlstring,'locstore')) {
    $hidelefttop = 'd-none';
    $hidelefttop_1 = 'p-0';
}
$getuserrole = getuserrole();
if($getuserrole == 'Branch Admin'){
    $showrole = "Branch Employee";    
}
else {
    $showrole = $getuserrole;
}

?>
    <!--begin::Aside-->
    <div id="kt_aside" class="<?=$hidelefttop?> aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
        <!--begin::Brand-->
        <div class="aside-logo flex-column-auto" id="kt_aside_logo">
            <!--begin::Logo-->
            <a target="_blank" href="https://schildrpatio.com">
                <img alt="Logo" src="/assets/uploads/sites/<?=$website_settings->logo?>" style="filter:  brightness(0) invert(1);" class="h-40px logo">
            </a>
            <!--end::Logo-->
            <!--begin::Aside toggler-->
            <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
                <span class="svg-icon svg-icon-1 rotate-180">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="black"></path>
                        <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="black"></path>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
            <!--end::Aside toggler-->
        </div>
        <!--end::Brand-->
        <!--begin::Aside menu-->
        <div class="aside-menu flex-column-fluid <?=$hidelefttop?>">
            <!--begin::Aside Menu-->
            <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0" style="height: 117px;">
                <!--begin::Menu-->
                <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">

					<div class="menu-item ">
						<a class="menu-link <?=($active=='dashboard')?"active":""?> " href="<?=$admin_link?>/dashboard">
							<span class="menu-icon">
								<i class="fa fa-th-large"></i>
							</span>
							<span class="menu-title">Dashboard</span>
						</a>
					</div>

					

					<?php echo view('admin/includes/leftmenu/index'); ?>

					
                    
                    
                 </div>
                <!--end::Menu-->
            </div>
            <!--end::Aside Menu-->
        </div>
        <!--end::Aside menu-->
        
        
        
    </div>
    <!--end::Aside-->
    <!--begin::Wrapper-->
    <div class="wrapper d-flex flex-column flex-row-fluid <?=$hidelefttop_1?> " id="kt_wrapper">
        <!--begin::Header-->
        <div id="kt_header" style="" class="header align-items-stretch <?=$hidelefttop?>">
            <!--begin::Container-->
            <div class="container-fluid d-flex align-items-stretch justify-content-between">
                <!--begin::Aside mobile toggle-->
                <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
                    <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black"></path>
                                <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <!--end::Aside mobile toggle-->
                <!--begin::Mobile logo-->
                <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                    <a href="<?=$admin_link?>" class="d-lg-none">
                        <img alt="Logo" src="/assets/uploads/sites/<?=$website_settings->logo?>" class="h-30px">
                    </a>
                </div>
                <!--end::Mobile logo-->
                <!--begin::Wrapper-->
                <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                    <!--begin::Navbar-->
                    <div class="d-flex align-items-stretch" id="kt_header_nav">
						<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="<?=$hidelefttop?> page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
							<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><?=ucfirst($title)?></h1>
							<?php if(isset($_parent_folder)) { ?>
							<span class="h-20px border-gray-300 border-start mx-4"></span>
							<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
								<!--begin::Item-->
								<li class="breadcrumb-item text-muted">
									<a href="javascript:" class="text-muted text-hover-primary"><?=$_parent_folder?></a>
								</li>
								<!--end::Item-->
								<!--begin::Item-->
								<li class="breadcrumb-item">
									<span class="bullet bg-gray-300 w-5px h-2px"></span>
								</li>
								<!--end::Item-->
								<!--begin::Item-->
								<li class="breadcrumb-item text-dark"><?=ucfirst($title)?></li>
								<!--end::Item-->
							</ul>
							<?php } ?>
						</div>
                    </div>
                    <!--end::Navbar-->
                    <!--begin::Toolbar wrapper-->
                    <div class="d-flex align-items-stretch flex-shrink-0">
                        
                        
                        <?php echo view('admin/includes/topmenu'); ?>
                        
                        
                        
                        
                        
                        <!--begin::User menu-->
                        <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                            <!--begin::Menu wrapper-->
                            <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
								
									<span class="me-2"><?=$thisEmployee->first_name?> <b><?=$thisEmployee->last_name?></b></span>
								
								
								

								<i class="fa fa-angle-down"></i>
                                <!--<img src="assets/admin/media/avatars/300-1.jpg" alt="user">-->
                            </div>
                            <!--begin::User account menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-375px" data-kt-menu="true" style="">
                                <!--begin::Menu item-->
                                <?php if ($thisbranch) { ?>
                                <div class="menu-item px-5 my-1">
                                    <span class="menu-link px-5"><b><?=$showrole ?> - <?=$thisbranch->name ?></b></span>
                                </div>
                                <?php } ?>
                                
                                <div class="separator my-2"></div>
                                
                                
                                <div class="menu-item px-10 my-1">
                                    
                                    <div class="mb-2">Technical Support by oawo.com</div>
													
                                    
                                    
                                    
                                    <a target="_blank" href="https://wa.me/+994505008648" class="" >Write to Whatsapp</a><br>
									<a target="_blank" href="skype:core.az?chat" class="">Write to Skype</a><br>
									<a target="_blank" href="https://www.youtube.com/channel/UCJfRSkdyeJkqv_2EjK7s0jQ" class="">Explanation Videos</a><br>
									<a target="_blank" href="" class="">FAQ</a><br>
                                    <br>
                                    <a>Framework Version: <?php echo \CodeIgniter\CodeIgniter::CI_VERSION; ?></a><br>
                                    <a>Software Version: 2.0.0</a>

                                    
                                </div>
                                
                                
                         
                                
                                
                                
                                <div class="separator my-2"></div>
                                
                                <?php if($adminDetails->role=='Global Admin'){ ?>
                                <div class="menu-item px-5">
                                    <a href="<?=$admin_link.'/settings'?>" class="menu-link px-5">Account Settings</a>
                                </div>
                                <!--end::Menu item-->
                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->
                                <?php } ?>
                                <div class="menu-item px-5 my-1">
                                    <a href="<?=$admin_link?>/account/changePassword" class="menu-link px-5">Change password</a>
                                </div>
                                <!--end::Menu item-->
                                <div class="separator my-2"></div>
                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="<?=$admin_link?>/account/logout" class="menu-link px-5">Sign Out</a>
                                </div>
                                <!--end::Menu item-->
                                <!--end::Menu item-->
                            </div>
                            <!--end::User account menu-->
                            <!--end::Menu wrapper-->
                        </div>
                        <!--end::User menu-->
                        <!--begin::Header menu toggle-->
                        <div class="d-flex align-items-center d-lg-none ms-2 me-n3" title="Show header menu">
                            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
                                <!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="black"></path>
                                        <path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="black"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                        </div>
                        <!--end::Header menu toggle-->
                    </div>
                    <!--end::Toolbar wrapper-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Header-->