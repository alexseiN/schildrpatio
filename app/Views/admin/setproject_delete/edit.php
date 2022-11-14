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
                <?php
                if($_POST) {
                    echo $validation->listErrors();
                }
                ?>
                <?=form_open('', array('class' => 'form-horizontal edit-form', 'role'=>'form','enctype'=>"multipart/form-data"))?>
                <div id="more_pic" style="display:none"></div>

                
                <?php 
                
             //  echo '<pre>';
                //print_r($all_branches);
               // die();
                
                ?>
                
                
                
                
                
              
                
                
               
                
                    <?=select_employees($thisItems->{'employee'},'Employees','employee','first_name','last_name',array('rep'=>1))?>
                
                
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Project name</label>
                        <div class="col-lg-10">
                            <?=form_input('project', set_value('project', $thisItems->{'project'}), 'class="form-control " id="" placeholder="Project name"')?>
                        </div>
                    </div>
                
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Client</label>
                        <div class="col-lg-10">
                            <?=form_input('buyer', html_entity_decode(set_value('buyer', $thisItems->{'buyer'})), 'class="form-control " id="" placeholder="Name Surname"')?>
                        </div>
                    </div>
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Adress or zipcode</label>
                        <div class="col-lg-10">
                            <?=form_input('address', set_value('address', $thisItems->{'address'}), 'class="form-control " id="" placeholder="Address"')?>
                        </div>
                    </div>
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Client's phone</label>
                        <div class="col-lg-10">
                            <?=form_input('phone', set_value('phone', $thisItems->{'phone'}), 'class="form-control " id="" placeholder="Phone"')?>
                        </div>
                    </div>
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Client's email</label>
                        <div class="col-lg-10">
                            <?=form_input('email', set_value('email', $thisItems->{'email'}), 'class="form-control " id="" placeholder="Email"')?>
                        </div>
                    </div>
                                    
                    
                                    
                
                    
                

                <hr />

                
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-9">
                            <button type="submit" class="btn btn-primary submitBtn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Save">Save</button>
                            <a href="<?=site_url().$_cancel?>" class="btn btn-default" type="button">Cancel</a>
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
    $('.cleditor2').summernote({height: 300});
</script>






