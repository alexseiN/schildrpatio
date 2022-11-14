<?php
    $qu=print_count('quotes',array('view'=>0));
    $bd=print_count('becomedealer',array('view'=>0));
    $cu=print_count('fromcontact',array('view'=>0)); 
    $tot = $qu+$bd+$cu;
    
    $main_menu_array = array(
        "General Settings" => array(
            "name"=>"Base",
            "total"=>0,
            "icon"=>"fa fa-cog",
            "menuitems" =>  array(
                "settings"=>"Main","regions"=>"Countries","language"=>"Languages","statictext"=>"Static areas","currency"=>"Currencies","pmethods"=>"Payment methods","socials"=>"Social Networks","email"=>"Document Templates"
            )
        ),
        "Product Management" => array(
            "name"=>"Product Management",
            "total"=>0,
            "icon"=>"bi bi-cart",
            "menuitems" =>  array(
                "pdcats"=>"Categories","applications"=>"Applications","product"=>"Products"
            )
        ),
        "Our Projects" => array(
            "name"=>"Project Management",
            "total"=>0,
            "icon"=>"bi bi-patch-check",
            "menuitems" =>  array(
                "pjcats"=>"Categories","project"=>"Projects"
            )
        ),
        "Content management" => array(
            "name"=>"Content Management",
            "total"=>0,
            "icon"=>"bi bi-sticky",
            "menuitems" =>  array(
                "banner"=>"Banners","page"=>"Page","slider"=>"Slider","partners"=>"Partners","reviews"=>"Reviews & Ratings","videos"=>"Videos","faq"=>"Faq","blog"=>"Blogs"
            )
        ),
        "From Website" => array(
            "name"=>"CRM",
            "total"=>$tot,
            "icon"=>"bi bi-layers",
            "menuitems" =>  array(
                "quotes"=>array("total"=>$qu,"name"=>"Get Quote"),
                "becomedealer"=>array("total"=>$bd,"name"=>"Become a Dealer"),
                "fromcontact"=>array("total"=>$cu,"name"=>"Contact Us"),                
            )
        ),
        "Invoice management" => array(
            "name"=>"Invoice & Estimates",
            "total"=>0,
            "icon"=>"bi bi-hr",
            "menuitems" =>  array(
                "setproject"=>"Invoices"
            )
        ),
        "Local Store" => array(
            "name"=>"Local Store",
            "total"=>0,
            "icon"=>"bi bi-cart",
            "menuitems" =>  array(
                "locstore"=>"Store","locorders"=>"Orders",
            )
        ),
    );
?>
<?php foreach($main_menu_array as $key_main=>$value_main){ ?>
<div data-kt-menu-trigger="click" class="menu-item <?=($active==$key_main)?"here show":""?>  menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="<?=$value_main['icon']?>"></i>
        </span>
        <span class="menu-title"><?=$value_main['name']?></span>
        <?php if ($value_main['total']>0) { ?>
            <span class="badge badge-danger quotik"><?=$value_main['total']?></span>
        <?php } ?>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">
        <?php foreach($value_main['menuitems'] as $key_menu=>$value_menu) { ?>
            
        <div class="menu-item">
            <a class="menu-link" href="<?=$admin_link.'/'.$key_menu?>">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <?php
                    $itemname = $value_menu; $totalmenuitem = 0; if(is_array($value_menu)){ $itemname = $value_menu['name'];$totalmenuitem = $value_menu['total'];} 
                ?>
                <span class="menu-title"><?=$itemname?></span>
                <?php if ($totalmenuitem>0) { ?>
                    <span class="badge badge-danger quotik"><?=$totalmenuitem?></span>
                <?php } ?>
            </a>
        </div>
        
        <?php } ?>
    </div>
</div>
<?php } ?>