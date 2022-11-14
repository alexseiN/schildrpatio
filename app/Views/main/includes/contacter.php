<style>
    .bread-index {
        font-size: 40px;
    }
</style>

<div class="container-fluid main_center">
    <div class="inner_main_center" style="background-color:#222222;">

        <div class="row">
            <div class="col-lg-6">
                <p class="prj-title "><?=static_area($curlangid,'getfreequote');?></h3>
            </div>
            <div class="col-lg-6" style="text-align:right;">
                <p class="prj-title "><?=static_area($curlangid,'questionscallus');?>: <?=explode(',',$curbranch->phones)[0]?></h3>
            </div>
        </div>
        

        <form class="form-horizontal" role="form" id="extra_quote">
            <div class="form-group row">
                
            

                <div class="col-lg-2 col-xs-3 pb-3">
                    <input required type="text" class="form-control" id="input-fullname" placeholder="<?=static_area($curlangid,'fullname');?>">
                </div>
                <div class="col-lg-2 col-xs-3 pb-3">
                    <input required type="phone" class="form-control" id="input-phone" placeholder="<?=static_area($curlangid,'phone');?>">
                </div>
                <div class="col-lg-2 col-xs-3  pb-3">
                    <input required type="email" class="form-control" id="input-email" placeholder="<?=static_area($curlangid,'email');?>">
                </div>
                <div class="col-lg-2 col-xs-3 pb-3">
                        
                    <input required type="text" class="form-control" id="input-address" placeholder="<?=static_area($curlangid,'address');?>">
                    
                </div>
                <div class="col-lg-2 col-xs-3 pb-3">
                        
                    <input required type="text" class="form-control" id="input-zipcode" placeholder="<?=static_area($curlangid,'ziporpostal');?>">
                    
                </div>
                <div class="col-lg-2 col-xs-3  pb-3">
                    <select class="form-control" id="input-product" required>
                        <option value=" "><?=static_area($curlangid,'select');?></option>
                        
                        <?php foreach ($pdcats as $pdcat) { ?>
                        
                            <option value="<?=$pdcat->id?>"><?=$pdcat->title?></option>
                        
                        <?php } ?>
                    </select>
                </div>

               <div class="col-sm-10 text-left">
                   <p class="prj-title "><?=static_area($curlangid,'byhittingthis');?></p>
                </div>   

                <div class="col-sm-2 text-right">
                    <button type="submit" class="btn submio1 submiotxt1" style="width:100%;background-color:#7396ae;color:#fff"><?=static_area($curlangid,'send');?></button> 
                </div>

            </div>
            
            <div class="ajax-error1 text-right" style="color:#fff!important;margin-bottom:10px;"></div>
       

        
            
            
            
            
            
        </form>

        
    </div>
</div>


<script>
      function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('6LfCdtgaAAAAALBd-tKVQvclyP_iasnO_7pOeyIl', {action: 'submit'}).then(function(token) {
              document.getElementById("extra_quote").submit();
          });
        });
      }

     $(document).ready(function() {
                $('#extra_quote').submit(function() {
                    
                    
                       $('.submio1').prop("disabled", true);
                        $('.submiotxt1').html('<?=static_area($curlangid,'sending');?>');
                        
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
                        
                        
                        var branch = '<?=$curbranch->id?>';
                        
                        var width ='no';
                        var depth ='no';
                        
                        var city ='no';
                        
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
                                    city: city,
                                    width: width,
                                    depth: depth,
                                    branch: branch,
                                    
                                    pid: pid,
                                    
                                    message: message,
                             
                                    },
                                    success: function(data) {
                                        
                                     //   alert(data);
                                      
                                        $('.ajax-error1').html('<?=static_area($curlangid,'datasent');?>');
                                        
                                       // window.location.href = "/<?=$curlangcode?>/quotes/thanks"; 
                                       $('.submiotxt1').html('<?=static_area($curlangid,'sent');?>');
                                    }
                                });
                            return false;
                        });
                        
                        
                        
                });
</script>