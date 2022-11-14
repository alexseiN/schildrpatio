<style>
    .footul {
        padding:0;
    }
    .footul li {
        list-style:none;
        padding-bottom:7px;
    }
</style>

<footer>
	<div class="footer">
	    
	<div class="container-fluid d-flex justify-content-center">
			<div class="columns">
				<div class="column col-lg-4">
				    <h3 class="text-white mt-5">CONTACT</h3>
				    <hr>
				    <ul class="footul">
				        <li class="text-white"><?=$curbranch->email?></li>
    				    <li class="text-white"><?=explode(',',$curbranch->phones)[0]?></li>
    				    <li class="text-white"><?=$curbranch->address?></li>
    				    
				    </ul>
				</div>
				
				<div class="column col-lg-8">
				    
				    <hr>
				    <ul class="footul">
				        <?php echo view('main/page/contact'); ?>
    				    
				    </ul>
				</div>
				
			</div>
		</div>
		
	<!--
	<div class="footer-bottom" style="background-color:#222222!important;">
		<div class="container-fluid d-flex justify-content-center">
			<div class="columns-bottom">
				<div class="cpyrght">
					<p class="copyright">© 2022 SCHILDR
						
					</p>
				</div>
				<div class="footer-nav">
					<ul style="margin-top: 1rem!important;">
						<li><p class="copyright"><?=explode(',',$curbranch->phones)[0]?></p></li>
						
						
					</ul>
				</div>
			</div>
		</div>
	</div>
	-->
	</div>
	
</footer>
 
<script>
      function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('6LfCdtgaAAAAALBd-tKVQvclyP_iasnO_7pOeyIl', {action: 'submit'}).then(function(token) {
              document.getElementById("footer_form").submit();
          });
        });
      }

    $(document).ready(function() {
                $('#footer_form').submit(function() {
                    
                           
                            
                        $('.submio').prop("disabled", true);
                        $('.submiotxt').html('<?=static_area($curlangid,'sending');?>');
                        
                        
                        var email = $('#input-email').val();
                        var zipcode = $('#input-zipcode').val();
                        var branch = '<?=$curbranch->id?>';
                        //var from = 'footer';
                        var from = $('#fromval').val();
                        
                        
                        
                        $.ajax({
                                type: "POST",
                                url:"/fromhome/getEmail",
                                data: {
                                    <?=csrf_token();?>:'<?=csrf_hash();?>',
                                    email: email,
                                    zipcode: zipcode,
                                    branch: branch,
                                    from: from,
                                    },
                                    success: function(data) {
                                        
                                    //    alert(data);
                                      
                                        $('.ajax-error').html('<?=static_area($curlangid,'thankyou');?>');
                                        
                                        $('.submiotxt').html('<?=static_area($curlangid,'send');?>');
                                        
                                     //   window.location.href = "/<?=$curlangcode?>/quotes/thanks"; 
                                    }
                                });
                            return false;
                        });
        
                });
</script>

