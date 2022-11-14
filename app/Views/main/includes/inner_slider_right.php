<style>
    .whitefor {
        color:#fff!important
    }
    
</style>






<div class="carousel_right_zone" style="width:400px">
    <div class="carousel_right_zone_inner whitefor">
        
        
        <form class="form-horizontal" role="form" id="extra_quote_sl">
            <div class="form-group row">
                
            

                <div class="col-lg-12 pb-3">
                    <input required type="text" class="form-control" id="input-fullname" placeholder="<?=static_area($curlangid,'fullname');?>">
                </div>
                <div class="col-lg-12 pb-3">
                    <input required type="phone" class="form-control" id="input-phone" placeholder="<?=static_area($curlangid,'phone');?>">
                </div>
                <div class="col-lg-12 pb-3">
                    <input required type="email" class="form-control" id="input-email" placeholder="<?=static_area($curlangid,'email');?>">
                </div>
                <div class="col-lg-12 pb-3">
                    <input required type="text" class="form-control" id="input-address" placeholder="<?=static_area($curlangid,'address');?>">
                </div>
                <div class="col-lg-12 pb-3">
                    <input required type="text" class="form-control" id="input-zipcode" placeholder="<?=static_area($curlangid,'ziporpostal');?>">
                </div>
                <div class="col-lg-12 pb-3">
                    <input required type="text" class="form-control"  id="input-city" placeholder="<?=static_area($curlangid,'city');?>" >
                </div>
                <div class="col-lg-12 pb-3">
                    <select class="form-control" id="input-product" required>
                        <option value=" "><?=static_area($curlangid,'products');?></option>
                        
                        <?php foreach ($pdcats as $pdcat) { ?>
                        
                            <option value="<?=$pdcat->id?>"><?=$pdcat->title?></option>
                        
                        <?php } ?>
                    </select>
                </div>

               

                <div class="col-sm-12">
                    <button type="submit" class="btn submio_sl submiotxt_sl" style="width:100%;background-color:#7396ae;color:#fff"><?=static_area($curlangid,'getfreequote');?></button>
                </div>

            </div>
            
            <div class="ajax-error_sl text-right" style="color:#fff!important;margin-bottom:10px;"></div>
       

     
            
            
            
            
            
        </form>
        
        
        

    </div>


    <div class="carousel_right_zone_inner text-uppercase">
        
    </div>
    <span class="open_right">

        <i class="fa fa-angle-right"></i>
    </span>
</div>


<script>
      function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('6LfCdtgaAAAAALBd-tKVQvclyP_iasnO_7pOeyIl', {action: 'submit'}).then(function(token) {
              document.getElementById("extra_quote_sl").submit();
          });
        });
      }

     $(document).ready(function() {
                $('#extra_quote_sl').submit(function() {
                    
                    
                       $('.submio_sl').prop("disabled", true);
                        $('.submiotxt_sl').html('<?=static_area($curlangid,'sending');?>');
                        
                        var pid = [];
                       
                    
                        var fulln = $('#input-fullname').val();
                        
                        
                        
                        var fullName = fulln.split(' '),
                        first_name = fullName[0],
                        last_name =  fullName[fullName.length - 1];
                        
                        
                        
                        var email = $('#input-email').val();
                        var phone = $('#input-phone').val();
                        
                        var zipcode = $('#input-zipcode').val();
                        var address = $('#input-address').val();
                        var incat = $('#input-product').val();
                        var city = $('#input-city').val();
                        
                        
                        var branch = '<?=$curbranch->id?>';
                        
                        var width ='no';
                        var depth ='no';
                        
                        var dc = $('#downloadcatalog').val(); 
                        
                        //alert(dc);
                        
                        var message = '';
                       
                        
                        
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
                                    branch: branch,
                                    city:city,
                                    
                                    pid: pid,
                                    
                                    message: message,
                             
                                    },
                                    success: function(data) {
                                        
                                     //   alert(data);
                                      
                                        $('.ajax-error_sl').html('<?=static_area($curlangid,'datasent');?>');
                                        
                                       // window.location.href = "/<?=$curlangcode?>/quotes/thanks"; 
                                       $('.submiotxt_sl').html('<?=static_area($curlangid,'sent');?>');
                                    }
                                });
                            return false;
                        });
                        
                        
                        
                });
</script>