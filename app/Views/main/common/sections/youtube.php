<?php if ($feature->template == 'youtube') { 

$title = explode('///',$feature->title);

?>
                    
                    <div class="container-fluid" style="background-color: #ebebec;padding-bottom: 25px;" id="<?=$title[1]?>">
                    
                    <div class="inner_main_center" >
                        
                        
                        
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                
                                <h3 class="my-3">INSTALLATION GUIDE</h3>
                                
                                <video controls style="width:100%">
                                    <source src="assets/uploads/videos/veranfa_boy_logolu.mp4"
                                            type="video/mp4">
                                    
                                </video>
                            </div>
                            <div class="col-md-6 mb-3">
                                
                                <h3 class="my-3">CONTRACTOR'S OPINION</h3>
                                
                                <video controls style="width:100%">
                                    <source src="assets/uploads/videos/full_clip_schildr.mp4"
                                            type="video/mp4">
                                    
                                </video>
                            </div>
                        </div>
                        
                    </div>
                    
                    
                    </div>
                    
                    
                <?php } ?>   
                
                
                <style>
                    .ytbvdo {width:100%;height:800px;}
                </style>