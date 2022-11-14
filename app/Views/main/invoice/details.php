<!DOCTYPE html>
<html lang="<?= $curlangcode ?>">
<?php echo view('main/includes/head'); ?>
<style>
    .code {
        width: 3% !important
    }
    .draw {
        width: 4% !important
    }
    .des {
        width: 55% !important
    }
    .color {
        width: 20% !important
    }
    .pkg {
        width: 8% !important
    }
    .price {
        width: 5% !important
    }
    .quant {
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

                <?php
                
                if ($request->unit == 'inc') {
                
                $projection = ($request->depth*25.4) / 1000;
                $width = ($request->width*25.4) / 1000;
                $frontheight = ($request->height1*25.4) / 1000;
                $backheight = ($request->height2*25.4) / 1000;
                
                } else {
                  
                $projection = $request->depth / 1000;
                $width = $request->width / 1000;
                $frontheight = $request->height1 / 1000;
                $backheight = $request->height2 / 1000;  
                    
                    
                    
                }
                
                
                if ($backheight < 3.3) {
                    $height = 3;
                } else {
                    $height = 6;
                }
                $g7 = $height;
                $h7 = ceil($width) + 1;
                $i7 = 1;
                $j7 = $projection * $width * $i7;
                
                $alltotalprice = 0;
                $alltotalweight = 0;
                $pillar = $request->number_of_columns;

                ?>

                <div class="invoice-header row">
                    <div class="col-sm-6">



                        <span>
                            <img width="130" style="filter: brightness(10%);" src="<?= $default_domain ?>/assets/uploads/sites/<?= $main->logo ?>" />
                        </span>



                        <ul class="ns">
                            <li><b>Project Number:</b> <span><?= 'NJ /' . $request->id ?></span></li>
                            <li><b>Date: </b><span><?= date('M d, Y', $request->created)  ?></span></li>
                            <li><b>Customer:</b> <span><?= $request->first_name ?> <?= $request->last_name ?></span></li>
                            <li><b>Phone: </b><span><?= $request->phone ?></span></li>


                        </ul>
                        <br><br>
                    </div>
                    <div class="col-sm-6 righting">
                        <h4 class="ns1">MANUFACTURE DETAILS</h4>
                        
                        <ul class="ns">
                            <li><b>Projection:</b> <span><?= $request->depth ?></span></li>
                            <li><b>Width: </b><span><?= $request->width ?></span></li>
                            <li><b>Front Height: </b><span><?= $request->height1 ?></span></li>
                            <li><b>Back Height: </b><span><?= $request->height2 ?></span></li>
                            <li><b>Pillar: </b><span><?= $pillar ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="invoice-table pagebreak">
                    <div class="col-sm-12">

                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr class="s-item">
                                    <th scope="col" class="code">Code</th>
                                    <th scope="col" class="draw">Draw</th>
                                    <th scope="col" class="des">Description</th>
                                    <th scope="col" class="color">Color</th>
                                    <th scope="col" class="pkg">Price/kg</th>
                                    <th scope="col" class="quant">Quantity</th>
                                    <th scope="col" class="quant">Total kg</th>
                                    <th scope="col" class="price">Price</th>

                                </tr>
                            </thead>
                            <tbody class="tbody-list">
                                <?php $i = 1;

                                foreach ($elements as $el) {
                                    $thiscolor = get_langer('loccolor', 8, $el->colors);

                                    $product = $el;
                                    $quantity = $g7 * $pillar * $i7;
                                    if ($product->code == '560-6001' || $product->code == '560-6003' || $product->code == '560-6105' || $product->code == '560-6201' || $product->code == '560-6104' || $product->code == '560-6106' || $product->code == '560-5102' || $product->code == '3202137') {
                                        $quantity = $width * $i7;
                                    }
                                    if ($product->code == '560-1101' || $product->code == '560-6101' || $product->code == '560-6102' || $product->code == '560-6107') {
                                        $quantity = $h7 * $projection * $i7;
                                    }
                                    if ($product->code == 'SD-9664') {
                                        $quantity = $projection * 2;
                                    }
                                    if ($product->code == '560-5101' || $product->code == '7523901') {
                                        $quantity = $width * 2;
                                    }
                                    if ($product->code == '3202220') {
                                        $quantity = ($width * $i7 * 3) + ($h7 * $projection * $i7 * 4);
                                    }
                                    if ($product->code == '1609706' || $product->code == '1609707') {
                                        $quantity = $i7 * 2;
                                    }
                                    if ($product->code == '9524301' || $product->code == '8003601') {
                                        $quantity = $i7 * $pillar;
                                    }

                                    $totalkg = $quantity * $product->mtkg;
                                    if ($product->mtkg == '') {
                                        $totalkg = $quantity;
                                    }

                                    $totalprice = $product->nprice * $totalkg;
                                    $alltotalprice = $alltotalprice + round($totalprice, 2);
                                    if ($product->code == '1609706' || $product->code == '1609707' || $product->code == '9524301' || $product->code == '8003601' || $product->code == '7523901') {
                                        $totalkg = 0;
                                    }
                                    $alltotalweight = $alltotalweight + $totalkg;
                                    $file = morefiles('locproducts', $el->id);
                                    //echo '<pre>';print_r($file);
                                ?>


                                    <tr class="pagebreak">
                                        <td><?= $i ?></td>
                                        <td><img height="30px" src="<?= $default_domain ?>/assets/uploads/locproducts/<?= $file[0]->filename ?>" /></td>
                                        <td><?= $el->title ?></td>
                                        <td><?= $thiscolor->title ?></td>
                                        <td><?= $el->nprice ?></td>
                                        <td><?= $quantity ?></td>
                                        <td><?= $totalkg ?></td>
                                        <td><?= $totalprice ?></td>

                                    </tr>
                                <?php $i = $i + 1;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12 text-right " style="margin-top:10px;">
                        <?php

                        $glassing = $projection * $width * $i7 * 10.8 * 3.5; //echo $glass.'<br>';
                        
                        $sqft = $j7*10.8;
                        
                        $pandp = $sqft * 1; //echo $pandp.'<br>';
                        $woodbox = 0; //echo $woodbox.'<br>';
                        $transport = 250; //echo $woodbox.'<br>';
                        $manufacturing = $j7*10.8*2;
                        
                        $alltotalprice13 = $alltotalprice*1.3 ;
                        
                        $extra = ($alltotalprice13 + $glassing + $pandp + $manufacturing) * 0.03; //echo $extra.'<br>'; 
                        $extra = round($extra,2);
                        
                        $income = ($alltotalprice13 + $glassing + $pandp + $manufacturing + $extra) * 0.7; //echo $income.'<br>';
                        $income = round($income,2);
                        $office = ($alltotalprice13 + $glassing + $pandp + $manufacturing + $transport + $income) * 0.03;
                        $office = round($office,2);
                        
                        if ($projection>3.5) {$galvanized = $h7*30;} else {$galvanized = 0;}

                        $grandtotal = $alltotalprice13 + $glassing + $pandp + $woodbox + $transport + $manufacturing + $galvanized + $extra + $income + $office;
                        ?>


                        <?php if ($alltotalweight) { ?> <h4>Total weight: <b> <?= round($alltotalweight,2) . ' kg' ?></b></h4><? } ?>

                        <?php if ($alltotalprice13) { ?> <h4>Total: <b> <?= '$' . round($alltotalprice13,2) ?></b></h4> <? } ?>
                        
                        
                        <h6>sqft = <?=$sqft?></h6> 
                        <hr>
                        <h6>Glasing: $<?=$glassing?> </h6>
                        <h6>Production and Package: $<?=$pandp?> </h6>
                        <h6>Transport: $<?=$transport?> </h6>
                        <h6>Manufacturing: $<?=$manufacturing?> </h6>
                        <h6>Galvanized: $<?=$galvanized?> </h6>
                        <h6>Extra: 3% $<?=$extra?> </h6>
                        <h6>Extra: 70% $<?=$income?> </h6>
                        <h6>Office: 3% $<?=$office?> </h6>
                        
                        <hr>
                        <h1>Grand total: $<?=$grandtotal?></h1>
                        
                        <?php  //echo '<pre>'; print_r($datax); ?>
                        
                        <hr class="no-print">
                    </div>
                </div>

                <div class="invoice-footer pagebreak">
                    <div class="footer">UNCLASSIFIED</div>
                    <div class="col-sm-9 standartnotes ns">
                        <ul style="list-style-type:none;padding:0px !important">
                            <li>
                                <h6><b>IMPORTANT NOTES</b></h6>
                            </li>
                            <li>This price calculated Automatically by Schildr Store. If you have any doubths please dont hesitate to contact us.</li>
                        </ul>



                    </div>
                    <div class="col-sm-3 righting">
                        <input class="no-print btn btn-primary" type="button" onclick="printDiv('invdet')" value="Print invoice" />
                        <?php if ($thisregion->id == 14) { ?>
                            <hr>
                            <a style="margin-top:20px;" href="https://app.gethearth.com/partners/schildr?utm_campaign=31082&utm_content=darkblue&utm_medium=contractor-website&utm_source=contractor&utm_term=310x120" target="_blank">
                                <img src="https://app.gethearth.com/contractor_images/schildr/banner.jpg?color=darkblue&size_id=310x120" alt="Hearth 310x120" style="width:100%;max-width:186px" />
                            </a>
                        <?php } ?>
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