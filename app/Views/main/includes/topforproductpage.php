<style>
    
.topmenx {
    font-weight:bold!important;
    color:red;
}
    
</style>

<body class="home" style="font-family: 'Roboto', sans-serif;">

    <div class="container-fluid main_top">
        

           
        
        <!-- Header -->
        <header class="header">
            <!--header contact-->

            

            <div class="header_contact font-16">
                
             
                <span><img style="height:45px;width:138.55px;" src="assets/uploads/sites/<?= $settings->logo ?>" alt="<?= $settings->site_name ?>"> </span>
                
                
            </div>

      

<?php 

//echo '<pre>';
//print_r($curregcode);


?>


            <!--Logo for mobile-->
            <div class="logo-mobile">
                <a href="/<?=$curlangcode?>">
                    <img style="filter: brightness(10%); height:45px;width:138.55px;" src="assets/uploads/sites/<?=$settings->logo?>" alt="<?=$settings->site_name?>"> 
                </a>
            </div>
            <!--/Logo for mobile-->



            <div class="header_social font-16">
                <span style="display:inline-block;margin-left:60px;">&nbsp&nbsp<?=explode(',',$curbranch->phones)[0]?> </span>
            </div>
  
            
        </header>
        <span id="scrollTop"><img style="width:30px;height:30px;" src="assets/main/img/arrow-svg.svg" alt=""></span>
    </div>
    
    
    
    
    
    <main id="fullpage">
        
        
     