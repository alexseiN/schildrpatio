<?php $projects = multiproject ($itemcat->id , $curlangid,array()); ?>


<?php if($projects) {?>

<div class="container-fluid main_center" style="background-color:whitesmoke;padding:30px 0">
    
    
    <div class="inner_main_center mt-0 pb-415-0">
        
            <h1 class="text-uppercase">REFERENCE <br>PROJECTS</h1>
        
           
    </div>
    
    
    
    <div class="project">
		<div class="products ">

			<div class="contain-group prod-container ">

			<?php 
			
			    foreach($projects as $project) {  
			    $morefiles = morefiles('project',$project->id);
			
			?>	
            <div class="product-item slider-for-prd aniimated-thumbnials" data-id="<?=$project->id?>">
                
                
                        <a href="assets/uploads/projects/full/<?=$project->image?>" data-exthumbimage="assets/uploads/projects/full/<?=$project->image?>" class="d-block">
							<div class="product-item-single">
								<div class="prdct-img" style="background-image: url('assets/uploads/projects/full/<?=$project->image?>');background-size: cover;
                                        background-position: center">

								</div>
							
								<div class="prdct-info" style="background-color:whitesmoke;">
									<p class="Louver-Aluminum-Stru text-uppercase"><?=$project->title?></p>
									<div class="Retractable-Motorize"><p><?=$project->body?></p></div>

								</div>
							</div>
						</a>


                        <?php foreach($morefiles as $morefile) { ?>

						



						
							<a href="assets/uploads/projects/<?=$morefile->filename?>" data-exthumbimage="assets/uploads/projects/<?=$morefile->filename?>" class="d-none">
								<div class="product-item-single">
									<div class="prdct-img" style="background-image: url('assets/uploads/projects/<?=$morefile->filename?>');background-size: cover;
                                            background-position: center">
									</div>
									<div class="prdct-info">
										<p class="Louver-Aluminum-Stru text-uppercase"><?=$project->title?></p>
										<div class="Retractable-Motorize"><p><?=$project->body?><br></p></div>
									</div>
								</div>
							</a>

			                <?php } ?>				

						
					</div>
			<?php } ?>	

				
			</div>
		</div>
	</div>
    
    
</div>

<?php } ?>