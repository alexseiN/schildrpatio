<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div></div>
            <div class="portlet-body">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-6">
                        <div class="btn-group">

                            <a href="<?=site_url().$_edit.'/'.$c_id?>" class="btn btn-primary m-r-5 m-b-5">
                                Add New <i class="fa fa-plus"></i>
                            </a>
                            <input type="button" id="save" value="Save" class="btn btn-success" />

                        </div>
                    </div>
                </div>
                <p class="alert alert-info">Drag to data and then click 'Save'</p>
                <div id="orderResult" style=""></div>
            </div>
            <!--end panel-body-->
        </div>
    </div>
</div>


<script>
    function confirm_box(){
        var answer = confirm ("Confirm");
        if (!answer)
            return false;
    }
</script>


<script src="<?=site_url()?>assets/admin/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<link href="<?=site_url()?>assets/plugins/nestedsortable/css/admin.css" rel="stylesheet">
<script src="<?=site_url()?>assets/plugins/nestedsortable/jquery.mjs.nestedSortable.js"></script>

<script>
    $(function(){
        $.get('<?=site_url($_cancel.'/orderAjax/'.$c_id)?>', {'category_id':'<?=$c_id?>'}, function(data){
            $('#orderResult').html(data);
        });

        $('#save').click(function(){
            oSortable = $('.sortable').nestedSortable('toArray');

            $('#orderResult').slideUp(function(){
                $.post('<?php echo site_url($_cancel.'/orderAjax/'.$c_id); ?>', { sortable: oSortable ,<?=csrf_token();?>:'<?=csrf_hash();?>'}, function(data){
                    $('#orderResult').html(data);
                    $('#orderResult').slideDown();
                });
            });
        });
    })
</script>

<style>
    .options {
        background: none !important;
        border: none !important;
        padding: 0px !important;
    }

    .sortable li div{
        height:35px;
    }
</style>
