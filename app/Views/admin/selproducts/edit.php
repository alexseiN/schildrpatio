<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div></div>
            <div class="portlet-body">

                <?php
                    if($_POST) {
                        echo $validation->listErrors();
                    }
                ?>

                <?=form_open('', array('class' => 'form-horizontal edit-form', 'role'=>'form','enctype'=>"multipart/form-data"))?>                        <div class="form-body">
                    
                    
                    <?=select_existing_only($all_products,$thisItems->{'sproduct'},'Select product','sproduct','title')?>
                    
                    
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Description</label>
                        <div class="col-lg-10">
                            <?=form_input('description', set_value('description', $thisItems->{'description'}), 'class="form-control " id="" placeholder="Description"')?>
                        </div>
                    </div>
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Dimensions</label>
                        <div class="col-lg-10">
                            <?=form_input('dimensions', set_value('dimensions', $thisItems->{'dimensions'}), 'class="form-control " id="" placeholder="Dimensions"')?>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Quantity</label>
                        <div class="col-lg-10">
                            <?=form_input('qty', set_value('qty', $thisItems->{'qty'}), 'class="form-control " id="" placeholder="Quantity"')?>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Structure Color</label>
                        <div class="col-lg-10">
                            <?=form_input('scolor', set_value('scolor', $thisItems->{'scolor'}), 'class="form-control " id="" placeholder="Structure Color"')?>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Lover/Fabric color</label>
                        <div class="col-lg-10">
                            <?=form_input('fcolor', set_value('fcolor', $thisItems->{'fcolor'}), 'class="form-control " id="" placeholder="Fabric color"')?>
                        </div>
                    </div>
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Additional</label>
                        <div class="col-lg-10">
                            <?=form_input('additional', set_value('additional', $thisItems->{'additional'}), 'class="form-control " id="" placeholder="Additional"')?> 
                        </div>
                    </div>
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Motor/Automation</label>
                        <div class="col-lg-10">
                            <?=form_input('motorauto', set_value('motorauto', $thisItems->{'motorauto'}), 'class="form-control " id="" placeholder="Motor/Automation"')?> 
                        </div>
                    </div>
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Unit Price</label>
                        <div class="col-lg-10">
                            <?=form_input('uprice', set_value('uprice', $thisItems->{'uprice'}), 'class="form-control " id="" placeholder="Unit Price"')?> 
                        </div>
                    </div>
                    
                   


                   
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-9">
                            <button type="submit" class="btn btn-primary submitBtn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Save">Save</button>
                            <a href="<?=site_url().$_cancel;?>" class="btn btn-default" type="button">Cancel</a>
                      
                        </div>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
        <!-- end panel -->
    </div>
</div>


<link href="<?=site_url()?>assets/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="<?=site_url()?>assets/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js" type="text/javascript" language="javascript"></script>


<script>
    $('.edit-form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
    $(document).ready(function () {
        $(".edit-form").submit(function () {
            $(".submitBtn").button('loading');
            return true;
        });
    });
</script>
