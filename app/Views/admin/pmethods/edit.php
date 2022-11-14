<?php
    $result_data = isset($id)?$thisItems[0]:$thisItems;
    $counter = 0;    
?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Form-->
            <?=view('admin/includes/common/errors')?>
            <?=form_open_multipart('', 'class="form d-flex flex-column flex-lg-row editform" id="editform" name="editform"')?>
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <?php foreach($postarrayelementswithinputs as $key=>$elements) { ?>
                            <!--begin::Input group-->
                            <?php
                                if($elements['type'] == 'checkbox'){
                                    $elements['type_data']['value'] = 1;
                                    $elements['type_data']['checked'] = ($result_data->{$key})?true:false;
                                    $class="form-check form-check-custom form-check-solid mb-2";
                                }
                                else {
                                    $elements['type_data']['value'] = $result_data->{$key};
                                    $class="mb-10 fv-row";
                                }
                            ?>
                            <div class="<?=$class?>">
                                <?php
                                    echo html_form_tags($elements);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <?php } ?>
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->
                    <?=view('admin/includes/common/button')?>
                </div>
                <!--end::Main column-->
            <?=form_close()?>
            <!--end::Form-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<script>
    //tagfunction();
</script>