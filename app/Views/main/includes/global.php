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


<div class="modal fade modal-fullscreen" id="globalModal" aria-hidden="true" style="z-index:100001!important">
    
    <div class="modal-dialog" role="document">
        <div class="modal-content fullmodal">
            <div class="backlogoglobal"></div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="modallogo">
                            <a href="/<?=$curlangcode?>">
                                <img style="filter: brightness(10%);" src="assets/uploads/sites/<?=$settings->logo?>" alt="<?=$settings->site_name?>"> 
                            </a>
                        </div>
                    </div>
                    <div class="col text-right"><a data-dismiss="modal"><i class="fal fa-times modalclose"></i></a></div>
                </div>
                
                <div class="row modalcont">
                    
                    
                    
                    <section class="col-12 regions">
                        <h4 class="modaltitle"><b><?=static_area($curlangid,'languages');?></b></h4>
                        <?php echo view('main/includes/more/inlineflags'); ?>
                    </section>
                    
                    
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
            
        </div>
    </div>
</div>