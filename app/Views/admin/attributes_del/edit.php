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
                <div class="form-group">
                    <label class="col-md-2 control-label">Section name</label>
                    <div class="col-md-10">
                        <div class="checkbox">
                            <label style="margin-top:9px">
                                <?=form_checkbox('section', '1', $form_data->section? true:false, 'id="inputDefault" class=""')?>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-body">
                    <div style="margin-bottom: 0px;" class="tabbable">
                        <ul class="nav nav-tabs">
                            <?php $i=0;
                            foreach($AttributesModel->languages_icon as $key_lang=>$val_lang):

                                $i++;?>
                                <li class="<?=$i==1?'active':''?>">
                                    <a data-toggle="tab" href="#<?=$key_lang?>"><img src="<?php echo base_url('assets/uploads/language').'/'.$val_lang; ?>" height="15" width="20" ></a></li>
                            <?php endforeach;?>
                        </ul>
                        <div style="padding-top: 9px; border-bottom: 1px solid #ddd;" class="tab-content">
                            <?php $i=0;foreach($AttributesModel->languages as $key_lang=>$val_lang):$i++;?>
                                <div id="<?=$key_lang?>" class="tab-pane <?=$i==1?'active':''?>">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Title</label>
                                        <div class="col-lg-10">
                                            <?=form_input('title_'.$key_lang, set_value('title_'.$key_lang, $form_data->{'title_'.$key_lang}), 'class="form-control copy_to_next" id="inputTitle'.$key_lang.'" placeholder="'.lang('Title').'"')?>
                                        </div>
                                    </div>

                                    <?php /*?><div class="form-group">
	    	                          <label class="col-lg-2 control-label"><?=show_static_text($adminLangSession['lang_id'],267);?></label>
    	    	                      <div class="col-lg-10">
                	                	<?=form_input('l_slug_'.$key_lang, set_value('l_slug_'.$key_lang, $form_data->{'l_slug_'.$key_lang}), 'class="form-control " placeholder="Slug"')?>
                    		          </div>
                            		</div><?php */?>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-9">
                            <button type="submit" class="btn btn-primary submitBtn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Save">Save</button>
                            <a href="<?=site_url().$_cancel;?>" class="btn btn-default" type="button">Cancel</a>
                            <!--<button type="button" class="btn default">Cancl</button>-->
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
//        $(".submitBtn").attr("disabled", true);
            $(".submitBtn").button('loading');
            return true;
        });
    });
</script>
