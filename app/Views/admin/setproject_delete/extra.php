<?php 

$thisEmployee = get_langer('employees',false,$adminDetails->employee_id);
                
 $thisbranch = get_langer('branches',$admin_lang,$thisEmployee->branch_id);                

                
                ?>

<link href="<?=site_url()?>assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div></div>  
            <div class="portlet-body">
                                        
 

<style>
    
    .nm {width:2%!important}
    .pn {width:15%!important}
    .dm {width:15%!important}
    .qt {width:3%!important}
    .stc {width:20%!important}
    .cvc {width:20%!important}
    .ma {width:10%!important}
    .des {width:15%!important}
    
   .invoice {
        margin:80px 0;
        padding-top: 15px;
        padding-bottom: 15px;
        padding-left: 5%; 
        padding-right: 5%;
    }
    
    .intable{
        width:100%;
        border:1px solid red;
    }
    
    .ns, .ns2 {
        padding:5px 10px;
        margin-top:10px;
        list-style:none;
        font-size:10px;
    }
    
    .ns1 {
        padding:5px 10px;
        margin-top:10px;
        list-style:none;
        font-weight:bold;
    }
    
    .ns span, .ns b {
        display:inline-block;
        width:200px;
       
    }
    .ns li {
        margin-bottom:3px;
    }
    
    
    
    @-webkit-keyframes downarrow {
        0% { -webkit-transform: translateY(0); opacity: 0.4 }
        100% { -webkit-transform: translateY(0.4em); opacity: 0.9 }
    }

    .arrow1 {
        border-color:transparent;
        border-style:solid;
        border-width:0 2em;
        display:block;
        height:0;
        float:right;
        margin:1em;
        opacity:0.4;
        text-indent:-9999px;
        transform-origin: 50% 50%;
        width:0;
    }

    .down1 {
        -webkit-animation: downarrow 0.6s infinite alternate ease-in-out;
        border-top:2em solid #00b6f1;
    }

    .table td, .table th {
        padding: 2px!important;
        vertical-align: middle; 
        font-size:8px;
    }
    
    .firstpage {
        height:auto;
        padding:5%;
        max-width:90%;
        background-image:url('/assets/uploads/invoiceback.jpg');
        background-color:#121a41;
        background-repeat: no-repeat;
        background-size: 100%;
    }
    .clientdata {
            color: #fff;
            font-size: 15px; 
            padding: 0 5%;
            
        }
        
    .arrow {
        display:block!important;
    }
    
    .righting {
        text-align:left;
    }
    
    .buyer {
        font-size:25px;
        color:#fff;
    }
   
    
    @media (min-width: 700px) {
 
        .buyer {
        font-size:40px;
        color:#fff;
    }
        
        .firstpage{
            height:90vh;
            
            
        }
        
        p {
            font-size:18px;
        }
        
        .table td, .table th {
        padding: 5px!important;
        vertical-align: middle; 
        font-size:14px;
    }
    
    .righting {
        text-align:right;
    }
        
    .ns, .ns2 {
        padding:5px 10px;
        margin-top:10px;
        list-style:none;
        font-size:13px;
    } 
 
    }
    
    
 
    
   
}
    
</style>


<style type="text/css" media="print">
    @page {
        size: landscape;   /* auto is the initial value */
        margin: 0;  /* this affects the margin in the printer settings */
        
    }
    body { 
        
        writing-mode: initial;
        
    }
    
     table{
                    border-collapse:collapse;
                }
                td,th{
                    border:1px solid black !important;              
                }
    
    .no-print, .no-print *
    {
        display: none !important;
    }
    
    a[href]:after { content: none !important; }
</style>





<?php 

$extratotal = floatval($setproject->tax) + 
              floatval($setproject->shipping) + 
              floatval($setproject->transportation) + 
              floatval($setproject->insurance) + 
              floatval($setproject->extra) + 
              floatval($setproject->install) +
              floatval($setproject->incomen);

$included = array();

if (floatval($setproject->tax)) { array_push($included,'Tax');}
if (floatval($setproject->shipping)) { array_push($included,'Shipping');}
if (floatval($setproject->install)) { array_push($included,'Installation');}
if (floatval($setproject->insurance)) { array_push($included,'Insurance');}






$thisemploee = get_langer('employees',false,$setproject->employee);




$thisbranch = get_langer('branches',8,$thisemploee->branch_id);  

$thisregion = get_langer('regions',8,$thisbranch->region_id);

$thiscurrency = get_langer('currency',false,$thisbranch->currency);


$branchtel = explode(',',$thisbranch->phones);

$subcatm = get_langer('pdcats',8,$setproject->product_category);
$maincatm = get_langer('pdcats',8,$subcatm->parent_id);




?>

<style>
    
    .sentconfirm {
        background-image: url('assets/uploads/sites/schildr.document.sent.png');
        background-size: 45% auto;
        background-repeat: no-repeat;
        background-attachment: absolute;
        background-position: right bottom;
        max-width:100%; 
        border:1px solid #b5b5b5; padding:50px 0;
        
    }
    
</style>

        
        <div class="container-fluid sentconfirm" id="invdet" style="padding-bottom:10px!important;"> 

            <div id="MainInvoice" class="invoice">
                
                <div class="row">
                    
                    
                    <div class="col-sm-6">
                                <img style="width:200px;filter: brightness(10%);" src="assets/uploads/sites/<?=$main->logo?>" />
                                <?php if ($thisbranch->ortype == 'virtual') {} else { ?>
                                <ul class="ns">
                                    <li><b><?=$thisbranch->name?></b></li>
                                    <li><?=$thisbranch->address?></li>
                                     
                                    <li><b>Branch contacts:</b>
                                        <span>
                                            <?php  $i=0; foreach($branchtel as $tel) {  ?>
                                                        <?=$tel?>
                                                        <?php  if(next($branchtel)) {echo ',';}?>
                                            <? $i=$i+1; } ?>
                                        </span>
                                    </li>
                                    
                                </ul>
                                <?php } ?>
                                <ul class="ns">
                                    <li><b>Created by:</b> <?=$thisemploee->first_name?> <?=$thisemploee->last_name?></li>
                                    <li><b>Phones:</b>  <?=$thisemploee->mobile?></b></li>
                                </ul>
                                <br><br>
                            </div>
                    
                    <div class="col-sm-6 righting">
                        <h4 class="ns1"><?php if($setproject->invoice == 1) { echo 'INVOICE';} else { echo 'ESTIMATE';} ?></h4>
                        
                        <ul class="ns">
                            <li><b>Project Number:</b>   <span><?=$thisbranch->code.'/'.$setproject->id?></span></li>
                            <li><b>Date: </b><span><?= branchtime($setproject->created,$thisbranch->diff,'M d,Y h:i')  ?></span></li>
                        </ul>
                        
                        <ul class="ns">
                            <li><b>Buyer:</b>   <span><?=$setproject->buyer?></span></li>
                            <li><b>Address or ZIP: </b><span><?=$setproject->address?></span></li>
                            
                            
                        </ul>
                        
                        
                        
                    </div>
                
                
                
             
                <div class="col-sm-12">
                    <h6><?=$maincatm->title?></h6>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr  class="s-item">
                                <th scope="col" class="nm">No</th>
                                <th scope="col" class="pn">Product Name</th>
                                <th scope="col" class="dm">Dimension (<?=$thisbranch->metric?>)</th>
                                <th scope="col" class="stc">Structure Color</th>
                                <th scope="col" class="cvc">
                                    <?php if($maincatm->secolorcats) {echo 'Glass Type';} else { echo 'Cover Color';}?>
                                </th>
                                <th scope="col" class="ma">Motor Automation</th>
                                <th scope="col" class="des">Description</th>
                                <th scope="col" class="qt">Qty</th>
                                <th scope="col" class="qt">Unit Price</th>
                                <th scope="col" class="qt">Total</th>
                              
                               
                            </tr>
                        </thead>
                        <tbody class="tbody-list">
                            <?php $i=1; $total = 0; $selprods = orinpro($selprods);foreach($selprods as $selprod) {  ?>
                            
                            
                            <?php $thisproduct = get_langer('product',8,$selprod->sproduct); ?>
                            
                            
                            <?php 
                                
                                $total = $total + $selprod->uprice*$selprod->qty;
                                
                                $scolor = get_langer('colors',8,$selprod->scolor);
                                $fcolor = get_langer('colors',8,$selprod->fcolor);
                            ?>    
                            
                            <tr>
                                <td><?=$i?></td>
                                <td><b><?=$thisproduct->title?></b></td>
                                <td><?=$selprod->dimensions?></td>
                                <td>
                                    <?php if($scolor->image) { ?>
                                    <img width="20px" height="20px" src="assets/uploads/colors/small/<?=$scolor->image?>"/>
                                    <?php } ?>
                                    <?=$scolor->title?></td>
                                <td>
                                    <?php if($fcolor->image) { ?>
                                    <img width="20px" height="20px" src="assets/uploads/colors/small/<?=$fcolor->image?>"/>  
                                    <?php } ?>
                                    <?=$fcolor->title?></td>
                                <td><?=$selprod->motorauto?></td>
                                <td><?=$selprod->additional?></td>
                                <td><?=$selprod->qty?></td>
                                <td><?=$selprod->uprice?></td>
                                <td><?=$selprod->qty*$selprod->uprice?></td>
                               
                      
                                
                            </tr>
                            <?php $i = $i + 1; } ?>
                            
                        </tbody>
                    </table>
                
                
                
                
                
                </div>
                
                <!--div class="col-sm-6 row">
                <?php foreach($selprods as $selprod) { 
                
                $thisproduct = get_langer('product',8,$selprod->sproduct); ?>
                
                    
                    <div class="col-sm-2">
                        <img width="100%" src="assets/uploads/products/full/<?=$thisproduct->image?>"/>
                        
                    </div>
                
                
                <?php } ?>
                </div-->
                
                
                
                <div class="col-sm-12 text-right">
                    <?php if($total) { ?>
                        
                        <h4>Total: <b><?php if($thiscurrency->symbol == '$' OR $thiscurrency->symbol == '£') {echo $thiscurrency->symbol;}?><?=$total + $extratotal?> <?php if($thiscurrency->symbol <> '$' AND $thiscurrency->symbol <> '£') {echo $thiscurrency->symbol;}?></b></h4>
                        
                    <? } ?>
                    <hr class="no-print">
                </div>
                
                
                
                
                <?php  foreach($subprojects as $subproje) { ?>
                
                <?php $subproducts = orinpro(get_table_where('selproducts',array('category_id'=>$subproje->id)));  
                
                $subcat = get_langer('pdcats',8,$subproje->product_category);
                $maincat = get_langer('pdcats',8,$subcat->parent_id);
            
                
                ?>
                
                
                <div class="col-sm-12">
                    <h6><?=$maincat->title?></h6>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr  class="s-item">
                                <th scope="col" class="nm">No</th>
                                <th scope="col" class="pn">Product Name</th>
                                <th scope="col" class="dm">Dimension (<?=$thisbranch->metric?>)</th>
                                <th scope="col" class="stc">Structure Color</th>
                                <th scope="col" class="cvc">
                                    <?php if($maincat->secolorcats) {echo 'Glass Type';} else { echo 'Cover Color';}?>
                                </th>
                                <th scope="col" class="ma">Motor Automation</th>
                                <th scope="col" class="des">Description</th>
                                <th scope="col" class="qt">Qty</th>
                                <th scope="col" class="des">Unit Price</th>
                                <th scope="col" class="qt">Total</th>
                         
                               
                            </tr>
                        </thead>
                        <tbody class="tbody-list">
                            <?php $i=1; $total = 0; foreach($subproducts as $selprod) {  ?>
                            
                            
                            <?php $thisproduct = get_langer('product',8,$selprod->sproduct); ?>
                            
                            
                            <?php 
                                
                               
                                
                                $total = $total + $selprod->uprice*$selprod->qty;
                                
                                $scolor = get_langer('colors',8,$selprod->scolor);
                                $fcolor = get_langer('colors',8,$selprod->fcolor);
                                
                                
                                
                                
                            ?>    
                            
                            <tr>
                                <td><?=$i?></td>
                                <td><b><?=$thisproduct->title?></b> </td>
                                <td><?=$selprod->dimensions?></td>
                                <td>
                                    <?php if($scolor->image) { ?>
                                    <img width="20px" height="20px" src="assets/uploads/colors/small/<?=$scolor->image?>"/>
                                    <?php } ?>
                                    <?=$scolor->title?></td>
                                <td>
                                    <?php if($fcolor->image) { ?>
                                    <img width="20px" height="20px" src="assets/uploads/colors/small/<?=$fcolor->image?>"/>
                                    <?php } ?>
                                    <?=$fcolor->title?></td>
                                <td><?=$selprod->motorauto?></td>
                                <td><?=$selprod->additional?></td>
                                <td><?=$selprod->qty?></td>
                                <td><?=$selprod->uprice?></td>
                                <td><?=$selprod->qty*$selprod->uprice?></td>
                        
                      
                                
                            </tr>
                            <?php $i = $i + 1; } ?>
                            
                        </tbody>
                    </table>
                
                
                
                
                
                </div>
                
                <!--div class="col-sm-6 row">
                <?php foreach($subproducts as $selprod) { $thisproduct = get_langer('product',8,$selprod->sproduct); ?>
                
                    
                    <div class="col-sm-2">
                        <img width="100%" src="assets/uploads/products/full/<?=$thisproduct->image?>"/>
                        
                    </div>
                
                
                <?php } ?>
                </div-->
                
               
                <div class="col-sm-12 text-right">
                    <?php if($total) { ?>
                    
                        
                        <h4>Total: <b><?php if($thiscurrency->symbol == '$' OR $thiscurrency->symbol == '£') {echo $thiscurrency->symbol;}?><?=$total + $extratotal?> <?php if($thiscurrency->symbol <> '$' AND $thiscurrency->symbol <> '£') {echo $thiscurrency->symbol;}?></b></h4>
                        
                    <? } ?>
                    
                <hr class="no-print">  
                    
                </div>
                
                
                
                
                <?php } ?>
                
                
                <div class="col-sm-12 standartnotes ns">
                    
                    <ul>
                        <li>
                            <h6><b>IMPORTANT NOTES</b></h6>
                        </li>
                    </ul>
                    
                    <ul>
                        <li>
                            <?php if($total) { ?>
                                <?php if($extratotal) { ?><b>Option included:</b> <?=implode(', ',$included)?><?php } ?>
                            <? } ?>
                        </li>
                    </ul>
                    <?=html_entity_decode($setproject->notes)?>
                    <?=html_entity_decode($thisbranch->about)?>
                        
                        
                    <?php if($setproject->invoice == 1){ ?>    
                    <ul>
                        <li>
                            <h6><b>OUR REQUISITES</b></h6>
                        </li>
                    </ul>    
                        
                    <?=html_entity_decode($thisbranch->requisite)?>
                   
                    <?php } ?>
                    
                    
                </div>
                
                
                <div class="col-sm-12 standartnotes ns">
                    
                    <ul>
                        <li>
                            <h6><b>EXTRA INFORMATION</b></h6>
                        </li>
                    </ul>
                    
                    <ul>
                        <li><b>Tax:</b><?=floatval($setproject->tax)?></li>
                        <li><b>Shipping:</b><?=floatval($setproject->shipping)?></li>
                        <li><b>Transportation:</b><?=floatval($setproject->transportation)?></li>
                        <li><b>Insurance:</b><?=floatval($setproject->insurance)?></li>
                        <li><b>Extra:</b><?=floatval($setproject->extra)?></li>
                        <li><b>Install:</b><?=floatval($setproject->install)?></li>
                        <li><b>Income:</b><?=floatval($setproject->incomen)?></li>
                    </ul>
          
                        
                        
                 
                    
                    
                </div>
                
                
               
                <style>
                    .standartnotes li {
                        list-style:none;
                    }
                    .standartnotes ul {
                        padding:0px!important;
                    }
                </style>
                
                
                
                
                
                
                
                
                
                
            
                </div>     
                
                
                
            </div>       
           
            <div class="col-sm-12 text-right" style="padding: 0 5%">
                
                    <input style="width:100%" type="email" class="form-control" id="extraemails" placeholder="Enter more emails by comma">
              
                    <button class="btn btn-danger" type="button" style="margin-bottom:10px" onclick="sendInvoice()">Resend Email</button>
                 
                <div class="ajax-error"></div>
            </div>
            

        </div>
        
       
                                    
            </div>
        </div>
        <!-- end panel -->
    </div>

    


</div>





<link href="<?=site_url()?>assets/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="<?=site_url()?>assets/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js" type="text/javascript" language="javascript"></script>

<script>
    $(document).ready(function () {
        $(".edit-form").submit(function () {
            $(".submitBtn").button('loading');
            return true;
        });
    });
</script>


<link href="<?=site_url()?>assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script>
    function sendInvoice() {
	    var answer = confirm("Do you think invoice is ready to send it to client?");	    
	    if (!answer)
            return false;
            
            
	    
	    var mainemail = '<?=$setproject->email?>';
	    
	    var extraemail = $('#extraemails').val();
	    
	    email = mainemail+','+extraemail;
	    
	    var count = '<?=$setproject->count?>';
	    var invoice_id = '<?=$setproject->id?>';
	    var buyer = '<?=$setproject->buyer ?>';
	    var link = '<?=$setproject->link ?>';
	    var emp_email = '<?=$thisemploee->email?>';
	    
	    alert(email);
	    
	    var data = {
                email: email,
                invoice_id: invoice_id,
                buyer:buyer,
                link:link,
                count:count,
                emp_email:emp_email
            };
        $.ajax({
            url: "admin123/invoice/send_invoice_mail",
            type: 'get',
            data: data,
            success: function(res) {
                $('.ajax-error').html('This Email already Sent: ' + email); 
                //window.location.href = 'admin123/setproject/extra/<?=$setproject->id?>';
            },
            error: function(e) {
                alert('Error Processing your Request!!');
            }
        });
	}
    
    
    
    
</script>






