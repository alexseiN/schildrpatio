<!DOCTYPE html>
<html lang="<?= $curlangcode ?>">
<?php echo view('main/includes/head'); ?>
<style>
    .no {
        width: 3% !important
    }
    .pn {
        width: 35% !important
    }
    .dim {
        width: 10% !important
    }
    .fh {
        width: 10% !important
    }
    .bh {
        width: 10% !important
    }
    .col {
        width: 5% !important
    }
    .sc {
        width: 10% !important
    }
    
    .po {
        width: 10% !important
    }
    .price {
        width: 5% !important
    }
    .invoice {
        margin: 0px 0;
        padding-top: 15px;
        padding-bottom: 15px;
        padding-left: 5%;
        padding-right: 5%;
    }
    .intable {
        width: 100%;
        border: 1px solid red;
    }
    .ns,
    .ns2 {
        padding: 5px 10px;
        margin-top: 10px;
        list-style: none;
        font-size: 10px;
    }
    .ns1 {
        padding: 5px 10px;
        margin-top: 10px;
        list-style: none;
        font-weight: bold;
    }
    .ns span,
    .ns b {
        display: inline-block;
        padding-right: 3px;
        < !--
        /*width: 200px;*/
        -->
    }
    .ns li {
        margin-bottom: 3px;
    }
    @-webkit-keyframes downarrow {
        0% {
            -webkit-transform: translateY(0);
            opacity: 0.4
        }
        100% {
            -webkit-transform: translateY(0.4em);
            opacity: 0.9
        }
    }
    .arrow1 {
        border-color: transparent;
        border-style: solid;
        border-width: 0 2em;
        display: block;
        height: 0;
        float: right;
        margin: 1em;
        opacity: 0.4;
        text-indent: -9999px;
        transform-origin: 50% 50%;
        width: 0;
    }
    .down1 {
        -webkit-animation: downarrow 0.6s infinite alternate ease-in-out;
        border-top: 2em solid #00b6f1;
    }
    .table td,
    .table th {
        padding: 2px !important;
        vertical-align: middle;
        font-size: 8px;
    }
    .firstpage {
        height: auto;
        padding: 5%;
        max-width: 90%;
        background-image: url('<?= $default_domain ?>/assets/uploads/invoiceback.jpg');
        background-color: #121a41;
        background-repeat: no-repeat;
        background-size: 100%;
    }
    .clientdata {
        color: #fff;
        font-size: 15px;
        padding: 0 5%;
    }
    .arrow {
        display: block !important;
    }
    .righting {
        text-align: left;
    }
    .buyer {
        font-size: 25px;
        color: #fff;
    }
    @media (min-width: 700px) {
        .buyer {
            font-size: 40px;
            color: #fff;
        }
        .firstpage {
            height: 90vh;
        }
        p {
            font-size: 18px;
        }
        .table td,
        .table th {
            padding: 5px !important;
            vertical-align: middle;
            font-size: 14px;
        }
        .righting {
            text-align: right;
        }
        .ns,
        .ns2 {
            padding: 5px 10px;
            margin-top: 10px;
            list-style: none;
            font-size: 13px;
        }
    }
</style>
<body class="home" style="font-family: 'Roboto', sans-serif;">
    <br>
    <div class="container-fluid firstpage">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-8 righting">
                <div class="clientdata">
                    <a target="_blank" href="http://point.schildr.store/">
                    <img style="width:250px;filter: brightness(0)invert(100%);" src="<?= $default_domain ?>/assets/uploads/sites/<?= $main->logo ?>" />
                    </a>
                    <br><br><br>
                    <h1 class="buyer"> Dear, <?= $request->first_name ?> <?= $request->last_name ?></h1>
                    <br>
                    <p>Thank you for your interest in our products. You can see the proposal of the product you are interested in below.
                        If you have any question don’t hesitate to contact us.</p>
                    <h5><?= date('M d, Y', $request->created-9*3600)  ?></h5>
                    <a id="arrowDown" class="arrow1 down1" style="cursor:pointer;"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="invdet" style="max-width:90%; border:1px solid #b5b5b5; padding:50px 0;">
        <div id="MainInvoice" class="invoice">
            <div class="row">
                <style>
                    .standartnotes li {
                        list-style: none;
                    }
                    .standartnotes ul {
                        padding: 0px !important;
                    }
                    .invoice-header {
                        display: contents;
                    }
                    .invoice-table {
                        width: 100%;
                    }
                    .invoice-footer {
                        width: 100%;
                        display: flex;
                    }
                    @media print {
                        @page {
                            size: landscape;
                        }
                        .standartnotes li {
                            list-style: inherit;
                        }
                        .standartnotes ul {
                            padding: revert !important;
                        }
                        body {
                            padding: 0px 15px !important;
                            -ms-zoom: 2.665;
                        }
                        #invdet {
                            display: inline-block;
                        }
                        table {
                            border-collapse: collapse;
                        }
                        td,
                        th {
                            border: 1px solid black !important;
                        }
                        .no-print,
                        .no-print * {
                            display: none !important;
                        }
                        .pagebreak {
                            /*page-break-after:auto;*/
                            /*break-after:page;*/
                            clear: both;
                            page-break-before: auto;
                            page-break-inside: avoid;
                        }
                        div.footer {
                            position: static;
                            bottom: 0;
                            display: none;
                        }
                        .invoice-header {
                            margin-top: 40px;
                            display: flex;
                        }
                    }
                    @media screen {
                        div.footer {
                            display: none;
                        }
                    }
                </style>
                
                <?php $thisbranch = get_langer('branches', 8, 15); ?>
                
                <div class="invoice-header row">
                    <div class="col-sm-6">
                        <span>
                            <a target="_blank" href="http://point.schildr.store/">
                            <img width="130" style="filter: brightness(10%);" src="<?= $default_domain ?>/assets/uploads/sites/<?= $main->logo ?>" />
                            </a>
                        </span>
                        <ul class="ns">
                            <li><b>Price Calculated by:</b> <?=$thisbranch->name?></li>
                            <li><b>Phone:</b> <?= $thisbranch->phones ?></b></li>
                            <li><b>Email:</b> <?= $thisbranch->email ?></b></li>
                            <li><b>Address:</b> <?= $thisbranch->address ?></b></li>
                        </ul>
                        <br><br>
                    </div>
                    <div class="col-sm-6 righting">
                        <h4 class="ns1">INVOICE</h4>
                        <ul class="ns">
                            <li><b>Project Number:</b> <span><?= 'NJ /' . $request->id ?></span></li>
                            <li><b>Date: </b><span><?= date('M d, Y', $request->created -9*3600)  ?></span></li>
                        </ul>
                        <ul class="ns">
                            <li><b>Customer:</b> <span><?= $request->first_name ?> <?= $request->last_name ?></span></li>
                            <li><b>Phone: </b><span><?= $request->phone ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="invoice-table pagebreak">
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr class="s-item">
                                    
                                    <th scope="col" class="pn">Product Name</th>
                                    <th scope="col" class="dim">Dimensions (<?= $request->unit ?>)</th>
                                    <th scope="col" class="fh">Front Height (<?= $request->unit ?>)</th>
                                    <th scope="col" class="bh">Back Height (<?= $request->unit ?>)</th>
                                    <th scope="col" class="col">Columns</th>
                                    <th scope="col" class="sc">Polycarbonate option</th>
                                    <th scope="col" class="po">Structure color</th>
                                    <th scope="col" class="price">Price</th>
                                </tr>
                            </thead>
                            <tbody class="tbody-list">
                                
                                <tr class="pagebreak">
                                   
                                    <td>Patio Cover Point</td>
                                    <td><?= usw($request->width,$request->unit) ?> X <?= usw($request->depth,$request->unit) ?></td>
                                    <td><?= usw($request->height1,$request->unit) ?></td>
                                    <td><?= usw($request->height2,$request->unit) ?></td>
                                    <td><?= $request->number_of_columns ?></td>
                                    <td><?= $request->glass_texture ?></td>
                                    <td><?php if($request->cover_color == '#f6f6f6') {echo 'RAL9003';} else { echo 'RAL7016';}  ?></td>
                                    <td>$<?= round($request->price, 2) ?></td>
                                </tr>
                                <?php if ($request->light == 1) { ?>
                                    <tr class="pagebreak">
                                       
                                        <td colspan="7">Led lighting</td>
                                        <td>$<?=$request->ledprice?></td>
                                    </tr>
                                <?php } ?>
                                <tr class="pagebreak">
                                        
                                        <td colspan="7">Installation</td>
                                        <td>$<?=$request->install?></td>
                                    </tr>
                                    
                                    <tr class="pagebreak">
                                    
                                    <td colspan="7">Price</td>
                                    <td><?= '$' . round(($request->price+$request->ledprice+$request->install), 2) ?></td>
                                </tr>
                                    
                                <?php if($request->discount) { ?>    
                                <tr class="pagebreak">
                                    
                                    <td colspan="7">Discount</td>
                                    <td><?=$request->discount?>%</td>
                                </tr>
                                <?php } ?>
                                
                                    
                                    
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="col-sm-12 row text-right " style="margin-top:10px;">
                        <?php if ($request->weight) { ?>
                            <div class="col-md-6 text-left">
                            <h5>Total weight: <b> <?= round($request->weight, 2) . ' kg' ?></b></h5>
                            </div>
                        <? } ?>
                        <?php if ($request->price) { 
                            
                            $grandtotal2 = round(($request->price+$request->ledprice+$request->install), 2);
                            $discounted = $grandtotal2-$grandtotal2*$request->discount/100;
                        
                        
                        
                        ?>
                        <div class="col-md-6 text-right">
                            <h5>Total Price: <b> <?= '$' . round($discounted,2) ?></b></h5> 
                            </div>
                        <? } ?>
                        <hr class="no-print">
                        <br>
                    </div>
                    <hr>
                </div>
                <div class="invoice-footer pagebreak">
                    <div class="footer">UNCLASSIFIED</div>
                    <div class="col-sm-9 standartnotes ns">
                        
                        
                         <ul style="list-style-type:none;padding:0px !important">

                            <li>

                                <h6><b>IMPORTANT NOTES</b></h6>

                            </li>

                        </ul>
                        
                        
                        <?= html_entity_decode($thisbranch->about) ?>
                        
                        
                        <ul style="margin-top:20px;display:none;">
                            <img style="width:120px;filter: brightness(10%);" src="<?=$default_domain?>/assets/uploads/sites/<?= $main->logo ?>" />
                            <br><br><br>
                        </ul>
                        
                    </div>
                    <div class="col-sm-3 righting text-end">
                            
                            <input class="no-print btn btn-primary" type="button" onclick="printDiv('invdet')" value="Print invoice" />
                        
                            <hr>
                            
                            
                            
                            
                            
                            <a style="margin-top:20px;" href="https://app.gethearth.com/partners/schildr?utm_campaign=31082&utm_content=darkblue&utm_medium=contractor-website&utm_source=contractor&utm_term=310x120" target="_blank">
                                <b style="border:1px solid #68aff7;padding:7px 10px;width:186px;text-align:center; display:inline-block;float:right">FINANCE</b>
                                
                                <img src="https://app.gethearth.com/contractor_images/schildr/banner.jpg?color=darkblue&size_id=310x120" alt="Hearth 310x120" style="width:186px" />
                            </a>
                       
                        
                        
                        
                        
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
        <link href="<?= site_url() ?>assets/plugins/edittable/css/custom.css" rel="stylesheet" type="text/css">
        <script src="<?= site_url() ?>assets/plugins/edittable/js/bootstrap-editable.js" type="text/javascript"></script>
        <script type="text/javascript">
            function printDiv() {
                var originalContents = document.body.innerHTML;
                var printContents = $('#invdet>#MainInvoice>.row').get(0).innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
        </script>
        <script>
            $("#arrowDown").click(function() {
                $('html, body').animate({
                    scrollTop: $("#MainInvoice").offset().top
                }, 1000);
                console.log($("#MainInvoice").offset());
            });
        </script>
        <?php echo view('main/includes/end'); ?>