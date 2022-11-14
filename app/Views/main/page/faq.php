<?php echo view('main/includes/head'); ?>
<?php echo view('main/includes/top'); ?>

<div class="main_top">

	<div class="carousel" style="height: 87.5vh">
		<div class="bg_top" style="background-image:  url(assets/uploads/pages/full/<?= $page->image ?>); ">
			<div class="bg_layer">
			</div>
		</div>

		<?php echo view('main/includes/logo'); ?>


		</div>
	</div>

	<?php echo view('main/includes/leftmenu'); ?>

</div>

<div class="container-fluid main_center">
	<div class="bread" style="margin-top: 15px">
		<div class="bread_crumb">
			<ul class="breadcrumb">
				<li><i><a href="/">Home</a></i></li>
				<li class="active"><?= $page->title ?></li>
			</ul>
		</div>

	</div>
	<div class="inner_main_center for_about">

		<!--Page Title-->
		<div class="page_title pb-0 pl_992_0" style="padding: 0;">
			<div class="main_center">
				<div class="col-md-4 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
					<h1 class="text-uppercase" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?= $page->title ?></h1>
				</div>
				<div class="col-lg-12 col-md-12 about_text" style="padding: 0;">

					<?= $page->body ?>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="container-fluid main_center">

        <div class="project" style="width: 100%">
                <div class="products">
                    
                        <?php foreach($faqs as $faq) {?>
                    
                        
                         
    
                                      
                              
                                            <h5 class="col-lg-12 col-md-12">
                                                <b><?=$faq->title?></b>
                                            </h5>
                                           
                                            <div class="col-lg-12 col-md-12 about_text">
                                                 <?=$faq->body?>
                                                 
                                                 
                                            </div>
                                            
                                            <div style="width:100%;padding:10px"></div>
                                     
                          
                        
                        <?php } ?>
                   
                </div>

        </div>

</div>




</div>

<?php echo view('main/includes/footer'); ?>
<?php echo view('main/includes/end'); ?>