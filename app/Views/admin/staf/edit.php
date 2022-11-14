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
                <?=form_open('', array('class' => 'form-horizontal', 'role'=>'form','enctype'=>"multipart/form-data"))?> 
                <div class="form-body">
                   

                    <?=select_existing_only($all_branches,$thisItems->{'branch_id'},'Branches','branch_id','name')?>

                    <hr />

                    <div class="form-group" >
                        <label class="col-lg-2 control-label">First Name</label>
                        <div class="col-lg-10">
                            <?=form_input('first_name', set_value('first_name', $thisItems->{'first_name'}), 'class="form-control " id="" placeholder="First Name"')?>
                        </div>
                    </div>
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Last Name</label>
                        <div class="col-lg-10">
                            <?=form_input('last_name', set_value('last_name', $thisItems->{'last_name'}), 'class="form-control " id="" placeholder="Last Name"')?>
                        </div>
                    </div>
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Position</label>
                        <div class="col-lg-10">
                            <?=form_input('position', set_value('position', $thisItems->{'position'}), 'class="form-control " id="" placeholder="Position"')?>
                        </div>
                    </div>
                    
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <?=form_input('email', set_value('email', $thisItems->{'email'}), 'class="form-control " id="" placeholder="Email"')?>
                        </div>
                    </div>
                    
                    <div class="form-group" >
                        <label class="col-lg-2 control-label">Phone</label>
                        <div class="col-lg-10">
                            <?=form_input('mobile', set_value('mobile', $thisItems->{'mobile'}), 'class="form-control " id="" placeholder="Phone"')?>
                        </div>
                    </div>
                  
                
                    
                   
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-9">
                            <?=form_submit('submit', 'Save', 'class="btn btn-primary"')?>
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




