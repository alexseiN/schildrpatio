<div class="form-group">
                    <label class="col-lg-2 control-label">Main Image</label>
                    <div class="col-lg-10">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 150px; height: 150px;">
                                <?php echo !isset($thisItems->image) ? '<img src="'.site_url().'assets/uploads/no-image.gif">' :'<img src="'.base_url($uploadFolder.'/small').'/'.$thisItems->image.'" >'; ?>
                            </div>
                            <div>
                            <?php if(!isset($thisItems->image)&&empty($thisItems->image)){ ?>
    						    <span class="btn btn-default btn-file">
    						        <span class="fileinput-new">Select Image</span>
    						        <span class="fileinput-exists">Change</span>
    			                    <input type="file" name="logo" id="logo">
    			                </span> 
			                 <?php } ?>
			                
			                
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                <?php if(isset($thisItems->image)&&!empty($thisItems->image)){
                                    echo '<a class="btn btn-default" href="'.site_url().$_cancel.'/removeImage/'.$thisItems->id.'" onclick="" >Remove</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>