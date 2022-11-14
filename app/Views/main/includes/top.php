<style> 
    
.topmenx li {
    display:inline-block;
    margin: 10px 15px;
    
}

.topmenx li a {
    color:#c3c3c3;
    font-family: Arial;
}

.topmenx li a:hover {
    color:#000;
    font-family: Arial;
}


    
@media (max-width: 1100px) {
    
    
    #topmenum {
        display: none;
    }
    
}    

.rightconf {
    position: fixed;
    top: 50vh;
    right: -35px;
    font-size: 20px;
    width: 200px;
    text-align: center;
    background-color: #000;
    z-index: 11;
    padding: 17px 43px;
    transform: rotate(-90deg);
}

.rightconf a {
    text-decoration:none;
    color:#fff;
}
    
</style>

<body class="home" style="font-family: 'Barlow Semi Condensed', sans-serif;">

<div class="rightconf"><a target="_blank" href="https://point.schildr.store">Build your own</a></div>

    <div class="container-fluid main_top">
        
        
        <!-- Header -->
        <header class="header">
            <!--header contact-->

            

            <div class="header_contact font-16">
                
             
                <span><a href=""><img style="height:45px;width:138.55px;" src="assets/uploads/sites/<?= $settings->logo ?>" alt="<?= $settings->site_name ?>"> </a></span>
                <span style="display:inline-block;margin-left:50px;">&nbsp&nbsp<?=explode(',',$curbranch->phones)[0]?> </span>
                
            </div>

      


            <!--Logo for mobile-->
            <div class="logo-mobile">
                <a href="">
                    <img style="filter: brightness(10%); height:45px;width:138.55px;" src="assets/uploads/sites/<?=$settings->logo?>" alt="<?=$settings->site_name?>"> 
                </a>
                <span style="display:inline-block;margin-left:20px;">&nbsp&nbsp<?=explode(',',$curbranch->phones)[0]?> </span>
                
            </div>
            <!--/Logo for mobile-->



            <div class="header_social font-16">
                <ul>
                    
                    
                    
                    <?php foreach ($middle_right as $t) { ?>
                    
                    <li><a class="topmenx text-uppercase" href="#<?=$t->slug?>"><?=$t->title?></a></li>
                    
                    <?php } ?>
                    
                    
                    
                </ul>
            </div>
  
            <span class="open_menu">
                <i class="fal fa-bars"></i>
            </span>

            <div class="menu_mini">
                <ul>
    
                    <?php foreach ($middle_right as $t) { ?>
                    
                    <li class="text-uppercase"><a href="https://schildrpatio.com#<?=$t->slug?>"><b><?=$t->title?></b></a></li> 
                    
                    <?php } ?>

                  
                </ul>
                
                
                
                
                
                
            </div>
            <!-- / Mini size menu-->


            <!--Mini size social-->
            
        </header>
        <span id="scrollTop"><img style="width:30px;height:30px;" src="assets/main/img/arrow-svg.svg" alt=""></span>
    </div>
    
    
    
    
    <main id="fullpage">
        
        
     