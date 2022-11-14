<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div></div>
            <div class="portlet-body">
                
                <?php 
                
               // yoxla($templates_page);
               // die();
                
                
                ?>
                
                

                <?php
                    if($_POST) {
                        echo $validation->listErrors();
                    }
                ?>

                <?=form_open('', array('class' => 'form-horizontal edit-form', 'role'=>'form','enctype'=>"multipart/form-data"))?>                        
                
                
                <div class="form-body">
                    
                <div class="form-group">
                    <label class="col-lg-2 control-label">Template</label>
                    <div class="col-lg-10">
                       
                        
                        <?php echo form_dropdown('template', $templates_page,$thisItems->template, 'class="form-control" '); ?>
                        
                    </div>
                </div>


                    <div style="margin-bottom: 0px;" class="tabbable">
                        <ul class="nav nav-tabs">
                            <?php $i=0;
                            foreach($ThisModule->languages_icon as $key_lang=>$val_lang):

                                $i++;?>
                                <li class="<?=$i==1?'active':''?>">
                                    <a data-toggle="tab" href="#<?=$key_lang?>"><img src="<?php echo base_url('assets/uploads/language/full').'/'.$val_lang; ?>" height="15" width="20" ></a></li>
                            <?php endforeach;?>
                        </ul>
                        <div style="padding-top: 9px; border-bottom: 1px solid #ddd;" class="tab-content">
                            <?php $i=0;foreach($ThisModule->languages as $key_lang=>$val_lang):$i++;?>
                                <div id="<?=$key_lang?>" class="tab-pane <?=$i==1?'active':''?>">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Title</label>
                                        <div class="col-lg-10">
                                            <?=form_input('title_'.$key_lang, html_entity_decode(set_value('title_'.$key_lang, $thisItems->{'title_'.$key_lang})), 'class="form-control copy_to_next" id="inputTitle'.$key_lang.'" placeholder="'.lang('Title').'"')?>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                    <label class="col-lg-2 control-label">Description</label>
                                    <div class="col-lg-10">
                                        <?=form_textarea('description_'.$key_lang, html_entity_decode(set_value('description_'.$key_lang, $thisItems->{'description_'.$key_lang})), 'rows="3" class="form-control"')?>
                                    </div>
                                </div>

                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-9">
                            <button type="submit" class="btn btn-primary submitBtn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Save">Save</button>
                            <a href="<?=site_url().$_cancel.'/l/'.$thisItems->category_id;?>" class="btn btn-default" type="button">Cancel</a>
                      
                        </div>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
        <!-- end panel -->
    </div>
    
     <?php echo view('admin/includes/more_images'); ?> 
    
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
