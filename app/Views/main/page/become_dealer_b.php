<?php echo view('main/includes/head'); ?>
<?php echo view('main/includes/top'); ?>

<div class="main_top">

	<div class="carousel" style="height: 87.5vh">
		<div class="bg_top" style="background-image:  url(assets/uploads/pages/full/schildr.com1624070054_b49ba0c8a18852751915.jpg); ">
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
				<li class="active"><?=static_area($curlangid,'becomedealer2title');?></li>
			</ul>
		</div>

	</div>
	<div class="inner_main_center for_about">

		<!--Page Title-->
		<div class="page_title pb-0 pl_992_0" style="padding: 0;">
			<div class="main_center">
				<div class="col-md-12 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
					<h1 class="text-uppercase" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?=static_area($curlangid,'becomedealer2title');?></h1>
				</div>
				<div class="col-lg-12 col-md-12 about_text" style="padding: 0;">

					<?=static_area($curlangid,'becomedealer2desc');?>
					
					
				</div>
			</div>
		</div>
	</div>
</div>


<div class="container-fluid main_center">
    <div class="inner_main_center for_about border_1">
        <form id="becomedealer_form"  method="POST">
        <div class="row contact_form">
            <div class="col-md-6">
                
                

                
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'yearsexperience');?>" id="input-yearsexperience">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'comprojects');?>" id="input-comprq">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'resprojects');?>" id="input-resprq">
                </div>
                
                
            
                
                
                <div class="form-group">
                    <select class="form-control" id="input-aremanufacturer" required="">
                        <option selected="" disabled="" value=""><?=static_area($curlangid,'aremanufacturer');?></option>
                        <option value="1"><?=static_area($curlangid,'yes');?></option>
                        <option value="0"><?=static_area($curlangid,'no');?></option>
                    </select>
                </div>
                
                
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'salemp');?>" id="input-salem">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'instemp');?>" id="input-instem">
                </div>
                
                
               
                <div class="form-group">
                    <select class="form-control" id="input-q1" required="">
                        <option selected="" disabled="" value=""><?=static_area($curlangid,'becomedealerqusetion1');?></option>
                        <option value="1"><?=static_area($curlangid,'yes');?></option>
                        <option value="0"><?=static_area($curlangid,'no');?></option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="input-q2" required="">
                        <option selected="" disabled="" value=""><?=static_area($curlangid,'becomeadealerquestion2');?></option>
                        <option value="1"><?=static_area($curlangid,'yes');?></option>
                        <option value="0"><?=static_area($curlangid,'no');?></option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="input-areas" required="" placeholder="<?=static_area($curlangid,'becomeadealerquestion3');?> *">
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'howfindus');?>" id="input-howfindus">
                </div>
                
                
                
                
            </div>
            <div class="col-md-6">
                
                
                <h4><?=static_area($curlangid,'whichproductint');?></h4>
                
                <br>
             
                        
                        <?php foreach ($pdcats as $pdcat) { ?>
                        <input type="checkbox" style="width:15px;height:15px;" name="input-pdcat" id="pdacat<?=$pdcat->id ?>" value="<?=$pdcat->id ?>" class="theClasscheck1 d-inline mr-3">
                        
                        <?=$pdcat->title?><br>
                        <?php } ?>
                    
                <hr>
                
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'whichbrandprev');?>" id="input-prevbrand">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'monthlyadb');?>" id="input-adbudget">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'yourleadflow');?>" id="input-comesfrom">
                </div>
                
                
                
                
                
                
                <div class="form-group">
                        <textarea style="height: 106px;" class="form-control" id="input-comments" required="" id="" cols="30" rows="7" placeholder="<?=static_area($curlangid,'additionalcomments');?>"></textarea>
                </div>
                
                
                <h4><?=static_area($curlangid,'social_media');?></h4>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'Facebook');?>" id="input-facebook">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'Instagram');?>" id="input-instagram">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'Linkedin');?>" id="input-linkedin">
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
                        
                        
                        
                        var product = [];     
        $('.theClasscheck1:checkbox:checked').each(function(){
            product.push($(this).val());
        });       
        product=product.toString(); 
        
        
                    
                        var dealer_id = <?=$dealer_id?>;
                        var facebook = $('#input-facebook').val();
                        var instagram = $('#input-instagram').val();
                        var linkedin = $('#input-linkedin').val();
                        var comprq = $('#input-comprq').val();
                        var resprq = $('#input-resprq').val();
                        var salem = $('#input-salem').val();
                        var instem = $('#input-instem').val();
                       
                        var prevbrand = $('#input-prevbrand').val();
                        var adbudget = $('#input-adbudget').val();
                        var comesfrom = $('#input-comesfrom').val();
                        var howfindus = $('#input-howfindus').val();
                        
                        var q1 = +$('#input-q1').val();
                        var q2 = +$('#input-q2').val();
                        
                        var areas = $('#input-areas').val();
                        var comments = $('#input-comments').val();
                        
                        var yearsexperience = $('#input-yearsexperience').val();
                        var aremanufacturer = $('#input-aremanufacturer').val();
                        
                        
                        
                        
                        $.ajax({
                                type: "POST",
                                url:"/page/becomedealerid",
                                data: {
                                    <?=csrf_token();?>:'<?=csrf_hash();?>',
                                 
                                    dealer_id:dealer_id,
                                    facebook:facebook,
                                    instagram:instagram,
                                    linkedin:linkedin,
                                    comprq:comprq,
                                    resprq:resprq,
                                    salem:salem,
                                    instem:instem,
                                    product:product,
                                    prevbrand:prevbrand,
                                    adbudget:adbudget,
                                    comesfrom:comesfrom,
                                    howfindus:howfindus,
                                    
                                    yearsexperience:yearsexperience,
                                    aremanufacturer:aremanufacturer,
                                    
                                    q1:q1,
                                    q2:q2,
                                    
                                    areas:areas,
                                    comments: comments
                                    
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