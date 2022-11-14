<?php echo view('main/includes/head'); ?> 
<?php echo view('main/includes/top'); ?>

        <div class="main_top"> 
            
        
        
        <?php 
    
        $this->data['carotitle'] = static_area($curlangid, 'projects');
        $this->data['carosub'] = static_area($curlangid,'allcategories');
        $this->data['subitems'] = $pjcats;
        $this->data['sublink'] = $curlangcode.'/projects/'.'%s';
        $this->data['onslider'] = 'Get ready for the ultimate outdoor solutions.' ;
        
        $this->data['slpath'] = '/assets/uploads/pjcats/full/' ;
    

					
	echo view('/main/common/inslider',$this->data);
	
	?>
            
            
       
            
            



            
            <?php echo view('main/includes/leftmenu'); ?>
            
        </div>

        
            

<div class="container-fluid main_center">
    <div class="inner_main_center">
        <!--page breadCrumb-->
        <div class="bread">
            <div class="_bread_crumb_other_page">
                <ul class="breadcrumb"><li><i><a href="/">Home</a></i></li>
<li class="active"><?=static_area($curlangid,'projects');?></li>
</ul>            </div>
        </div>
        <div class="main_center">
            <div class="col-md-4 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                <h1 class="text-uppercase" style="font-size: 45.7px; font-weight: normal; color: #232323; margin-top: 30px;"><?=static_area($curlangid,'projects');?></h1>
            </div>

        </div>

      
    </div>
    <div class="project" style="width: 100%">
        <div class="products">
            
            
            <?php foreach ($pjcats as $pjcat) { ?>
            
            
            <div class="project-item projects-item" data-id="">
                <a href="<?=$curlangcode?>/projects/<?=$pjcat->slug ?>">
                    <div class="project-img projects-img">
                        <img src="assets/uploads/pjcats/full/<?=$pjcat->image?>" alt="<?=$pjcat->title?>">
                    </div>
                    </a><div class="prj-info">
                        <a href="<?=$curlangcode?>/projects/<?=$pjcat->slug ?>">
                        </a><a class="prj-text text-uppercase" href="<?=$curlangcode?>/projects/<?=$pjcat->slug ?>"><?=$pjcat->title?></a>
                        <p class="prj-title"><?=$pjcat->body?></p>
                    </div>
                
            </div>
            
            
            <?php } ?>
            
        </div>

    </div>
</div>



        
        <?php echo view('main/includes/clientsandreviews'); ?>
        


<?php echo view('main/includes/footer'); ?>
<?php echo view('main/includes/end'); ?>
       