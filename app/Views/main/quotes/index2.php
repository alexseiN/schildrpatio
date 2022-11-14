

<?php $products = multiproduct (22 , $curlangid,array('quote'=>1))?>





<div class="container-fluid main_center" id="contact">
    <div class="inner_main_center for_about border_1">
        <form id="quote_form" method="POST">
        <div class="row contact_form ">
                            <input type="text" hidden="" name="product" value="DYNAMIC">
                            <input type="hidden" class="g-recaptcha-response" name="g-recaptcha-response">

                    </div>
        <div class="row contact_form">
                                  
            <div class="col-md-12" style="margin-bottom: 20px">
                <p class="quote-title">
                    <?=static_area($curlangid,'getquote1text');?>
                </p>
            </div>
            
            
                    
            
                                
                    
                    
                    
            
            
            <?php foreach($products as $product) { ?>
                    <div class="col-lg-3 col-md-4 col-xs-6">
                            
                            
                           
                        
                            
                            <label style="width: 100%;height: auto;cursor: pointer" for="prduct<?=$product->id ?>">
                                <img style="width:100%" src="assets/uploads/products/full/<?=$product->image ?> "/>
                            
                            </label>
                            
                            <div class="prj-info" style="margin-bottom: 15px">
                                <p class="prj-title"><input type="checkbox" style="width:20px;height:20px;" name="input-pid" id="prduct<?=$product->id ?>" value="<?=$product->id ?>" class="theClasscheck d-inline mr-3">
                                <?=$product->title ?> 
                                </p>
                            </div>
                    </div>
                                   
            <?php } ?>
            
             
            
            <div class="col-lg-3 col-md-4 col-xs-6">
                            <label style="width: 100%;height: auto;" for="wd">
                                <img style="width:100%" src="assets/wd.jpg"/>
                            
                            </label>
                             <div class="prj-info" style="margin-bottom: 15px">
                                <p class="prj-title"><b style="font-weight:bold">FREE SHIPPING</b></p>
                            </div>
                    </div>
                                   
                
            <div class="row" style="width: 100%;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="first_name" required="" placeholder="<?=static_area($curlangid,'firstname');?>" id="input-first_name"> 
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="last_name" required="" placeholder="<?=static_area($curlangid,'lastname');?>" id="input-last_name">
                        </div>
                        <div class="form-group">
                            <input type="email" required="" class="form-control" name="email" placeholder="<?=static_area($curlangid,'email');?>" id="input-email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"  required="" placeholder="<?=static_area($curlangid,'phone');?>" id="input-phone">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"  required="" placeholder="<?=static_area($curlangid,'address');?>" id="input-address">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"  required="" placeholder="<?=static_area($curlangid,'ziporpostal');?>" id="input-zipcode">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'city');?>" id="input-city">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'width');?>" id="input-width">
                        </div>
                        
                        
                        <div class="form-group">
                            <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'depth')?>" id="input-depth">
                        </div>
                        
                        
                        <div class="form-group">
                            <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'height')?>" id="input-height">
                        </div>
                        
                        
                        
                        
                        <div class="form-group">
                            <textarea style="height: 163px;" class="form-control" required="" id="" cols="30" rows="7" placeholder="<?=static_area($curlangid,'message');?>" name="input-message"></textarea>
                        </div>
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






<script>
    $(document).ready(function() {
        $('#quote_form').submit(function(e) {
            e.preventDefault();
            $('.submio').prop("disabled", true);
            $('.submiotxt').html('<?=static_area($curlangid,'sending');?>');    
            grecaptcha.ready(function() {
              grecaptcha.execute('6LfCdtgaAAAAALBd-tKVQvclyP_iasnO_7pOeyIl', {action: 'submit'}).then(function(token) {
                  document.querySelector('.g-recaptcha-response').value = token;
                  submitquote();
              });
            });            
        });
    });
    function submitquote(){            
        var pid = [];     
        $('.theClasscheck:checkbox:checked').each(function(){
            pid.push($(this).val());
        });       
        pid=pid.toString();        
        var message = $('textarea:input[name=input-message]').val();
        var first_name = $('#input-first_name').val();
        var last_name = $('#input-last_name').val();
        var email = $('#input-email').val();
        var phone = $('#input-phone').val();
        var zipcode = $('#input-zipcode').val();
        var city = $('#input-city').val();
        var address = $('#input-address').val();
        var width = $('#input-width').val();
        var height = $('#input-height').val();
        var depth = $('#input-depth').val();
        var branch = '<?=$curbranch->id?>';
        var incat = '<?=$parent->id?>';
        var g_recaptcha_response = $('.g-recaptcha-response').val();
        $.ajax({
            type: "POST",
            url:"/quotes/getQuote",
            data: {
                    <?=csrf_token();?>:'<?=csrf_hash();?>',
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    incat: incat,
                    phone: phone,
                    zipcode: zipcode,
                    address: address,
                    width: width,
                    depth: depth,
                    height:height,
                    branch: branch,
                    city:city,
                    pid: pid,
                    message: message,
                    'g-recaptcha-response':g_recaptcha_response
                },
            success: function(data) {
                if(data == 'captcha_error'){
                    alert("Something is not right.");
                    location.reload();
                    return false;
                } else {
                   // alert(data);
                    $('.ajax-error').html('<?=static_area($curlangid,'datasent');?>');
                    
                }                                      
            }
        });
    }
</script>

