<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div></div>
            <div class="portlet-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Confirm</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        if(count($all_data)){
                            foreach($all_data as $set_data){
                                $companyName = '-';
                                ?>
                                <tr>
                                    <td><?=$set_data->first_name.' '.$set_data->last_name;?></td>
                                    <td><?=$set_data->email;?></td>
                                    <td>
                                        <?php
                                        if($set_data->confirm=='confirm'){
                                            echo 'Confirm';
                                        }
                                        else{
                                            echo 'Not Confirm<br>';
                                            ?>
                                            <a href="<?=$_cancel?>/set_user/<?=$set_data->id?>">Set As User</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <select onchange="get_status('users',<?=$set_data->id;?>,this.value)" name="martial_id">
                                            <?php
                                            if($set_data->status==1){
                                                echo '<option selected="selected" value="1">Active</option>';
                                                echo '<option value="0">Inactive</option>';
                                            }
                                            else{
                                                echo '<option value="1">Active</option>';
                                                echo '<option selected="selected" value="0">Inactive</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>

                                    <td>
                                        <a class="btn btn-icon-only btn-info " href="<?=site_url().$_cancel.'/sendMail/'.$set_data->id;?>" data-toggle="tooltip" data-placement="top"  title="Send Mail" ><i class="fa fa-share"></i></a>
                                        <!--<a class="btn btn-icon-only btn-success " href="<?=$_cancel.'/edit/'.$set_data->id;?>" title="" ><i class="fa fa-edit"></i></a>-->
                                        <a class="btn btn-icon-only btn-danger" href="<?=site_url().$_delete?>/<?=$set_data->id;?>" data-toggle="tooltip" data-placement="top"  title="Delete"   onclick="return confirm_box();"><i class="fa fa-trash-o"></i></a>

                                    </td>
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



<script>
    function confirm_box(){
        var answer = confirm ("Are you sure?");
        if (!answer)
            return false;
    }


    function get_status(name,id,value){
        //alert(name+' '+id+' '+value);
        $.ajax({
            type: "POST",
            url: "<?=site_url().$_cancel?>/getStatus", /* The country id will be sent to this file */
            data: {id:id,status:value,<?=csrf_token();?>:'<?=csrf_hash();?>'},
            beforeSend: function () {
                $("#show_class").html("Loading ...");
            },
            success: function(msg){
                //alert(msg);
                //location.reload();
                $("#show_class").html(msg);
            }
        });
    }
</script>
