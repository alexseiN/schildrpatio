<?php echo view('main/includes/head'); ?>

<?php echo '<pre>';print_r($itemcat);die();?>


<style>
    .colroum {
        padding:25px 0;
        border-bottom: 1px solid #ededed; 
    }
    
    .colroum h5{
        text-transform:uppercase;
        font-size:1.25rem;
    }
    
    .colroum p{
        text-transform:uppercase;
        
    }
</style>
<?php echo view('main/includes/top'); ?> 

<?php 

$related = sub_langers('pdcats', $curlangid, $parent->id); 



?>

<?php 

    $products = multiproduct ($itemcat->id , $curlangid,array('enabled'=>1));
    $qproducts = multiproduct ($itemcat->id , $curlangid,array('quote'=>1));
    
    

?>

<div class="main_top">

    

<?php $subitems = sub_langers('pdcats', $curlangid, $itemcat->id); ?>

<?php 
    
    $this->data['carotitle'] = $itemcat->title;
    $this->data['carosub'] = $parent->title;
    $this->data['videom'] = $itemcat->video;
    $this->data['slidefiles'] = morefiles('pdcats', $itemcat->id); 
    $this->data['subitems'] = $qproducts;
    $this->data['sublink'] = '' ;
    $this->data['titleonslider'] = $itemcat->title ;
    $this->data['secondary'] = $itemcat->secondary ;
    $this->data['onslider'] = $parent->about ;
    
    $this->data['quotelink'] = $curlangcode.'/quotes/'.$itemcat->slug;
    
    $this->data['slpath'] = '/assets/uploads/pdcats/' ;
					
	echo view('/main/common/inslidesub',$this->data);
	
	?>

    

    <?php echo view('main/includes/leftmenu'); ?>

</div>






<?php  // echo view('main/products/projects'); ?>
<?php echo view('main/common/features'); ?>





<?php echo view('main/includes/clientsandreviews'); ?>



<?php echo view('main/includes/footer'); ?>


<?php echo view('main/includes/end'); ?>