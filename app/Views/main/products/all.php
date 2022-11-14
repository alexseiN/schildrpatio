<?php echo view('main/includes/head'); ?>
<?php echo view('main/includes/top'); ?>

<div class="main_top">


    <?php $subitems = sub_langers('pdcats', $curlangid, $itemcat->id); ?>



    <?php 
    
    $this->data['carotitle'] = static_area($curlangid, 'products');
    $this->data['carosub'] = $itemcat->title;
    $this->data['videom'] = $itemcat->video;
    $this->data['subitems'] = $pdcats;
    $this->data['sublink'] =  $curlangcode.'/products/'.'%s';
    $this->data['onslider'] = 'Get ready for the ultimate outdoor solutions.' ;
    
    $this->data['slpath'] = '/assets/uploads/pdcats/full/' ;

					
	echo view('/main/common/inslider',$this->data);
	
	?>


    <?php echo view('main/includes/leftmenu'); ?>

</div>



<div class="container-fluid main_center">

    <div class="inner_main_center mt-0 pb-415-0">

        <div class="page_titles pb-0 pl_992_0" style="padding: 0; ">
            <div class="bread">
                <div class="_bread_crumb_other_page ">
                    <ul class="breadcrumb">
                        <li><i><a href="/">Home</a></i></li>
                        <li><i><a href="<?=$curlangcode?>/products">Products</a></i></li>
                        <li class="active"><?= $itemcat->title ?></li>
                    </ul>
                </div>
            </div>
            <div class="main_center">
                <div class="col-md-12 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                    <h1 class="text-uppercase page_name" style="font-size: 45.7px; font-weight: normal; color: #232323; margin-top: 30px;"><?= $itemcat->title ?></h1>
                </div>
                <div class="col-lg-12 col-md-12 recidental_text" style="padding-left: 0;">

                    <p><?= $itemcat->about ?> </p>
                </div>
            </div>
        </div>

        <!--Page main content-->

        <div class="project border_1" style="width: 100%;">
            <div class="project" style="margin-bottom: -37px;">
                <div class="products">
                    
                    
                    <?php foreach ($pdcats as $pdcat) { ?>
                    
                    <div class="project-item" data-id="<?=$pdcat->id?>">
                        <a href="<?=$curlangcode?>/products/<?=$pdcat->slug?>">
                            <div class="project-img" style="background-image: url('assets/uploads/pdcats/thumbnails/<?=$pdcat->image?>') ; background-size: cover; background-position: center;">
                                <img style="display: none" src="assets/uploads/pdcats/thumbnails/<?=$pdcat->image?>" alt="<?=$pdcat->title?>">
                            </div>
                            <div class="prj-info">
                                <a class="prj-text text-uppercase" href="en/product/1588eb.html?slug=sunroom"><?=$pdcat->title?></a>
                                <p class="prj-title "><?=$pdcat->about?></p>
                            </div>
                        </a>
                    </div>
                    
                    <?php } ?>
                    
                    
                    

            </div>
        </div>

        </div>

        
        
    </div>
</div>




<?php echo view('main/includes/clientsandreviews'); ?>



<?php echo view('main/includes/footer'); ?>
<?php echo view('main/includes/end'); ?>