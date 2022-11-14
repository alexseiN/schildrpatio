<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div></div>
            <div class="portlet-body">
                <?php
                if($_POST){
                    echo $validation->listErrors();
                }
                ?>
                <form class="form-horizontal" role="form" method="post">
                    <input type="hidden" name="<?=csrf_token(); ?>" value="<?=csrf_hash();?>" />
                    <div class="form-body">
                        <div class="form-group">
                            
                            <label class="col-lg-2 control-label">Facebook:  </label>
                            <div class="col-lg-10">
                                <?=form_input('facebook_url', set_value('facebook_url', isset($socials['facebook_url'])?$socials['facebook_url']:''), 'class="form-control" id="facebook_url" placeholder="Facebook url"')?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Instagram: </label>
                            <div class="col-lg-10">
                                <?=form_input('instagram_url', set_value('instagram_url',isset($socials['instagram_url'])?$socials['instagram_url']:''), 'class="form-control" id="google_plus" placeholder="Instagram url"')?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Linkedin: </label>
                            <div class="col-lg-10">
                                <?=form_input('linkedin_url', set_value('linkedin_url',isset($socials['linkedin_url'])?$socials['linkedin_url']:''), 'class="form-control" id="linkedin_url" placeholder="Linkedin Url"')?>
                            </div>
                        </div>
                        
        
                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Skype: </label>
                            <div class="col-lg-10">
                                <?=form_input('skype_url', set_value('skype_url',isset($socials['skype_url'])?$socials['skype_url']:''), 'class="form-control" id="skype_url" placeholder="Skype url"')?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label"> Twitter: </label>
                            <div class="col-lg-10">
                                <?=form_input('twitter_url', set_value('twitter_url',isset($socials['twitter_url'])?$socials['twitter_url']:''), 'class="form-control" id="twitter_url" placeholder="Twitter url"')?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Youtube: </label>
                            <div class="col-lg-10">
                                <?=form_input('youtube_url', set_value('youtube_url',isset($socials['youtube_url'])?$socials['youtube_url']:''), 'class="form-control" id="youtube_url" placeholder="Youtube url"')?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Whatsapp: </label>
                            <div class="col-lg-10">
                                <?=form_input('whatsapp_url', set_value('whatsapp_url',isset($socials['whatsapp_url'])?$socials['whatsapp_url']:''), 'class="form-control" id="whatsapp_url" placeholder="Whatsapp url"')?>
                            </div>
                        </div>

                
                    </div>
                    
                    <hr>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <button type="submit" class="btn btn-primary btn-label-left">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

