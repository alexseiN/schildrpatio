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
				<li><i><a href="/"><?=static_area($curlangid,'home');?></a></i></li>
				<li class="active"><?= $page->title ?></li>
			</ul>
		</div>

	</div>
	<div class="inner_main_center for_about">

		<!--Page Title-->
		<div class="page_title pb-0 pl_992_0" style="padding: 0;">
			<div class="main_center">
				<div class="col-md-12 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
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
    <div class="inner_main_center for_about border_1">
        <form id="becomedealer_form" action="/en/become-a-dealer" method="POST">
        <div class="row contact_form">
            <div class="col-md-12">
                <h4><?=static_area($curlangid,'maininformation');?></h4>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'firstname');?>" id="input-first_name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'lastname');?>" id="input-last_name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control"  required="" placeholder="<?=static_area($curlangid,'companyname');?>" id="input-company_name">
                </div>
                <div class="form-group">
                    <input type="email" required="" class="form-control" placeholder="<?=static_area($curlangid,'email');?>" id="input-email">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'phone');?>" id="input-phone">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'ziporpostal');?>" id="input-zipcode">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'city');?>" id="input-city">
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'areainmiles');?>" id="input-areamiles">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control"  placeholder="<?=static_area($curlangid,'compwebsite');?>" id="input-website">
                </div>
               
                
                
            </div>
            
            <div class="ajax-error"></div>
            <div class="container-fluid row" style=" margin-top: 20px">
                
                <div class="col-md-12 d-flex align-items-center">
                    <div class="form-group button_group">
                        <button class="contener btn_more submio" type="submit" style="margin: 0; border: none;">
                            <div class="txt_button submiotxt"><?=static_area($curlangid,'send');?></div>
                            <div class="circle">&nbsp;</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </form>    </div>
</div>

</div>

<script>
      function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('6LfCdtgaAAAAALBd-tKVQvclyP_iasnO_7pOeyIl', {action: 'submit'}).then(function(token) {
              document.getElementById("becomedealer_form").submit();
          });
        });
      }
  </script>

<script>
    $(document).ready(function() {
                $('#becomedealer_form').submit(function() {
                    
                    
                        
                        $('.submio').prop("disabled", true);
                        $('.submiotxt').html('<?=static_area($curlangid,'sending');?>');
                        
                        
        
                    
                        var first_name = $('#input-first_name').val();
                        var last_name = $('#input-last_name').val();
                        var company = $('#input-company_name').val();
                        var email = $('#input-email').val();
                        var phone = $('#input-phone').val();
                        var zipcode = $('#input-zipcode').val();
                        var city = $('#input-city').val();
                        
                        var areamiles = $('#input-areamiles').val();
                        var website = $('#input-website').val();
            
                    

                        
                        $.ajax({
                                type: "POST",
                                url:"/page/becomedealer1",
                                data: {
                                    <?=csrf_token();?>:'<?=csrf_hash();?>',
                                    first_name: first_name,
                                    last_name: last_name,
                                    company:company,
                                    email: email,
                                    phone:phone,
                                    zipcode:zipcode,
                                    city:city,
                                    areamiles:areamiles,
                                    website:website,
                                    
                                    
                                    },
                                    success: function(data) {
                                        
                                      //  alert(data);
                                        $('.ajax-error').html('<?=static_area($curlangid,'datasent');?>');
                            
                                        
                                       window.location.href = "/<?=$curlangcode?>/page/thanks"; 
                                        
                                    }
                                });
                            return false;
                        });
                });
</script>


<?php echo view('main/includes/footer'); ?>
<?php echo view('main/includes/end'); ?>