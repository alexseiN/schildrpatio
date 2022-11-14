<?php
    $currenturlstring = uri_string();
    error_reporting(0);
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
        <?php $class = ''; if(strpos($currenturlstring,$key_menu)) { $class="active";} ?>
        <div class="menu-item">
            <a class="menu-link <?=$class?>" <?php if($key_menu == 'locstore'){echo 'target="_BLANK"';}?> href="<?=$admin_link.'/'.$key_menu?>">
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