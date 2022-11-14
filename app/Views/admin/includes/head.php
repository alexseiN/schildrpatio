<?php
    error_reporting(0);
    $currenturlstring = uri_string();
    $hideme = '';
    if(strpos($currenturlstring,'productview') || strpos($currenturlstring,'loccart')  || strpos($currenturlstring,'loccheckout') || strpos($currenturlstring,'locstore')) {
	$hideme = 'yes';
    }
    
    $unseradcounter = msgunreadcounterhelper();
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php  echo isset($title)?$title:''; ?> | Schildr Admin</title>
    <base href="<?php echo base_url();?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta content="<?=$website_settings->meta_desc?>" name="description" />
    <meta name="keywords" content="<?=$website_settings->meta_keyword?>" />
    <meta content="<?=$website_settings->author?>" name="author" /> 
    <link rel="shortcut icon" href="/assets/uploads/sites/<?=$website_settings->favicon?>" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Barlow:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="<?=$admin_assets?>/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--<link href="<?=$admin_assets?>/plugins/custom/vis-timeline/vis-timeline.bundle.css" rel="stylesheet" type="text/css" />-->
    <!--end::Page Vendor Stylesheets-->

    <?php $adddarkclass = '';$adddarkclass2 = ''; if($adminDetails->theme_appearence == 1){$adddarkclass = 'dark.';$adddarkclass2 = 'dark-mode';} ?>
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="<?=$admin_assets?>/plugins/global/plugins.<?=$adddarkclass?>bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?=$admin_assets?>/css/style.<?=$adddarkclass?>bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
    
    

    <style>.errors ul{margin: 0;}</style>
    <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="https://unpkg.com/quill-html-edit-button@2.2.7/dist/quill.htmlEditButton.min.js"></script>

    <script src="<?=$admin_assets?>/plugins/global/plugins.bundle.js"></script>
    <script src="<?=$admin_assets?>/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <script src="<?=$admin_assets?>/js/custom/common.js?<?=time()?>"></script>
    
    <style>
        .schildrA {background-color: #7396ae;}
        .schildrB {background-color: #CEA890;}
        .schildrC {background-color: #A6948D;}
        .schildrD {background-color: #665C54;}
        
    </style>
    
    <style>
	    .sortable li div{height:35px;}
	    .options { background: none !important;border: none !important;padding: 0px !important;}

	    #loader{
		    display: none;
		    position: fixed;
		    top: 0; left: 0; right: 0; bottom: 0;
		    background: rgba(255,255,255,0.8) url(<?=$admin_assets?>/preload.gif) center center no-repeat;
		    z-index: 99999;
		    background-size: 70px;
	    }
	    #kt_content_container{max-width:100% !important;}
	    .select2-container--bootstrap5 .select2-dropdown .select2-results__options {
		max-height: 350px  !important;;
	    }
	    .select2-container--bootstrap5 .select2-dropdown{
		width: auto !important;min-width:300px !important;
	    }
	    .select2-selection__rendered {
        max-width: 90%;
        }.ui-sortable-handle{cursor: all-scroll !important;}
    <?php if($hideme == '') { ?>
.content{padding-top:0;}
.header-fixed.toolbar-fixed .wrapper{padding-top:calc(35px + var(--kt-toolbar-height))}
    <?php } else { ?>
	

	<?php } ?>
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/livestamp/1.1.2/livestamp.min.js" integrity="sha512-C3RIeaJCWeK5MLPSSrVssDBvSwamZW7Ugygc4r21guVqkeroy9wRBDaugQssAQ+m3HZsMWVvEigcNMr7juGXKA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>var showloader;</script>
</head>
<!-- END HEAD -->
<input type="hidden" value="<?=$_darkmodeurl?>" id="darkmodeurl"/>
<input type="hidden" value="<?=$_searchpagesurl?>" id="searchpagesurl"/>
<input type="hidden" value="<?=$_recentsearchurl?>" id="recentsearchurl"/>
<?php
	$adminSession = $session->get('adminSession');
	if (isset($adminSession['id'])) {
		$admin_emp_id = $adminDetails->employee_id;
		updateloginstatus("0",$admin_emp_id);
?>
	<input type="hidden" id="e_emp_id" value="<?=$adminDetails->employee_id?>"/>
	<input type="hidden" id="e_branch_id" value="<?=$thisEmployee->branch_id?>"/>
	<input type="hidden" id="chatlink" value="<?=$admin_link."/chat"?>"/>
	
	<input type="hidden" id="totalnewchatcounter" value="<?=$unseradcounter?>"/>
	
	
	<body id="kt_body" class="<?=$adddarkclass2?> header-fixed header-tablet-and-mobile-fixed aside-enabled aside-fixed toolbar-enabled toolbar-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
			
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
				<?=view('admin/includes/leftmenu');?>
				<div id="loader"></div>	
<?php } else { ?>
	<body id="kt_body" class="bg-body">
		<div class="d-flex flex-column flex-root">
<?php } ?>
