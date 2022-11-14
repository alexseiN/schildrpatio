<?php echo view('main/includes/head'); ?> 

<?php 

helper( ['comman', 'front']);

 ?>

<style>
    
    section {margin:20px 0;}
    .reglist {
        margin: 10px 0;
    }
    
    .reglist a {
         color:#cecece;
         transition: color 1s;
    }
    
    .reglist a:hover {
         color:#000;
    }
    
    .backlogoglobal {
        
        width:100%;
        height:80vh;
        background-image: url("assets/uploads/sites/<?=$settings->favicon?>");
        position:absolute;
        opacity: 0.05;
        background-position: center; /* Center the image */
        background-repeat: no-repeat; /* Do not repeat the image */
        background-size: cover;
      

    }
    
</style>
<body>
<div class="backlogoglobal"></div>   
<div class="container" style="margin-top:60px;opacity:1!important;">
                <div class="row">
                    <div class="col">
                        <div class="modallogo">
                            <a href="/<?=$curlangcode?>">
                                <img style="height:45px;filter: brightness(10%);" src="assets/uploads/sites/<?=$settings->logo?>" alt="<?=$settings->site_name?>"> 
                            </a>
                        </div>
                    </div>
                    
                    <div class="col text-right"><a href="https://schildr.com"><i class="fal fa-times modalclose"></i></a></div>
                    
                </div>
                
                <div class="row modalcont">
                    
                    
                    
                   
                    
                    
                    <section class="col-12 regions">
                        <h4 class="modaltitle"><b><?=static_area($curlangid,'regions');?></b></h4>
                        
                        
                        
                        
                        
                        
                        <div class="row">
                        <?php foreach($regions as $region) { ?> 
                
                            
                        <?php 
                        
                        $subs =  sub_langers('regions', $curlangid ,$region->id);
                        
                        
                        ?>
                            
                            
                       
                        
                            <ul class="col-4">
                                <li><h5><b><?=$region->title?></b></h5></li>
                                
                                        <li></li>
                                    
                                        <?php foreach($subs as $sub) {   $flang = explode(',',$sub->selang);  
                                        
                                        if ($sub->domains) {
                                            
                                            
                                            $domen = explode(',',$sub->domains);
                                        
                                        $domain = 'https://'.$domen[0];
                                        
                                        } else { $domain = $default_domain;}
                                        
                                        ?>
                                        
                                        
                                
                                        
                                        <li class="reglist"><a href="<?=$domain?>/<?=langidtocode ($flang[0])?>/<?=$sub->code?>"><h5><?=$sub->title?></h5></a></li> 
                                        
                                     
                                        
                                        
                                        <?php } ?>
                                        
                                    
                            </ul>
                            
                            
                          
                        
                        
                            <?php } ?>
                        </div>
                                          
                    </section>
                    
                    
                    
                    
                    
                </div>
                
                <div class="col-12 modalfoot">
                        
                        
                        
                        
                    </div>
                
                
            </div>

</body>

<?php echo view('main/includes/end'); ?>
       