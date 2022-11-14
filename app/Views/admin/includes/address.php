<?php
if($session->getFlashdata('success')) {
    $msg = $session->getFlashdata('success');
    ?>
    <div class="alert alert-block alert-success fade in">
        <button data-dismiss="alert" class="close" type="button"></button>
        <?php echo $msg;?>
    </div>

    <?php
}
if($session->getFlashdata('error')) {
    $msg = $session->getFlashdata('error');
    ?>
    <div class="alert alert-block alert-danger fade in">
        <button data-dismiss="alert" class="close" type="button"></button>
        <?php echo $msg;?>
    </div>
    <?php
}
?>

