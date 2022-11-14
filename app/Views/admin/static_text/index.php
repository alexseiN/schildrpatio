<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div></div>
            <div class="portlet-body">

                <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-6 pull-right">
                        <input type="text" class="form-control search_static_text" autocomplete="off" name="search" placeholder="Search Title" >

                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="table-responsive">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <?php
                            $i=0;
                            foreach($ThisModule->languages_icon as $key_lang=>$val_lang){
                                $i++;
                                ?>
                                <th width="300px"><img src="<?php echo base_url('assets/uploads/language/thumbnails').'/'.$val_lang; ?>" height="15" width="20" ></th>
                                <?php
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody class="tbody-list">
                        <?php
                        if(count($all_data)){
                            foreach($all_data as $set_data){
                                $get_lang_value = $ThisModule->getLang($set_data->id, FALSE, $content_language_id);
                                ?>
                                <tr class="s-item" data-name="<?php echo $set_data->name; ?>">
                                    <td><?php echo $set_data->id; ?></td>
                                    <td><?php echo $set_data->name; ?></td>
                                    <?php $i=0;
                                    foreach($ThisModule->languages as $key_lang=>$val_lang){
                                        $i++;
                                        ?>
                                        <td><span class="xedit" id="<?=$get_lang_value->{'lid_'.$key_lang}; ?>" ><?=$get_lang_value->{'title_'.$key_lang}?></span></td>
                                        <?php
                                    }
                                    ?>
                                    <td><a class="btn btn-xs btn-danger" href="<?=site_url().$_cancel.'/delete/'.$set_data->id;?>"  onclick="return confirm_box();">
                                            <i class="fa fa-trash-o"></i></a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<link href="<?=site_url()?>assets/plugins/edittable/css/custom.css" rel="stylesheet" type="text/css">
<script src="<?=site_url()?>assets/plugins/edittable/js/bootstrap-editable.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        $.fn.editable.defaults.mode = 'popup';
        $('.xedit').editable();
        $(document).on('click','.editable-submit',function(){
            var x = $(this).closest('td').children('span').attr('id');
            var y = $('.input-sm').val();
            var z = $(this).closest('td').children('span');
            $.ajax({
                url: "<?=site_url().$_cancel?>/ajaxEdit",
                type: 'post',
                data:{id:x,data:y,<?=csrf_token();?>:'<?=csrf_hash();?>'},
                success: function(s){
                    if(s == 'status'){
                        $(z).html(y);}
                    if(s == 'error') {
                        alert('Please insert value!');
                    }
                },
                error: function(e){
                    alert('Error Processing your Request!!');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function(){
        $(".search_static_text").keyup(function(){
            var str = $(".search_static_text").val();
            var count = 0;
            $(".tbody-list .s-item").each(function(index){
                if($(this).attr("data-name")){
                    //case insenstive search
                    if(!$(this).attr("data-name").match(new RegExp(str, "i"))){
                        $(this).fadeOut("fast");
                    }else{
                        $(this).fadeIn("slow");
                        count++;
                    }
                }
            });
        });
    });
</script><!--search-->


<script>
    function confirm_box(){
        var answer = confirm ("Are you want to delete?");
        if (!answer)
            return false;
    }
</script>
