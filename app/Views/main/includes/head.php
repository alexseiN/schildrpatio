<!DOCTYPE html>
<html lang="<?=$curlangcode?>">

<head>
    <meta charset="UTF-8">
   
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?=$ogtitle?></title>
    
    
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
    
  
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.3/css/pro.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    </style>

    <link href="assets/main/9649251d/css/style.css?v=1619027747" rel="stylesheet">
    <link href="assets/main/9649251d/css/media.css?v=1619027747" rel="stylesheet">

    
    <link href="assets/main/9649251d/css/lightgallery.css" rel="stylesheet">
    <link href="assets/main/9649251d/css/slick.css" rel="stylesheet">
  
    <link href="assets/main/9649251d/css/slick-theme.css?v=1619027747" rel="stylesheet">
    <link href="assets/main/9649251d/css/slick-lightbox.css?v=1619027747" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    
    

<style>
    .swiper {
  width:100%;
  height: 380px;
}

.pointer {
  cursor: pointer;
}


.swiper-slide {
    width: auto !important;
    cursor: pointer;
    display: inline-block;
    margin: 0 15px;
    text-align: center;
    border-radius: 25px;
}

.swiper-slide img {
    max-height: 80vh;
    border-radius:25px;
    border: 1px solid transparent;
    display: block;
}
    </style>
    
    
   <?php echo view('main/includes/external'); ?>  
   
   <style>
       @media only screen and (max-width: 530px) {
.carousel_right_zone {
    width: 100%;
    display: none;
}}
   </style>
   
   <script src="https://www.google.com/recaptcha/api.js?render=6LfCdtgaAAAAALBd-tKVQvclyP_iasnO_7pOeyIl"></script>
   
   <style>
    .grecaptcha-badge{visibility: hidden}
</style>

<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>


</head>
