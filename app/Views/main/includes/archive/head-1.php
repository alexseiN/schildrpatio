<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
   
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?=$ogtitle?></title>
    <base href="<?php echo base_url();?>">
    
    <link rel="icon" href="assets/uploads/sites/<?=$settings->favicon?>" type="image/x-icon">
    <meta property="og:url" content="<?=current_url(true)?>" />
    <meta property="og:type" content="website" />
    
    <meta property="og:title" content="<?=$ogtitle?>">
    <meta property="og:description" content="<?=$ogdesc?>">
    <meta property="og:image" content="<?=base_url()?>/<?=$ogimage?>">
    <meta name="description" content="<?=$ogdesc?>" />
    <meta name="keywords" content="<?=$keywords?>" data-dynamic="true" />
    
    <meta name="OWNER" content="<?=$settings->owner; ?>" />
    <meta name="AUTHOR" content="<?=$settings->author; ?>" />
    <meta property="og:site_name" content="<?=$settings->site_name; ?>" />
 
    <link href="assets/main/9649251d/css/font-awesome.min.css?v=1619027747" rel="stylesheet"> 
    <link href="assets/main/9649251d/css/lightgallery.css?v=1619027747" rel="stylesheet">
    <link href="assets/main/9649251d/css/slick.css?v=1619027747" rel="stylesheet">
    
    <link href="assets/main/9649251d/css/fonts.css?v=1619027747" rel="stylesheet">
    <!--link href="assets/main/9649251d/css/all.min.css?v=1619027747" rel="stylesheet"--> 
    
    <!--link href="assets/main/kit-pro.fontawesome.com/releases/v5.15.3/css/pro.min.css" rel="stylesheet"-->
    
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" rel="stylesheet">               
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!--link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" rel="stylesheet"-->
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.3/css/pro.min.css" rel="stylesheet">
    <!--link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" rel="stylesheet"-->
    
    <link href="assets/main/bootstrap4-modal-fullscreen.css" rel="stylesheet">
    <link href="assets/main/9649251d/css/slick-theme.css?v=1619027747" rel="stylesheet">
    <link href="assets/main/9649251d/css/slick-lightbox.css?v=1619027747" rel="stylesheet">
    <link href="assets/main/9649251d/css/style.css?v=1619027747" rel="stylesheet">
    <link href="assets/main/9649251d/css/media.css?v=1619027747" rel="stylesheet">
    <link href="assets/main/9649251d/css/newmedia.css" rel="stylesheet">
    
   <?php echo view('main/includes/external'); ?> 
    
</head>