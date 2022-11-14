<?php echo view('main/includes/head'); ?> 
<?php echo view('main/includes/top'); ?>

        <div class="main_top">
            
            
            
                  <?php 
    
        $this->data['carotitle'] = static_area($curlangid, 'projects');
        $this->data['carosub'] = static_area($curlangid,'allcategories');
        $this->data['slidefiles'] = morefiles('pjcats', $pjcats_sel->id);
        
        //yoxla($this->data['slidefiles']);
        //die();
        
        
        $this->data['subitems'] = $items_sel;
        $this->data['sublink'] = 'javascript:void(0);';
        $this->data['onslider'] = 'Get ready for the ultimate outdoor solutions.' ;
        
        $this->data['slpath'] = 'assets/uploads/pjcats/' ;
    

					
	echo view('/main/common/inslider',$this->data);
	
	?>
            
                

            
            <?php echo view('main/includes/leftmenu'); ?>
            
        </div>

        
            

<div class="container-fluid main_center">
    
    
    <div class="inner_main_center mt-0 pb-415-0">
        
            <div class="page_titles pb-0 pl_992_0" style="padding: 0;">
                <div class="bread">
                    <div class="_bread_crumb_other_page ">
                        <ul class="breadcrumb"><li><i><a href="/">Home</a></i></li>
<li><i><a href="/en/projects">Projects</a></i></li>
<li class="active"><?=$pjcats_sel->title;?></li>
</ul>                    </div>
                </div>
                <div class="main_center">
                    <div class="row">
                    <div class="col-md-4 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                        <h1 class="text-uppercase" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;">OUR PROJECTS</h1>
                    </div>
                    <div class="col-lg-7 col-md-8 recidental_text" style="padding-right: 0;">
                        <h4 class="text-uppercase">
                            <?=$pjcats_sel->title;?>                        </h4>
                        <p>
                            <?=$pjcats_sel->body;?>                         </p>
                    </div>
                    </div>
                </div>
            </div>
    

        <div class="container-fluid">
                    </div>
    </div>
    
    
    
    <div class="project">
		<div class="products ">

			<div class="contain-group prod-container ">

				<?php
				foreach ($items_sel as $pro) {
					
					
					
					$this->data['pro'] = $pro;
					
					echo view('/main/common/pritem',$this->data);

					
			  ?>

				<?php
				} ?>

			</div>
		</div>
	</div>
    
    
</div>



        
        <?php echo view('main/includes/clientsandreviews'); ?>
        


<?php echo view('main/includes/footer'); ?>
<?php echo view('main/includes/end'); ?>
       